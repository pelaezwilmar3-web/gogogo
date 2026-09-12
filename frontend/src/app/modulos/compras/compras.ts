import { CommonModule } from '@angular/common';
import { Component, OnInit, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Compra } from '../../servicios/compra';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-compras',
  imports: [CommonModule, FormsModule],
  templateUrl: './compras.html',
  styleUrl: './compras.css',
})
export class Compras implements OnInit {
  compras = signal<any[]>([]);
  mostrarFormulario = false;
  idEditando: number | null = null;
  formulario = this.formularioVacio();
  error = '';

  constructor(private scompra: Compra) {}

  ngOnInit(): void {
    this.consulta();
  }

  consulta(): void {
    this.scompra.consulta().subscribe({
      next: (resultado) => this.compras.set(Array.isArray(resultado) ? resultado : []),
      error: () => this.error = 'No se pudieron cargar las compras.',
    });
  }

  formularioVacio(): any {
    return { fecha: '', cantidad: '', subtotal: '', total: '', impuesto: '', fo_usuario: '', fo_proveedor: '', fo_vehiculo: '' };
  }

  nuevo(): void {
    this.idEditando = null;
    this.formulario = this.formularioVacio();
    this.error = '';
    this.mostrarFormulario = true;
  }

  editar(item: any): void {
    this.idEditando = Number(item.id_compra);
    this.formulario = { ...item };
    this.error = '';
    this.mostrarFormulario = true;
  }

  guardar(): void {
    const datos = {
      fecha: this.formulario.fecha,
      cantidad: Number(this.formulario.cantidad),
      subtotal: Number(this.formulario.subtotal),
      total: Number(this.formulario.total),
      impuesto: Number(this.formulario.impuesto),
      fo_usuario: Number(this.formulario.fo_usuario),
      fo_proveedor: Number(this.formulario.fo_proveedor),
      fo_vehiculo: Number(this.formulario.fo_vehiculo),
    };

    if (!datos.fecha || !datos.cantidad || !datos.subtotal || !datos.total || !datos.impuesto || !datos.fo_usuario || !datos.fo_proveedor || !datos.fo_vehiculo) {
      Swal.fire('Datos incompletos', 'Completa todos los campos con valores válidos.', 'warning');
      return;
    }

    const solicitud = this.idEditando === null
      ? this.scompra.insertar(datos)
      : this.scompra.editar(this.idEditando, datos);

    solicitud.subscribe({
      next: (respuesta: any) => {
        if (respuesta?.resultado === 'ERROR') {
          Swal.fire('No se pudo insertar', respuesta.mensaje, 'error');
          return;
        }
        this.mostrarFormulario = false;
        this.consulta();
        Swal.fire('Éxito', respuesta?.mensaje ?? 'Compra guardada correctamente.', 'success');
      },
      error: (error) => {
        this.error = 'No se pudo insertar la compra.';
        Swal.fire('Error', error.error?.mensaje ?? this.error, 'error');
      },
    });
  }

  eliminar(id: number): void {
    Swal.fire({
      title: '¿Eliminar compra?',
      text: 'Esta acción no se puede deshacer.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((resultado) => {
      if (!resultado.isConfirmed) return;
      this.scompra.eliminar(id).subscribe({
        next: (respuesta: any) => {
          if (respuesta?.resultado === 'ERROR') {
            Swal.fire('No se pudo eliminar', respuesta.mensaje, 'error');
            return;
          }
          this.consulta();
          Swal.fire('Eliminada', respuesta?.mensaje ?? 'Compra eliminada correctamente.', 'success');
        },
        error: (error) => {
          this.error = 'No se pudo eliminar la compra.';
          Swal.fire('Error', error.error?.mensaje ?? this.error, 'error');
        },
      });
    });
  }
}

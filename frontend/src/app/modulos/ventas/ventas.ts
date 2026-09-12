import { CommonModule } from '@angular/common';
import { Component, OnInit, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Venta } from '../../servicios/venta';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-ventas',
  imports: [CommonModule, FormsModule],
  templateUrl: './ventas.html',
  styleUrl: './ventas.css',
})
export class Ventas implements OnInit {
  ventas = signal<any[]>([]);
  mostrarFormulario = false;
  idEditando: number | null = null;
  error = '';
  formulario: any = this.formularioVacio();

  constructor(private sventa: Venta) {}

  ngOnInit(): void { this.consulta(); }

  formularioVacio(): any {
    return { fecha: '', cantidad: '', precio: '', subtotales: '', subtotal_final: '', iva: '', total: '', fo_cliente: '', fo_usuario: '', fo_vehiculo: '' };
  }

  consulta(): void {
    this.sventa.consulta().subscribe({
      next: (resultado) => this.ventas.set(Array.isArray(resultado) ? resultado : []),
      error: () => this.error = 'No se pudieron cargar las ventas.',
    });
  }

  nuevo(): void {
    this.idEditando = null;
    this.formulario = this.formularioVacio();
    this.mostrarFormulario = true;
  }

  editar(item: any): void {
    this.idEditando = Number(item.id_venta);
    this.formulario = { ...item };
    this.mostrarFormulario = true;
  }

  guardar(): void {
    const solicitud = this.idEditando === null ? this.sventa.insertar(this.formulario) : this.sventa.editar(this.idEditando, this.formulario);
    solicitud.subscribe({
      next: (respuesta: any) => {
        if (respuesta?.resultado === 'ERROR') {
          Swal.fire('No se pudo guardar', respuesta.mensaje, 'error');
          return;
        }
        this.mostrarFormulario = false;
        this.consulta();
        Swal.fire('Éxito', respuesta?.mensaje ?? 'Venta guardada correctamente.', 'success');
      },
      error: (error) => {
        this.error = 'No se pudo guardar la venta.';
        Swal.fire('Error', error.error?.mensaje ?? this.error, 'error');
      },
    });
  }

  eliminar(id: number): void {
    Swal.fire({
      title: '¿Eliminar venta?',
      text: 'Esta acción no se puede deshacer.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((resultado) => {
      if (!resultado.isConfirmed) return;
      this.sventa.eliminar(id).subscribe({
        next: (respuesta: any) => {
          if (respuesta?.resultado === 'ERROR') {
            Swal.fire('No se pudo eliminar', respuesta.mensaje, 'error');
            return;
          }
          this.consulta();
          Swal.fire('Eliminada', respuesta?.mensaje ?? 'Venta eliminada correctamente.', 'success');
        },
        error: (error) => {
          this.error = 'No se pudo eliminar la venta.';
          Swal.fire('Error', error.error?.mensaje ?? this.error, 'error');
        },
      });
    });
  }
}

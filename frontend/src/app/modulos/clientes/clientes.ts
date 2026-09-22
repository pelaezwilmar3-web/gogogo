import { CommonModule } from '@angular/common';
import { Component, OnInit, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Cliente } from '../../servicios/cliente';
import { Ciudad } from '../../servicios/ciudad';
import { Dpto } from '../../servicios/dpto';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-clientes',
  imports: [CommonModule, FormsModule],
  templateUrl: './clientes.html',
  styleUrls: ['./clientes.css'],
})
export class Clientes implements OnInit {

  clientes = signal<any[]>([]);
  mostrarFormulario = false;
  idEditando: number | null = null;
  formulario = this.formularioVacio();
  error = '';
  departamentos: any[] = [];
  ciudades: any[] = [];
  ciudadesDisponibles: any[] = [];

  constructor(private scli: Cliente, private sciudad: Ciudad, private sdpto: Dpto) {}

  ngOnInit(): void {
    this.consulta();
    this.cargarCatalogos();
  }

  consulta(): void {
    this.scli.consulta().subscribe({
      next: (resultado) => {
        this.clientes.set(Array.isArray(resultado) ? resultado : []);
      },
      error: (error) => {
        console.error('Error al consultar clientes:', error);
        this.error = 'No se pudieron cargar los clientes.';
      },
    });
  }

  formularioVacio(): any {
    return { identificacion: '', nombre: '', direccion: '', celular: '', email: '', fo_dpto: '', fo_ciudad: '' };
  }

  cargarCatalogos(): void {
    this.sdpto.consulta().subscribe({
      next: (resultado: any) => this.departamentos = Array.isArray(resultado) ? resultado : [],
      error: () => this.error = 'No se pudieron cargar los departamentos.',
    });
    this.sciudad.consulta().subscribe({
      next: (resultado: any) => {
        this.ciudades = Array.isArray(resultado) ? resultado : [];
        this.actualizarCiudades();
      },
      error: () => this.error = 'No se pudieron cargar las ciudades.',
    });
  }

  nuevo(): void {
    this.idEditando = null;
    this.formulario = this.formularioVacio();
    this.ciudadesDisponibles = [];
    this.error = '';
    this.mostrarFormulario = true;
  }

  editar(item: any): void {
    this.idEditando = Number(item.id_cliente);
    this.formulario = { ...item };
    this.formulario.fo_dpto = item.fo_dpto ?? '';
    this.actualizarCiudades();
    this.error = '';
    this.mostrarFormulario = true;
  }

  actualizarCiudades(): void {
    const departamento = Number(this.formulario.fo_dpto);
    this.ciudadesDisponibles = this.ciudades.filter((ciudad) => Number(ciudad.fo_dpto) === departamento);
    if (!this.ciudadesDisponibles.some((ciudad) => Number(ciudad.id_ciudad) === Number(this.formulario.fo_ciudad))) {
      this.formulario.fo_ciudad = '';
    }
  }

  guardar(): void {
    const datos = {
      identificacion: this.formulario.identificacion?.trim(),
      nombre: this.formulario.nombre?.trim(),
      direccion: this.formulario.direccion?.trim(),
      celular: this.formulario.celular?.trim(),
      email: this.formulario.email?.trim(),
      fo_ciudad: Number(this.formulario.fo_ciudad),
    };

    if (!datos.identificacion || !datos.nombre || !datos.direccion || !datos.celular || !datos.email || !datos.fo_ciudad) {
      Swal.fire('Datos incompletos', 'Completa todos los campos y usa un ID de ciudad válido.', 'warning');
      return;
    }

    const solicitud = this.idEditando === null
      ? this.scli.insertar(datos)
      : this.scli.editar(this.idEditando, datos);

    solicitud.subscribe({
      next: (respuesta: any) => {
        if (respuesta?.resultado === 'ERROR') {
          Swal.fire('No se pudo guardar', respuesta.mensaje, 'error');
          return;
        }
        this.mostrarFormulario = false;
        this.consulta();
        Swal.fire('Éxito', respuesta?.mensaje ?? 'Cliente guardado correctamente.', 'success');
      },
      error: (error) => {
        this.error = 'No se pudo guardar el cliente.';
        Swal.fire('No se pudo guardar', error.error?.mensaje ?? this.error, 'error');
      },
    });
  }

  eliminar(id: number): void {
    Swal.fire({
      title: '¿Eliminar cliente?',
      text: 'Esta acción no se puede deshacer.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((resultado) => {
      if (!resultado.isConfirmed) return;
      this.scli.eliminar(id).subscribe({
        next: (respuesta: any) => {
          if (respuesta?.resultado === 'ERROR') {
            Swal.fire('No se pudo eliminar', respuesta.mensaje, 'error');
            return;
          }
          this.consulta();
          Swal.fire('Eliminado', respuesta?.mensaje ?? 'Cliente eliminado correctamente.', 'success');
        },
        error: (error) => {
          this.error = 'No se pudo eliminar el cliente.';
          Swal.fire('No se pudo eliminar', error.error?.mensaje ?? this.error, 'error');
        },
      });
    });
  }
}

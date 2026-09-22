import { CommonModule } from '@angular/common';
import { Component, OnInit, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Vehiculo } from '../../servicios/vehiculo';
import { Marca } from '../../servicios/marca';
import { Modelo } from '../../servicios/modelo';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-vehiculos',
  imports: [CommonModule, FormsModule],
  templateUrl: './vehiculos.html',
  styleUrl: './vehiculos.css',
})
export class Vehiculos implements OnInit {
  vehiculos = signal<any[]>([]);
  mostrarFormulario = false;
  idEditando: number | null = null;
  error = '';
  formulario: any = this.formularioVacio();
  marcas: any[] = [];
  modelos: any[] = [];
  modelosDisponibles: any[] = [];

  constructor(private svehiculo: Vehiculo, private smarca: Marca, private smodelo: Modelo) {}

  ngOnInit(): void {
    this.consulta();
    this.cargarCatalogos();
  }

  formularioVacio(): any {
    return { serial: '', año: '', color: '', precio: '', fecha_ingreso: '', fo_marca: '', fo_modelo: '' };
  }

  consulta(): void {
    this.svehiculo.consulta().subscribe({
      next: (resultado) => this.vehiculos.set(Array.isArray(resultado) ? resultado : []),
      error: () => this.error = 'No se pudieron cargar los vehículos.',
    });
  }

  cargarCatalogos(): void {
    this.smarca.consulta().subscribe({
      next: (resultado: any) => this.marcas = Array.isArray(resultado) ? resultado : [],
      error: () => this.error = 'No se pudieron cargar las marcas.',
    });
    this.smodelo.consulta().subscribe({
      next: (resultado: any) => {
        this.modelos = Array.isArray(resultado) ? resultado : [];
        this.actualizarModelos();
      },
      error: () => this.error = 'No se pudieron cargar los modelos.',
    });
  }

  nuevo(): void {
    this.idEditando = null;
    this.formulario = this.formularioVacio();
    this.modelosDisponibles = [];
    this.mostrarFormulario = true;
  }

  editar(item: any): void {
    this.idEditando = Number(item.id_vehiculo);
    this.formulario = { ...item };
    this.actualizarModelos();
    this.mostrarFormulario = true;
  }

  actualizarModelos(): void {
    const modelosRenault = [1, 3, 4, 6, 7, 8];
    const modelosVolkswagen = [2, 5, 9, 10, 11, 12];
    const modelosValidos = Number(this.formulario.fo_marca) === 1
      ? modelosVolkswagen
      : Number(this.formulario.fo_marca) === 2 ? modelosRenault : [];

    this.modelosDisponibles = this.modelos.filter((modelo) => modelosValidos.includes(Number(modelo.id_modelo)));
    if (!modelosValidos.includes(Number(this.formulario.fo_modelo))) {
      this.formulario.fo_modelo = '';
    }
  }

  guardar(): void {
    const datos = {
      serial: this.formulario.serial?.trim(),
      año: Number(this.formulario['año']),
      color: this.formulario.color?.trim(),
      precio: Number(this.formulario.precio),
      fecha_ingreso: this.formulario.fecha_ingreso,
      fo_marca: Number(this.formulario.fo_marca),
      fo_modelo: Number(this.formulario.fo_modelo),
    };

    const modelosRenault = [1, 3, 4, 6, 7, 8];
    const modelosVolkswagen = [2, 5, 9, 10, 11, 12];
    const modelosValidos = datos.fo_marca === 1 ? modelosVolkswagen : datos.fo_marca === 2 ? modelosRenault : [];

    if (!datos.serial || !datos.año || !datos.color || !datos.precio || !datos.fecha_ingreso || !datos.fo_marca || !datos.fo_modelo) {
      Swal.fire('Datos incompletos', 'Completa todos los campos con valores válidos.', 'warning');
      return;
    }

    if (!modelosValidos.includes(datos.fo_modelo)) {
      Swal.fire('Modelo no válido', 'El modelo seleccionado no pertenece a la marca indicada.', 'error');
      return;
    }

    const solicitud = this.idEditando === null ? this.svehiculo.insertar(datos) : this.svehiculo.editar(this.idEditando, datos);
    solicitud.subscribe({
      next: (respuesta: any) => {
        if (respuesta?.resultado === 'ERROR') {
          Swal.fire('No se pudo guardar', respuesta.mensaje, 'error');
          return;
        }
        this.mostrarFormulario = false;
        this.consulta();
        Swal.fire('Éxito', respuesta?.mensaje ?? 'Vehículo guardado correctamente.', 'success');
      },
      error: (error) => {
        this.error = 'No se pudo guardar el vehículo.';
        Swal.fire('Error', error.error?.mensaje ?? this.error, 'error');
      },
    });
  }

  eliminar(id: number): void {
    Swal.fire({
      title: '¿Eliminar vehículo?',
      text: 'Esta acción no se puede deshacer.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((resultado) => {
      if (!resultado.isConfirmed) return;
      this.svehiculo.eliminar(id).subscribe({
        next: (respuesta: any) => {
          if (respuesta?.resultado === 'ERROR') {
            Swal.fire('No se pudo eliminar', respuesta.mensaje, 'error');
            return;
          }
          this.consulta();
          Swal.fire('Eliminado', respuesta?.mensaje ?? 'Vehículo eliminado correctamente.', 'success');
        },
        error: (error) => {
          this.error = 'No se pudo eliminar el vehículo.';
          Swal.fire('Error', error.error?.mensaje ?? this.error, 'error');
        },
      });
    });
  }
}

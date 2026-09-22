import { CommonModule } from '@angular/common';
import { Component, OnInit, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Compra } from '../../servicios/compra';
import { Marca } from '../../servicios/marca';
import { Modelo } from '../../servicios/modelo';
import { Proveedor } from '../../servicios/proveedor';
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
  marcas: any[] = [];
  modelos: any[] = [];
  modelosDisponibles: any[] = [];
  proveedores: any[] = [];

  constructor(private scompra: Compra, private smarca: Marca, private smodelo: Modelo, private sproveedor: Proveedor) {}

  ngOnInit(): void {
    this.consulta();
    this.smarca.consulta().subscribe((resultado: any) => this.marcas = Array.isArray(resultado) ? resultado : []);
    this.smodelo.consulta().subscribe((resultado: any) => this.modelos = Array.isArray(resultado) ? resultado : []);
    this.sproveedor.consulta().subscribe((resultado: any) => this.proveedores = Array.isArray(resultado) ? resultado : []);
  }

  consulta(): void {
    this.scompra.consulta().subscribe({
      next: (resultado) => this.compras.set(Array.isArray(resultado) ? resultado : []),
      error: () => this.error = 'No se pudieron cargar las compras.',
    });
  }

  formularioVacio(): any {
    return { fecha: '', cantidad: '', subtotal: '', total: '', impuesto: '', fo_usuario: '', fo_proveedor: '', serial: '', año: '', color: '', precio: '', fecha_ingreso: '', fo_marca: '', fo_modelo: '' };
  }

  nuevo(): void {
    this.idEditando = null;
    this.formulario = this.formularioVacio();
    this.error = '';
    this.mostrarFormulario = true;
  }

  actualizarModelos(): void {
    const marca = Number(this.formulario.fo_marca);
    const modelosRenault = [1, 3, 4, 6, 7, 8];
    const modelosVolkswagen = [2, 5, 9, 10, 11, 12];
    const validos = marca === 1 ? modelosVolkswagen : marca === 2 ? modelosRenault : [];
    this.modelosDisponibles = this.modelos.filter((modelo) => validos.includes(Number(modelo.id_modelo)));
    if (!validos.includes(Number(this.formulario.fo_modelo))) this.formulario.fo_modelo = '';
  }

  calcularTotales(): void {
    const precio = Number(this.formulario.subtotal);
    const cantidad = Number(this.formulario.cantidad);
    if (!Number.isFinite(precio) || precio < 0 || !Number.isFinite(cantidad) || cantidad <= 0) {
      this.formulario.impuesto = '';
      this.formulario.total = '';
      return;
    }

    const subtotal = Number((precio * cantidad).toFixed(2));
    this.formulario.impuesto = Number((subtotal * 0.19).toFixed(2));
    this.formulario.total = Number((subtotal + this.formulario.impuesto).toFixed(2));
  }

  editar(item: any): void {
    this.idEditando = Number(item.id_compra);
    this.formulario = { ...item };
    this.error = '';
    this.mostrarFormulario = true;
  }

  guardar(): void {
    const sesion = JSON.parse(sessionStorage.getItem('usuario') ?? 'null');
    const precioUnitario = Number(this.formulario.subtotal);
    const cantidad = Number(this.formulario.cantidad);
    const subtotal = Number((precioUnitario * cantidad).toFixed(2));
    const datos = {
      fecha: this.formulario.fecha,
      cantidad,
      subtotal,
      total: Number(this.formulario.total),
      impuesto: Number(this.formulario.impuesto),
      fo_usuario: Number(this.formulario.fo_usuario || sesion?.id || sesion?.id_usuario),
      fo_proveedor: Number(this.formulario.fo_proveedor),
      serial: this.formulario.serial?.trim(),
      año: Number(this.formulario['año']),
      color: this.formulario.color?.trim(),
      precio: Number(this.formulario.precio || this.formulario.subtotal),
      fecha_ingreso: this.formulario.fecha_ingreso,
      fo_marca: Number(this.formulario.fo_marca),
      fo_modelo: Number(this.formulario.fo_modelo),
    };

    const camposFaltantes: string[] = [];
    if (!datos.fecha) camposFaltantes.push('fecha');
    if (!Number.isInteger(datos.cantidad) || datos.cantidad <= 0) camposFaltantes.push('cantidad');
    if (!Number.isFinite(datos.subtotal) || datos.subtotal < 0) camposFaltantes.push('subtotal');
    if (!Number.isFinite(datos.impuesto) || datos.impuesto < 0) camposFaltantes.push('impuesto');
    if (!Number.isFinite(datos.total) || datos.total < 0) camposFaltantes.push('total');
    if (!datos.fo_usuario) camposFaltantes.push('usuario de sesión');
    if (!datos.fo_proveedor) camposFaltantes.push('proveedor');
    if (!datos.serial) camposFaltantes.push('serial');
    if (!datos.año) camposFaltantes.push('año');
    if (!datos.color) camposFaltantes.push('color');
    if (!Number.isFinite(datos.precio) || datos.precio <= 0) camposFaltantes.push('precio');
    if (!datos.fecha_ingreso) camposFaltantes.push('fecha de ingreso');
    if (!datos.fo_marca) camposFaltantes.push('marca');
    if (!datos.fo_modelo) camposFaltantes.push('modelo');

    if (camposFaltantes.length) {
      Swal.fire('Datos incompletos', `Completa: ${camposFaltantes.join(', ')}.`, 'warning');
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

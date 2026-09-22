import { CommonModule, CurrencyPipe } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { Pedido } from '../../servicios/pedido';
import { Cliente } from '../../servicios/cliente';

@Component({
  selector: 'app-pedidoinsertar',
  imports: [CommonModule, CurrencyPipe, FormsModule],
  templateUrl: './pedidoinsertar.html',
  styleUrl: './pedidoinsertar.css',
})
export class Pedidoinsertar {

  vehiculo: any;
  cliente: any;
  ident_cliente = "";
  nombre_cliente = "";
  mensaje_error = "";
  matriz_vehiculo: any[] = [];
  Arreglo_vehiculos: any[] = [];
  vehiculosSeleccionados = new Set<number>();
  subtotal = 0;
  iva = 0;
  total: any = 0;
  pedido = {
    fecha: "",
    fo_cliente: 0,
    vehiculos: [] as any[],
    subtotal: 0,
    total: 0,
    fo_usuario: 0
  }

  constructor(
    private router: Router, private scliente: Cliente, private spedido: Pedido
  ) {}

  ngOnInit(): void {
    this.consulta_vehiculos();
  }

  consulta_vehiculos() {
    this.spedido.disponibles().subscribe((result: any) => {
      this.vehiculo = result;
    })
  }

  consulta_cliente() {
    if (!this.ident_cliente.trim()) {
      this.cliente = null;
      this.nombre_cliente = "";
      return;
    }

    this.scliente.ccliente(this.ident_cliente).subscribe((result: any) => {
      this.cliente = result;
      this.nombre_cliente = this.cliente?.[0]?.nombre ?? "Cliente no encontrado";
      console.log(this.cliente);
    })
  }

  cambiarSeleccion(valores: any, evento: Event) {
    const casilla = evento.target as HTMLInputElement;

    if (casilla.checked) {
      if (!this.seleccionar(valores)) {
        casilla.checked = false;
      }
      return;
    }

    const indice = this.matriz_vehiculo.findIndex((item) => item[0] === valores.id_vehiculo);
    if (indice >= 0) {
      this.quitar(indice);
    }
  }

  estaSeleccionado(id: number) {
    return this.vehiculosSeleccionados.has(id);
  }

  precioPedido(precio: number): number {
    return Number((Number(precio) * 1.10).toFixed(2));
  }

  seleccionar(valores: any): boolean {
    if (this.estaSeleccionado(valores.id_vehiculo)) {
      return false;
    }

    const cantidad = Number(prompt("Ingrese la cantidad de vehiculos a comprar:"));
    const precio = this.precioPedido(valores.precio);

    if (!Number.isInteger(cantidad) || cantidad <= 0 || !Number.isFinite(precio)) {
      return false;
    }

    this.Arreglo_vehiculos = [
      valores.id_vehiculo,
      valores.serial,
      valores.marca,
      valores.modelo,
      precio,
      cantidad,
      cantidad * precio,
    ];
    this.matriz_vehiculo.push(this.Arreglo_vehiculos);
    this.vehiculosSeleccionados.add(valores.id_vehiculo);

    this.calcularTotales();

    return true;
  }

  quitar(indice: number) {
    this.vehiculosSeleccionados.delete(this.matriz_vehiculo[indice][0]);
    this.matriz_vehiculo.splice(indice, 1);
    this.calcularTotales();
  }

  calcularTotales() {
    this.subtotal = this.matriz_vehiculo.reduce((suma, item) => suma + item[6], 0);
    this.iva = this.subtotal * 0.19;
    this.total = this.subtotal + this.iva;
  }

  guardar() {
    if (!this.cliente?.[0] || this.matriz_vehiculo.length === 0) {
      this.mensaje_error = "Selecciona un cliente y al menos un vehículo.";
      return;
    }

    const sesion = JSON.parse(sessionStorage.getItem('usuario') ?? 'null');
    const idUsuario = Number(sesion?.id);
    if (!Number.isInteger(idUsuario) || idUsuario <= 0) {
      this.mensaje_error = "No se encontró el usuario de la sesión. Inicia sesión nuevamente.";
      return;
    }

    let fecha = new Date();
    this.pedido.fecha = `${fecha.getFullYear()}-${fecha.getMonth() + 1}-${fecha.getDate()}`;
    this.pedido.fo_cliente = Number(this.cliente[0].id_cliente);
    this.pedido.vehiculos = this.matriz_vehiculo.map((item) => ({
      id_vehiculo: item[0],
      precio: item[4],
      cantidad: item[5],
    }));
    this.pedido.subtotal = this.subtotal;
    this.pedido.total = this.total;
    this.pedido.fo_usuario = idUsuario;
    //console.log(this.pedido);

    this.mensaje_error = "";
    this.spedido.insertar(this.pedido).subscribe({
      next: (result: any) => {
        if(String(result?.resultado).toUpperCase() === 'OK'){
          this.router.navigate(['pedido']);
        } else {
          this.mensaje_error = result?.mensaje ?? "No se pudo guardar el pedido.";
        }
      },
      error: (error) => {
        this.mensaje_error = error?.error?.mensaje ?? "No se pudo guardar el pedido.";
      }
    });
  }

}

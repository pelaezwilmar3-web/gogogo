import { Component, signal } from '@angular/core';
import { CommonModule, CurrencyPipe } from '@angular/common';
import { Router } from '@angular/router';
import { Pedido as PedidoService } from '../../servicios/pedido';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-pedido',
  imports: [CommonModule, CurrencyPipe, FormsModule],
  templateUrl: './pedido.html',
  styleUrl: './pedido.css',
})
export class Pedido {

  ventas = signal<any[]>([]);
  modal = signal(false);
  vehiculos = signal<any[]>([]);
  total = signal(0);

  constructor(private router:Router, private spedido: PedidoService) {}

  ngOnInit(): void {
   this.consulta();
  }

  consulta() {
    this.spedido.consulta().subscribe((result:any) => {
      this.ventas.set(Array.isArray(result) ? result : []);
    })
  }
  
  consultap(id:number) {
    this.spedido.consultarp(id).subscribe((result:any) => {
      const detalle = Array.isArray(result) ? result : [];
      this.vehiculos.set(detalle);
      this.total.set(detalle.reduce((suma: number, item: any) => suma + Number(item.total ?? 0), 0));
    })
  }

  insertar() {
    this.router.navigate(['pedidoins']);
  }

  mostrar_modal(dato: any, id: number) {
    switch (dato) {
      case 0:
        this.modal.set(false);
      break;
      case 1:
        this.modal.set(true);
        this.vehiculos.set([]);
        this.total.set(0);
        this.consultap(id);
      break;
    }
  }

  anular(id: number) {
    if (!confirm('¿Desea anular este pedido?')) {
      return;
    }

    this.spedido.eliminar(id).subscribe(() => this.consulta());
  }

  numeroVenta(id: number): string {
    return String(id).padStart(3, '0');
  }

}


import { Component } from '@angular/core';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-nav',
  imports: [RouterModule],
  templateUrl: './nav.html',
  styleUrl: './nav.css',
})
export class Nav {
  menuAbierto = false;
  puedeVerCompras = false;

  constructor(private router: Router) {}

  ngOnInit() {
    const usuarioGuardado = sessionStorage.getItem('usuario');

    if (!usuarioGuardado) {
      return;
    }

    const usuario = JSON.parse(usuarioGuardado);
    const nombre = this.normalizar(usuario.nombre);
    const rol = this.normalizar(usuario.rol);
    const email = this.normalizar(usuario.email);

    this.puedeVerCompras = nombre === 'juan perez'
      && rol === 'administrador'
      && email === 'juan.perez@concesionario.com';
  }

  alternarMenu() {
    this.menuAbierto = !this.menuAbierto;
  }

  cerrarMenu() {
    this.menuAbierto = false;
  }

  irAPedidos(evento: Event) {
    evento.preventDefault();
    this.menuAbierto = false;
    this.router.navigate(['/pedido']);
  }

  private normalizar(valor: unknown) {
    return String(valor ?? '')
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .trim()
      .toLowerCase();
  }
}

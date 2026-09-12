import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-header',
  imports: [RouterModule],
  templateUrl: './header.html',
  styleUrl: './header.css',
})
export class Header {
  usuario: {
    id?: number;
    email?: string;
    nombre?: string;
    rol?: string;
  } = {};

  ngOnInit() {
    const usuarioGuardado = sessionStorage.getItem('usuario');

    if (usuarioGuardado) {
      this.usuario = JSON.parse(usuarioGuardado);
    }
  }

  cerrarSesion() {
    sessionStorage.removeItem('usuario');
  }
}

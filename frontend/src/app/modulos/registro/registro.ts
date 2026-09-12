import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { LoginService } from '../../servicios/login';

@Component({
  selector: 'app-registro',
  imports: [FormsModule],
  templateUrl: './registro.html',
  styleUrl: './registro.css',
})
export class Registro {
  nombre = '';
  celular = '';
  email = '';
  clave = '';
  confirmarClave = '';
  error = '';
  mensaje = '';
  cargando = false;

  constructor(
    private loginService: LoginService,
    public router: Router,
  ) {}

  registrar(): void {
    this.error = '';
    this.mensaje = '';

    if (!this.nombre.trim() || !this.email.trim() || !this.clave || !this.confirmarClave) {
      this.error = 'Completa los campos obligatorios.';
      return;
    }

    if (this.clave.length < 6) {
      this.error = 'La contraseña debe tener al menos 6 caracteres.';
      return;
    }

    if (this.clave !== this.confirmarClave) {
      this.error = 'Las contraseñas no coinciden.';
      return;
    }

    this.cargando = true;
    this.loginService.registrar({
      nombre: this.nombre.trim(),
      celular: this.celular.trim(),
      email: this.email.trim(),
      clave: this.clave,
    }).subscribe({
      next: (respuesta: any) => {
        this.cargando = false;
        if (respuesta?.resultado === 'ERROR') {
          this.error = respuesta.mensaje ?? 'No se pudo crear la cuenta.';
          return;
        }

        this.mensaje = 'Cuenta creada correctamente. Ya puedes iniciar sesión.';
        window.setTimeout(() => this.router.navigate(['/login']), 1200);
      },
      error: () => {
        this.cargando = false;
        this.error = 'No se pudo conectar con el servidor.';
      },
    });
  }
}

import { ChangeDetectorRef, Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { LoginService } from '../../servicios/login';
import { Router } from '@angular/router';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-login',
  imports: [FormsModule],
  templateUrl: './login.html',
  styleUrl: './login.css',
})
export class Login {
  mostrarPassword = false;
  email = '';
  clave = '';
  error = false;
  mensajeError = '';
  cargando = false;
  usuarioNoExiste = false;

constructor(
  private slogin: LoginService,
  public router: Router,
  private changeDetector: ChangeDetectorRef,
) { }

consulta() {
  if (!this.email.trim() || !this.clave) {
    this.error = true;
    this.usuarioNoExiste = false;
    this.mensajeError = 'Ingresa tu correo y contraseña.';
    return;
  }

  this.error = false;
  this.usuarioNoExiste = false;
  this.cargando = true;
  const tiempoMaximo = window.setTimeout(() => {
    if (this.cargando) {
      this.cargando = false;
      this.error = true;
      this.mensajeError = 'Credenciales inválidas.';
      this.changeDetector.detectChanges();
    }
  }, 5000);

  this.slogin.consultar(this.email.trim(), this.clave).pipe(
    finalize(() => {
      window.clearTimeout(tiempoMaximo);
      this.cargando = false;
      this.changeDetector.detectChanges();
    }),
  ).subscribe({
    next: (resultado) => {
      const usuario = resultado[0];

      if (!usuario || usuario.validar !== 'valida') {
        this.error = true;
        this.usuarioNoExiste = usuario?.validar === 'usuario_no_existe';
        this.mensajeError = this.usuarioNoExiste
          ? 'No encontramos una cuenta con este correo.'
          : 'La contraseña no es correcta.';
        this.changeDetector.detectChanges();
        return;
      }

      const sesion = {
        id: usuario.id_usuario,
        email: usuario.email,
        nombre: usuario.nombre,
        rol: usuario.rol,
      };

      sessionStorage.setItem('usuario', JSON.stringify(sesion));
      const rol = (usuario.rol ?? '').toString().toLowerCase();

      if (rol === 'administrador') {
        this.router.navigate(['/dashboard']);
      } else if (rol === 'vendedor') {
        this.router.navigate(['/ventas']);
      } else if (rol === 'técnico' || rol === 'tecnico') {
        this.router.navigate(['/vehiculos']);
      } else {
        this.router.navigate(['/dashboard']);
      }
    },
    error: () => {
      this.error = true;
      this.usuarioNoExiste = false;
      this.mensajeError = 'Credenciales inválidas.';
      this.changeDetector.detectChanges();
    },
  });
}

alternarPassword() {
  this.mostrarPassword = !this.mostrarPassword;
}

}
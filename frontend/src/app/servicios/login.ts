import { Injectable } from '@angular/core';
import { from } from 'rxjs';

export interface RespuestaLogin {
  validar: string;
  id_usuario?: number;
  nombre?: string;
  celular?: string;
  email?: string;
  fo_rol?: number;
  rol?: string;
}

@Injectable({
  providedIn: 'root',
})
export class LoginService {
  
  private url = 'http://localhost/proyectos/Concesionario/Backend/controladores/login.php';

  constructor() {}

  consultar(email: string, clave: string) {
    const params = new URLSearchParams({ email, clave });

    return from(
      fetch(`${this.url}?${params.toString()}`).then((respuesta) => {
        if (!respuesta.ok) {
          throw new Error(`Error HTTP ${respuesta.status}`);
        }

        return respuesta.json() as Promise<RespuestaLogin[]>;
      }),
    );
  }

  registrar(datos: { nombre: string; celular: string; email: string; clave: string }) {
    return from(
      fetch('http://localhost/proyectos/Concesionario/Backend/controladores/usuario.php?control=registrar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos),
      }).then((respuesta) => {
        if (!respuesta.ok) {
          throw new Error(`Error HTTP ${respuesta.status}`);
        }

        return respuesta.json();
      }),
    );
  }


}


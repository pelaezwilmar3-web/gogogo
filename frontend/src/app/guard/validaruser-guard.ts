import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router } from '@angular/router';

@Injectable({
  providedIn: 'root',
})
export class ValidaruserGuard implements CanActivate {

  constructor(private router: Router) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): boolean | UrlTree {
      const usuarioGuardado = sessionStorage.getItem('usuario');

      if (usuarioGuardado) {
        try {
          const usuario = JSON.parse(usuarioGuardado);

          if (usuario?.id && usuario?.email && usuario?.nombre && usuario?.rol) {
            return true;
          }
        } catch {
          sessionStorage.removeItem('usuario');
        }
      }

      return this.router.createUrlTree(['/login'], {
        queryParams: { returnUrl: state.url },
      });
  }
}

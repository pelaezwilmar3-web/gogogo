import { inject } from '@angular/core';
import { CanActivateFn, Router, Routes } from '@angular/router';
import { Main } from './estructura/main';
import { Dashboard } from './modulos/dashboard/dashboard';
import { Clientes } from './modulos/clientes/clientes';
import { Login } from './modulos/login/login';
import { Registro } from './modulos/registro/registro';
import { Ventas } from './modulos/ventas/ventas';
import { Vehiculos } from './modulos/vehiculos/vehiculos';
import { Compras } from './modulos/compras/compras';
import { NoEncontro } from './modulos/no-encontro/no-encontro';
import { ValidaruserGuard } from './guard/validaruser-guard';

const comprasGuard: CanActivateFn = () => {
    const usuarioGuardado = sessionStorage.getItem('usuario');

    if (usuarioGuardado) {
        const usuario = JSON.parse(usuarioGuardado);
        const nombre = String(usuario.nombre ?? '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim().toLowerCase();
        const rol = String(usuario.rol ?? '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim().toLowerCase();
        const email = String(usuario.email ?? '').trim().toLowerCase();

        if (nombre === 'juan perez' && rol === 'administrador' && email === 'juan.perez@concesionario.com') {
            return true;
        }
    }

    return inject(Router).createUrlTree(['/dashboard']);
};

export const routes: Routes = [
    {
        path: '',
        component: Main,
        canActivate: [ValidaruserGuard],
        children: [
            { path: 'dashboard', component: Dashboard },
            { path: 'clientes', component: Clientes },
            { path: 'vehiculos', component: Vehiculos },
            { path: 'ventas', component: Ventas },
            { path: 'compras', component: Compras, canActivate: [comprasGuard] },
            { path: '', redirectTo: 'dashboard', pathMatch: 'full' },
        ],
    },

    { path: 'login', component: Login },
    { path: 'registro', component: Registro },
    { path: '**', component: NoEncontro },
];

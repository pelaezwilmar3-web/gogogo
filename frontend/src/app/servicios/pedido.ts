import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class Pedido {
    url = 'http://localhost/proyectos/Concesionario/Backend/controladores/pedido.php';

  constructor(private http: HttpClient) { }

   consulta(){
        return this.http.get<any[]>(`${this.url}?control=consulta`); 
    }

    disponibles(){
        return this.http.get<any[]>(`${this.url}?control=disponibles`);
    }

    consultarp(id: number){
        return this.http.get(`${this.url}?control=vehiculos&id=${id}`);
    }

    insertar(params: any){
        return this.http.post(`${this.url}?control=insertar`, JSON.stringify(params));
    }

    editar(id: number, params: any){
        return this.http.post(`${this.url}?control=editar&id=${id}`, JSON.stringify(params));
    }

    eliminar(id: number){
        return this.http.get(`${this.url}?control=eliminar&id=${id}`);
    }
    
}

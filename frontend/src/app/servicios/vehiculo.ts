import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class Vehiculo {
    url = 'http://localhost/proyectos/Concesionario/Backend/controladores/vehiculo.php';

    constructor(private http: HttpClient) {};

    consulta(){
        return this.http.get<any[]>(`${this.url}?control=consulta`);
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

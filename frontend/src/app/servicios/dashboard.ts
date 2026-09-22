import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class DashboardService {
  private url = 'http://localhost/proyectos/Concesionario/Backend/controladores/dashboard.php';

  constructor(private http: HttpClient) {}

  resumen() {
    return this.http.get<any>(`${this.url}?control=resumen`);
  }

  ventasPorMes() {
    return this.http.get<any[]>(`${this.url}?control=ventas-mes`);
  }

  testDrives() {
    return this.http.get<any[]>(`${this.url}?control=test-drives`);
  }

  insertarTestDrive(datos: any) {
    return this.http.post<any>(`${this.url}?control=insertar-test-drive`, datos);
  }
}

import { CommonModule } from '@angular/common';
import { Component, OnInit, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { DashboardService } from '../../servicios/dashboard';
import { Modelo } from '../../servicios/modelo';

@Component({
  selector: 'app-dashboard',
  imports: [CommonModule, FormsModule],
  templateUrl: './dashboard.html',
  styleUrl: './dashboard.css',
})
export class Dashboard implements OnInit {
  nombreUsuario = 'usuario';
  resumen = signal({ stock: 0, ventas_mes: 0, clientes: 0, test_drives_hoy: 0 });
  ventasMes = signal<any[]>([]);
  testDrives = signal<any[]>([]);
  modelos: any[] = [];
  error = '';
  mensajeTestDrive = '';
  formularioTestDrive = {
    fecha: new Date().toISOString().slice(0, 16),
    fo_cliente: '',
    fo_modelo: '',
    observaciones: '',
  };

  constructor(private sdashboard: DashboardService, private smodelo: Modelo) {}

  ngOnInit(): void {
    const usuarioGuardado = sessionStorage.getItem('usuario');

    if (usuarioGuardado) {
      const usuario = JSON.parse(usuarioGuardado);
      this.nombreUsuario = usuario.nombre || 'usuario';
    }

    this.cargarDashboard();
    this.smodelo.consulta().subscribe({
      next: (resultado: any) => this.modelos = Array.isArray(resultado) ? resultado : [],
      error: () => this.error = 'No se pudieron cargar los modelos.',
    });
  }

  cargarDashboard(): void {
    this.sdashboard.resumen().subscribe({
      next: (resultado) => this.resumen.set({
        stock: Number(resultado?.stock ?? 0),
        ventas_mes: Number(resultado?.ventas_mes ?? 0),
        clientes: Number(resultado?.clientes ?? 0),
        test_drives_hoy: Number(resultado?.test_drives_hoy ?? 0),
      }),
      error: (error) => this.error = error?.message ?? 'No se pudieron cargar los indicadores.',
    });
    this.sdashboard.ventasPorMes().subscribe({
      next: (resultado) => this.ventasMes.set(Array.isArray(resultado) ? resultado : []),
      error: (error) => this.error = error?.message ?? 'No se pudo cargar el gráfico de ventas.',
    });
    this.cargarTestDrives();
  }

  cargarTestDrives(): void {
    this.sdashboard.testDrives().subscribe({
      next: (resultado) => this.testDrives.set(Array.isArray(resultado) ? resultado : []),
      error: () => this.error = 'No se pudieron cargar los test drives.',
    });
  }

  alturaBarra(vehiculos: number): number {
    const maximo = Math.max(...this.ventasMes().map((venta) => Number(venta.ventas)), 1);
    return Math.max((vehiculos / maximo) * 100, 4);
  }

  registrarTestDrive(): void {
    const sesion = JSON.parse(sessionStorage.getItem('usuario') ?? 'null');
    const datos = {
      ...this.formularioTestDrive,
      fo_cliente: Number(this.formularioTestDrive.fo_cliente),
      fo_modelo: Number(this.formularioTestDrive.fo_modelo),
      fo_usuario: Number(sesion?.id),
    };

    this.sdashboard.insertarTestDrive(datos).subscribe({
      next: (respuesta) => {
        if (respuesta?.resultado === 'ERROR') {
          this.mensajeTestDrive = respuesta.mensaje;
          return;
        }
        this.mensajeTestDrive = respuesta.mensaje;
        this.formularioTestDrive.fo_cliente = '';
        this.formularioTestDrive.fo_modelo = '';
        this.formularioTestDrive.observaciones = '';
        this.cargarDashboard();
      },
      error: (error) => this.mensajeTestDrive = error?.error?.mensaje ?? 'No se pudo registrar el test drive.',
    });
  }
}

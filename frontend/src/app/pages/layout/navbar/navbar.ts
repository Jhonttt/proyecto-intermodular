import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Router } from '@angular/router';
import { AuthService } from '../../../core/services/auth.service';
import { ProyectoService } from '../../../core/services/proyecto.service';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './navbar.html',
  styleUrls: ['./navbar.css'],
})
export class Navbar implements OnInit {
  projectId: number | null = null;
  tieneProyecto: boolean = false;

  constructor(
    private authService: AuthService,
    private proyectoService: ProyectoService,
    private router: Router,
  ) {}

  get isLoggedIn(): boolean {
    return !!localStorage.getItem('token');
  }

  get user(): any {
    const u = localStorage.getItem('user');
    return u ? JSON.parse(u) : null;
  }

  logout() {
    this.tieneProyecto = false;
    this.projectId = null;
    this.authService.logout();
  }

  ngOnInit() {
    this.authService.isLoggedIn$.subscribe((loggedIn: boolean) => {
      if (loggedIn && !this.isAdmin) {
        this.cargarMiProyecto();
      } else {
        this.tieneProyecto = false;
        this.projectId = null;
      }
    });
  }

  cargarMiProyecto() {
    console.log('cargarMiProyecto() llamado');
    this.proyectoService.getMiProyecto().subscribe({
      next: (res: any) => {
        console.log('getMiProyecto respuesta:', res);
        this.tieneProyecto = true;
        this.projectId = res.data?.id ?? null;
      },
      error: (err) => {
        console.log('getMiProyecto error:', err.status);
        this.tieneProyecto = false;
        this.projectId = null;
      },
    });
  }

  verProyecto() {
    if (this.projectId) {
      this.router.navigate(['/details-form', this.projectId]);
    }
  }

  get isAdmin(): boolean {
    return this.user?.rol === 'admin';
  }
}

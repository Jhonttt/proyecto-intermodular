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
  styleUrls: ['./navbar.css']
})
export class Navbar implements OnInit {
  projectId: number | null = null;

  constructor(
    private authService: AuthService,
    private proyectoService: ProyectoService,
    private router: Router
  ) {}

  get isLoggedIn(): boolean {
    return !!localStorage.getItem('token');
  }

  get user(): any {
    const u = localStorage.getItem('user');
    return u ? JSON.parse(u) : null;
  }

  logout() {
    this.authService.logout();
  }

  get hasProject(): boolean {
    return this.user?.proyecto_subido === true;
  }

  ngOnInit() {
    if (this.isLoggedIn && this.hasProject) {
      this.proyectoService.getAll().subscribe({
        next: (res) => {
          const datos = Array.isArray(res) ? res : (res as any).data;
          const miProyecto = datos.find((p: any) => p.user_id === this.user.id);
          this.projectId = miProyecto?.id ?? null;
        },
        error: () => this.projectId = null
      });
    }
  }

  verProyecto() {
    if (this.projectId) {
      this.router.navigate(['/details-form', this.projectId]);
    }
  }
}
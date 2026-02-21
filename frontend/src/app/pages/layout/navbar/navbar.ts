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
  tieneProyecto: boolean = false;

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

  ngOnInit() {
  if (this.isLoggedIn) {
    console.log('Token:', localStorage.getItem('token'));
    console.log('User:', this.user);
    
    this.proyectoService.getMiProyecto().subscribe({
      next: (res) => {
        console.log('Mi proyecto:', res);
        this.tieneProyecto = true;
        this.projectId = res.data?.id ?? null;
      },
      error: (err) => {
        console.log('Error mi proyecto:', err);
        this.tieneProyecto = false;
        this.projectId = null;
      }
    });
  }
}

  verProyecto() {
  console.log('tieneProyecto:', this.tieneProyecto);
  console.log('projectId:', this.projectId);
  if (this.projectId) {
    this.router.navigate(['/details-form', this.projectId]);
  }
}
}
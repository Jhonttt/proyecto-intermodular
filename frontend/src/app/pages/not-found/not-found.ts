import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-not-found',
  standalone: true,
  styleUrls: ["./not-found.css"],
  template: `
    <div class="not-found-page">
      <span class="material-icons not-found-icon">search_off</span>
      <h1 class="not-found-code">404</h1>
      <h2 class="not-found-title">Página no encontrada</h2>
      <p class="not-found-text">
        La página que buscas no existe o no tienes permisos para acceder a ella.
      </p>
      <button class="btn btn-primary" (click)="volver()">← Volver al inicio</button>
    </div>
  `,
})
export class NotFound {
  constructor(private router: Router) {}

  volver() {
    this.router.navigate(['/home']);
  }
}

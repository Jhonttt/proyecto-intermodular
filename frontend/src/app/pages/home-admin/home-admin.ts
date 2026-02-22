import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SectionAdmin } from './section-admin/section-admin';
import { ArticleAdmin } from './article-admin/article-admin';
import { ProyectoService } from '../../core/services/proyecto.service';
import { Proyecto } from '../../core/models/proyecto.model';

@Component({
  selector: 'app-home-admin',
  standalone: true,
  imports: [SectionAdmin, ArticleAdmin, CommonModule],
  styleUrl: './home-admin.css',
  template: `
    <app-section-admin></app-section-admin>

    <div class="container py-5">

  <!-- Loading -->
  <div *ngIf="loading" class="text-center py-5">
    <div class="spinner-border text-primary"></div>
    <p class="mt-3 text-muted">Cargando proyectos...</p>
  </div>

  <!-- Error -->
  <div *ngIf="error" class="alert alert-danger">
    <strong>Error:</strong> {{ error }}
    <button class="btn btn-sm btn-outline-danger ms-3" (click)="loadProyectos()">
      Reintentar
    </button>
  </div>

  <!-- Tabla -->
  <div *ngIf="!loading && !error">

    <table class="table">

      <thead>
        <tr>
          <th>Título</th>
          <th>Año</th>
          <th>Curso</th>
          <th>Descripción</th>
          <th>Estado</th>
        </tr>
      </thead>

      <tbody>
        <ng-container *ngFor="let proyecto of proyectos">
          <tr>
            <app-article-admin
              [titulo]="proyecto.nombre"
              [anio]="getYear(proyecto.created_at)"
              [ciclo]="proyecto.ciclo"
              [estado]="proyecto.checked ? 'Validado' : 'Pendiente'">
            </app-article-admin>
          </tr>
        </ng-container>
      </tbody>

    </table>

  </div>

  <!-- Empty -->
  <div *ngIf="!loading && !error && proyectos.length === 0"
       class="text-center py-5">
    <h5 class="text-muted">No hay proyectos disponibles</h5>
  </div>

</div>

      <!-- CONTROLES DE PAGINACIÓN -->
      <div class="paginacion d-flex justify-content-center align-items-center gap-3">
        <span>Página {{ paginaActual }} de {{ totalPaginas }}</span>

        <input
          type="number"
          class="form-control text-center"
          style="width: 60px"
          [value]="paginaActual"
          min="1"
          [max]="totalPaginas"
          (change)="irAPagina($event)">

        <button
          class="btn fs-5"
          (click)="paginaAnterior()"
          [disabled]="paginaActual === 1">
          ‹
        </button>

        <button
          class="btn fs-5"
          (click)="paginaSiguiente()"
          [disabled]="paginaActual === totalPaginas">
          ›
        </button>
      </div>
  `,
})
export class HomeAdmin implements OnInit {
  proyectos: Proyecto[] = [];
  proyectosOriginal: Proyecto[] = [];
  paginaActual = 1;
  totalPaginas = 3;

  loading = false;
  error = '';

  paginaSiguiente() {
    if (this.paginaActual < this.totalPaginas) {
      this.paginaActual++;
    }
  }

  paginaAnterior() {
    if (this.paginaActual > 1) {
      this.paginaActual--;
    }
  }

  irAPagina(event: Event) {
    const valor = Number((event.target as HTMLInputElement).value);
    if (valor >= 1 && valor <= this.totalPaginas) {
      this.paginaActual = valor;
    }
  }

  constructor(
    private proyectoService: ProyectoService,
    /* private cdr: ChangeDetectorRef */
  ) { }

  ngOnInit(): void {
    this.loadProyectos();
  }

  loadProyectos(): void {
    this.loading = true;
    this.error = '';
   /*  this.cdr.detectChanges(); */

    this.proyectoService.getAllAdmin().subscribe({
      next: (response) => {
        console.log("RESPUESTA BACKEND:", response);
        this.proyectosOriginal = response.data || []; // guardamos lista original
        this.proyectos = [...this.proyectosOriginal]; // lista que se filtra
        /* this.obtenerTagsUnicos(); */
        this.loading = false;
        /* this.cdr.detectChanges(); */
      },
      error: (err) => {
        this.error = err.error?.message || 'Error al cargar los proyectos';
        this.loading = false;
        /* this.cdr.detectChanges(); */
      }
    });
  }

  getYear(dateString: string): string {
    return new Date(dateString).getFullYear().toString();
  }
}

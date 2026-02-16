import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Article } from './article/article';
import { Section } from './section/section';
import { ProyectoService } from '../../core/services/proyecto.service';
import { Proyecto } from '../../core/models/proyecto.model';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule, Article, Section],
  template: `
    <app-section class="mb-5" />
    
    <div class="container py-5">
      <!-- Loading state -->
      <div *ngIf="loading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando proyectos...</span>
        </div>
        <p class="mt-3 text-muted">Cargando proyectos...</p>
      </div>

      <!-- Error state -->
      <div *ngIf="error" class="alert alert-danger" role="alert">
        <strong>Error:</strong> {{ error }}
        <button class="btn btn-sm btn-outline-danger ms-3" (click)="loadProyectos()">
          Reintentar
        </button>
      </div>

      <!-- Proyectos grid -->
      <div *ngIf="!loading && !error" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <div class="col" *ngFor="let proyecto of proyectos">
          <app-article
            [id]="proyecto.id"
            [imagen]="getImagenUrl(proyecto)"
            [titulo]="proyecto.nombre"
            [anio]="getYear(proyecto.created_at)"
            [descripcion]="proyecto.resumen"
            [tecnologias]="proyecto.tags || []"
          ></app-article>
        </div>
      </div>

      <!-- Empty state -->
      <div *ngIf="!loading && !error && proyectos.length === 0" class="text-center py-5">
        <h5 class="text-muted">No hay proyectos disponibles</h5>
        <p class="text-muted">Los proyectos aparecerán aquí cuando sean creados</p>
      </div>
    </div>
  `,
  styles: [`
    .spinner-border {
      width: 3rem;
      height: 3rem;
    }
  `]
})
export class Home implements OnInit {
  proyectos: Proyecto[] = [];
  loading = false;
  error = '';

  constructor(
    private proyectoService: ProyectoService,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    this.loadProyectos();
  }

  loadProyectos(): void {
    this.loading = true;
    this.error = '';
    this.cdr.detectChanges();

    this.proyectoService.getAll().subscribe({
      next: (response) => {
        console.log('Proyectos recibidos:', response);
        this.proyectos = response.data || [];
        this.loading = false;
        this.cdr.detectChanges();
      },
      error: (err) => {
        console.error('Error al cargar proyectos:', err);
        this.error = err.error?.message || 'Error al cargar los proyectos';
        this.loading = false;
        this.cdr.detectChanges();
      }
    });
  }

  getYear(dateString: string): string {
    return new Date(dateString).getFullYear().toString();
  }

  getImagenUrl(proyecto: Proyecto): string {
    if (proyecto.documentos && proyecto.documentos.length > 0) {
      const firstDoc = proyecto.documentos[0];
      if (firstDoc.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
        return firstDoc;
      }
    }
    
    if (proyecto.video_url && proyecto.video_url.includes('youtube.com')) {
      const videoId = this.getYouTubeVideoId(proyecto.video_url);
      if (videoId) {
        return `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
      }
    }
    
    return 'images/prueba.webp';
  }

  getYouTubeVideoId(url: string): string | null {
    const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
    return match ? match[1] : null;
  }
}
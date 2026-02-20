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
    <app-section
  [tagsUnicos]="tagsUnicos"
  (searchChange)="filterProyectos($event)"
  (tagChange)="onTagFilter($event)">
</app-section>

    
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
  proyectosOriginal: Proyecto[] = [];
  tagsUnicos: string[] = [];
  selectedTag: string = '';
  searchTerm: string = '';

  loading = false;
  error = '';

  constructor(
    private proyectoService: ProyectoService,
    private cdr: ChangeDetectorRef
  ) { }

  ngOnInit(): void {
    this.loadProyectos();
  }

  loadProyectos(): void {
    this.loading = true;
    this.error = '';
    this.cdr.detectChanges();

    this.proyectoService.getAll().subscribe({
      next: (response) => {
        this.proyectosOriginal = response.data || []; // guardamos lista original
        this.proyectos = [...this.proyectosOriginal]; // lista que se filtra
        this.obtenerTagsUnicos();
        this.loading = false;
        this.cdr.detectChanges();
      },
      error: (err) => {
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

  obtenerTagsUnicos() {
    const todosTags = this.proyectosOriginal
      .flatMap(p => p.tags || []);

    this.tagsUnicos = [...new Set(todosTags)];
  }
  filterProyectos(search: string) {
    this.searchTerm = search;
    this.aplicarFiltros();
  }

  onTagFilter(tag: string) {
    this.selectedTag = tag;
    this.aplicarFiltros();
  }
aplicarFiltros() {
  const term = this.searchTerm.toLowerCase();

  this.proyectos = this.proyectosOriginal.filter(p => {
 
    const matchTexto =
      p.nombre?.toLowerCase().includes(term) ||
      p.resumen?.toLowerCase().includes(term) ||
      p.ciclo?.toLowerCase().includes(term) ||
      p.alumnos?.some(alumno =>
        alumno.toLowerCase().includes(term)
      ) ||
      p.tags?.some(tag =>
        tag.toLowerCase().includes(term)
      );

    const matchTag =
      !this.selectedTag ||
      p.tags?.includes(this.selectedTag);

    return matchTexto && matchTag;
  });
}

} 

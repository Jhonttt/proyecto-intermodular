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
      (tagChange)="onTagFilter($event)"
    >
    </app-section>

    <div class="container py-5">
      <div *ngIf="loading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando proyectos...</span>
        </div>
        <p class="mt-3 text-muted">Cargando proyectos...</p>
      </div>

      <div *ngIf="error" class="alert alert-danger" role="alert">
        <strong>Error:</strong> {{ error }}
        <button class="btn btn-sm btn-outline-danger ms-3" (click)="loadProyectos()">
          Reintentar
        </button>
      </div>

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

      <div *ngIf="!loading && !error && proyectos.length === 0" class="text-center py-5">
        <h5 class="text-muted">No hay proyectos disponibles</h5>
        <p class="text-muted">Los proyectos aparecerán aquí cuando sean creados</p>
      </div>
    </div>
  `,
  styles: [
    `
      .spinner-border {
        width: 3rem;
        height: 3rem;
      }
    `,
  ],
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
    private cdr: ChangeDetectorRef,
  ) {}

  ngOnInit(): void {
    this.loadProyectos();
  }

  async loadProyectos(): Promise<void> {
    this.loading = true;
    this.error = '';
    this.cdr.detectChanges();

    this.proyectoService.getAll().subscribe({
      next: async (response) => {
        this.proyectosOriginal = response.data || [];
        this.proyectos = [...this.proyectosOriginal];
        this.obtenerTagsUnicos();
        this.loading = false;
        this.cdr.detectChanges();
        // Generar thumbnails después de mostrar la página (no bloquea la carga)
        this.generarThumbnails();
      },
      error: (err) => {
        this.error = err.error?.message || 'Error al cargar los proyectos';
        this.loading = false;
        this.cdr.detectChanges();
      },
    });
  }

  async generarThumbnails(): Promise<void> {
    for (const proyecto of this.proyectosOriginal) {
      if (!proyecto.video_url) continue;

      const cacheKey = 'thumb_' + proyecto.id;
      const cached = localStorage.getItem(cacheKey);

      if (cached) {
        proyecto.video_thumbnail = cached;
        this.cdr.detectChanges();
        continue;
      }

      // Verificar que el video existe antes de intentar capturar
      const videoUrl = 'http://localhost:8000/api/video/' + proyecto.video_url;
      const existe = await fetch(videoUrl, { method: 'HEAD' })
        .then((r) => r.ok)
        .catch(() => false);

      if (!existe) continue; // si no existe, skip directo

      try {
        const thumb = await this.capturarFrame(videoUrl);
        proyecto.video_thumbnail = thumb;
        localStorage.setItem(cacheKey, thumb);
        this.cdr.detectChanges();
      } catch {
        proyecto.video_thumbnail = null;
      }
    }
  }

  capturarFrame(videoUrl: string): Promise<string> {
    return new Promise((resolve, reject) => {
      const video = document.createElement('video');
      video.crossOrigin = 'anonymous';
      video.src = videoUrl;
      video.currentTime = 1;

      // Timeout de 5 segundos por video
      const timeout = setTimeout(() => {
        video.src = '';
        reject(new Error('Timeout'));
      }, 5000);

      video.addEventListener('seeked', () => {
        clearTimeout(timeout);
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d')!.drawImage(video, 0, 0);
        resolve(canvas.toDataURL('image/jpeg'));
      });

      video.addEventListener('error', () => {
        clearTimeout(timeout);
        reject(new Error('Error cargando video'));
      });

      video.load();
    });
  }

  getImagenUrl(proyecto: Proyecto): string {
    if (proyecto.video_thumbnail) {
      return proyecto.video_thumbnail;
    }
    return 'images/prueba.webp';
  }

  getYear(dateString: string): string {
    return new Date(dateString).getFullYear().toString();
  }

  obtenerTagsUnicos() {
    const todosTags = this.proyectosOriginal.flatMap((p) => p.tags || []);
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
    this.proyectos = this.proyectosOriginal.filter((p) => {
      const matchTexto =
        p.nombre?.toLowerCase().includes(term) ||
        p.resumen?.toLowerCase().includes(term) ||
        p.ciclo?.toLowerCase().includes(term) ||
        p.alumnos?.some((alumno) => alumno.toLowerCase().includes(term)) ||
        p.tags?.some((tag) => tag.toLowerCase().includes(term));

      const matchTag = !this.selectedTag || p.tags?.includes(this.selectedTag);

      return matchTexto && matchTag;
    });
  }
}

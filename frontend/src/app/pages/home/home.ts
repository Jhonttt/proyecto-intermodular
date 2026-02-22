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
        <div class="col" *ngFor="let proyecto of proyectosPaginados">
          <app-article
            [id]="proyecto.id"
            [imagen]="getImagenUrl(proyecto)"
            [titulo]="proyecto.nombre"
            [anio]="proyecto.anio"
            [descripcion]="proyecto.resumen"
            [tecnologias]="proyecto.tags || []"
          ></app-article>
        </div>
      </div>

      <!-- Paginación -->
      <div *ngIf="totalPaginas > 1" class="d-flex justify-content-between align-items-center mt-4">
        <small class="text-muted">
          Mostrando {{ (paginaActual - 1) * proyectosPorPagina + 1 }} -
          {{ Math.min(paginaActual * proyectosPorPagina, proyectos.length) }} de
          {{ proyectos.length }} proyectos
        </small>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item" [class.disabled]="paginaActual === 1">
              <a class="page-link" (click)="cambiarPagina(paginaActual - 1)">«</a>
            </li>
            <li class="page-item" *ngFor="let p of paginas" [class.active]="p === paginaActual">
              <a class="page-link" (click)="cambiarPagina(p)">{{ p }}</a>
            </li>
            <li class="page-item" [class.disabled]="paginaActual === totalPaginas">
              <a class="page-link" (click)="cambiarPagina(paginaActual + 1)">»</a>
            </li>
          </ul>
        </nav>
      </div>

      <button class="btn-scroll-top" (click)="scrollTop()" title="Volver arriba">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="20"
          height="20"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M12 19V5" />
          <path d="M5 12l7-7 7 7" />
        </svg>
      </button>

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

      .page-link {
        cursor: pointer;
      }

      .btn-scroll-top {
        position: fixed;
        bottom: 32px;
        right: 32px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #0d77d1;
        color: white;
        font-size: 20px;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        transition: background-color 0.2s ease;
        z-index: 999;
      }

      .btn-scroll-top:hover {
        background-color: #0c589c;
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
  // Variables de paginación
  paginaActual = 1;
  proyectosPorPagina = 12;
  proyectosPaginados: Proyecto[] = [];
  Math = Math;

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
        this.paginaActual = 1;
        this.paginar(); // ← debe ir aquí, antes de loading = false
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
    const sinThumb = this.proyectosOriginal.filter((p) => p.video_url && !p.video_thumbnail);

    for (const proyecto of sinThumb) {
      const cacheKey = 'thumb_' + proyecto.id;
      const failKey = 'thumb_fail_' + proyecto.id;

      // Si ya está en caché, usarlo
      const cached = localStorage.getItem(cacheKey);
      if (cached) {
        proyecto.video_thumbnail = cached;
        this.cdr.detectChanges();
        continue;
      }

      // Si ya falló antes, no reintentar
      if (localStorage.getItem(failKey)) continue;

      try {
        const thumb = await this.capturarFrame(
          'http://localhost:8000/api/video/' + proyecto.video_url,
        );
        proyecto.video_thumbnail = thumb;
        localStorage.setItem(cacheKey, thumb);
        this.cdr.detectChanges();
      } catch (e) {
        // Marcar como fallido para no reintentar
        localStorage.setItem(failKey, '1');
      }
    }
  }

  capturarFrame(videoUrl: string): Promise<string> {
    return new Promise((resolve, reject) => {
      const video = document.createElement('video');
      // Sin crossOrigin para evitar CORS con archivos estáticos
      video.preload = 'metadata';
      video.src = videoUrl;
      video.muted = true;
      video.crossOrigin = 'anonymous';

      const timeout = setTimeout(() => {
        video.src = '';
        reject(new Error('Timeout'));
      }, 15000);

      video.addEventListener('loadedmetadata', () => {
        video.currentTime = Math.min(1, video.duration * 0.1);
      });

      video.addEventListener('seeked', () => {
        clearTimeout(timeout);
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 360;
        canvas.getContext('2d')?.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
        video.src = '';
        resolve(dataUrl);
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
      // Si ya es una URL completa (data: o http), devolverla tal cual
      if (
        proyecto.video_thumbnail.startsWith('http') ||
        proyecto.video_thumbnail.startsWith('data:')
      ) {
        return proyecto.video_thumbnail;
      }
      // Si es una ruta relativa de la BD, construir la URL completa
      return 'http://localhost:8000/storage/' + proyecto.video_thumbnail;
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

    // ← AÑADE ESTO
    this.paginaActual = 1;
    this.paginar();
    this.cdr.detectChanges();
  }

  paginar(): void {
    const inicio = (this.paginaActual - 1) * this.proyectosPorPagina;
    const fin = inicio + this.proyectosPorPagina;
    this.proyectosPaginados = this.proyectos.slice(inicio, fin);
  }

  get totalPaginas(): number {
    return Math.ceil(this.proyectos.length / this.proyectosPorPagina);
  }

  get paginas(): number[] {
    return Array.from({ length: this.totalPaginas }, (_, i) => i + 1);
  }

  cambiarPagina(pagina: number): void {
    if (pagina < 1 || pagina > this.totalPaginas) return;
    this.paginaActual = pagina;
    this.paginar();
    this.cdr.detectChanges();
  }

  scrollTop(): void {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
}

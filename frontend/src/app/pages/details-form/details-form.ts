import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ProyectoService } from '../../core/services/proyecto.service';
import { Proyecto } from '../../core/models/proyecto.model';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-details-form',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './details-form.html',
  styleUrls: ['./details-form.css'],
})
export class DetailsForm implements OnInit {
  projectId!: number;
  loading: boolean = true;
  error: string = '';
  project: Proyecto | null = null;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private proyectoService: ProyectoService,
    private sanitizer: DomSanitizer,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    this.projectId = Number(this.route.snapshot.paramMap.get('id'));
    
    if (isNaN(this.projectId) || this.projectId <= 0) {
      this.error = 'ID de proyecto inválido';
      this.loading = false;
      return;
    }
    
    this.loadProject();
  }

  loadProject(): void {
    this.loading = true;
    this.error = '';
    this.cdr.detectChanges();

    this.proyectoService.getById(this.projectId).subscribe({
      next: (response) => {
        console.log('Proyecto cargado:', response);
        this.project = response.data || null;
        this.loading = false;
        this.cdr.detectChanges();
      },
      error: (err) => {
        console.error('Error al cargar proyecto:', err);
        this.error = err.error?.message || 'No se pudo cargar el proyecto';
        this.loading = false;
        this.cdr.detectChanges();
      }
    });
  }

  // Obtener array de autores desde el string
  get autoresArray(): string[] {
    if (!this.project?.alumnos) return [];
    return this.project.alumnos.split(',').map(a => a.trim());
  }

  // Obtener año de creación
  getYear(): string {
    if (!this.project?.created_at) return '';
    return new Date(this.project.created_at).getFullYear().toString();
  }

  // Obtener fecha formateada
  getFechaCreacion(): string {
    if (!this.project?.created_at) return '';
    const fecha = new Date(this.project.created_at);
    return fecha.toLocaleDateString('es-ES', { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    });
  }

  // Obtener URL de YouTube embebido
  getYouTubeEmbedUrl(): SafeResourceUrl | null {
    if (!this.project?.video_url) return null;
    
    const videoId = this.getYouTubeVideoId(this.project.video_url);
    if (!videoId) return null;
    
    const embedUrl = `https://www.youtube.com/embed/${videoId}`;
    return this.sanitizer.bypassSecurityTrustResourceUrl(embedUrl);
  }

  // Extraer ID del video de YouTube
  private getYouTubeVideoId(url: string): string | null {
    const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
    return match ? match[1] : null;
  }

  // Obtener thumbnail de YouTube
  getYouTubeThumbnail(): string | null {
    if (!this.project?.video_url) return null;
    
    const videoId = this.getYouTubeVideoId(this.project.video_url);
    if (!videoId) return null;
    
    return `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
  }

  // Verificar si hay documentos
  hasDocumentos(): boolean {
    return !!(this.project?.documentos && this.project.documentos.length > 0);
  }

  // Verificar si hay tags
  hasTags(): boolean {
    return !!(this.project?.tags && this.project.tags.length > 0);
  }

  // Obtener extensión de archivo
  getFileExtension(filename: string): string {
    const ext = filename.split('.').pop()?.toLowerCase() || '';
    return ext;
  }

  // Obtener icono según extensión
  getFileIcon(filename: string): string {
    const ext = this.getFileExtension(filename);
    
    const icons: { [key: string]: string } = {
      'pdf': '📄',
      'doc': '📝',
      'docx': '📝',
      'xls': '📊',
      'xlsx': '📊',
      'ppt': '📊',
      'pptx': '📊',
      'txt': '📃',
      'jpg': '🖼️',
      'jpeg': '🖼️',
      'png': '🖼️',
      'gif': '🖼️',
      'zip': '📦',
      'rar': '📦',
    };
    
    return icons[ext] || '📎';
  }

  // Volver al home
  volverAlHome(): void {
    this.router.navigate(['/home']);
  }

  // Obtener estado del proyecto
  getEstadoProyecto(): string {
    return this.project?.checked ? 'Revisado ✓' : 'Pendiente de revisión';
  }

  // Clase CSS según estado
  getEstadoClass(): string {
    return this.project?.checked ? 'badge bg-success' : 'badge bg-warning';
  }
}
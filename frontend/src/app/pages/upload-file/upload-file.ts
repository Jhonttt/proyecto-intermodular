import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { AuthService } from '../../core/services/auth.service';

@Component({
  selector: 'app-upload-file',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './upload-file.html',
  styleUrls: ['./upload-file.css'],
})
export class UploadFileComponent {
  constructor(
    private http: HttpClient,
    private router: Router,
    private authService: AuthService,
  ) {}

  proyecto: any = {
    titulo: '',
    curso: '',
    ciclo: '',
    descripcion: '',
  };

  autoresTexto = '';
  etiquetasTexto = '';

  video: File | null = null;
  videoPreviewUrl: string | null = null;
  documentos: File[] = [];

  errorVideo: string = '';
  errorArchivo: string = '';
  errorFormulario: string = '';
  mensajeExito: string = '';
  enviando: boolean = false;

  MAX_VIDEO_SIZE = 30 * 1024 * 1024;
  MAX_DOC_SIZE = 10 * 1024 * 1024;
  MAX_TOTAL_DOCS_SIZE = 10 * 1024 * 1024;

  onVideoSeleccionado(event: any) {
    const file = event.target.files[0];
    if (file) {
      if (file.size > this.MAX_VIDEO_SIZE) {
        this.errorVideo = 'El vídeo no puede superar los 30 MB';
        this.video = null;
        this.videoPreviewUrl = null;
      } else {
        this.errorVideo = '';
        this.video = file;
        this.generarThumbnail(file);
      }
    }
  }

  generarThumbnail(file: File): void {
    const url = URL.createObjectURL(file);
    const videoEl = document.createElement('video');
    videoEl.preload = 'metadata';
    videoEl.muted = true;
    videoEl.src = url;

    const timeout = setTimeout(() => {
      this.videoPreviewUrl = null;
      URL.revokeObjectURL(url);
    }, 5000);

    videoEl.addEventListener('loadedmetadata', () => {
      videoEl.currentTime = Math.min(1, videoEl.duration * 0.1);
    });

    videoEl.addEventListener('seeked', () => {
      clearTimeout(timeout);
      const canvas = document.createElement('canvas');
      canvas.width = videoEl.videoWidth;
      canvas.height = videoEl.videoHeight;
      canvas.getContext('2d')?.drawImage(videoEl, 0, 0);
      this.videoPreviewUrl = canvas.toDataURL('image/jpeg', 0.7);
      URL.revokeObjectURL(url);
    });

    videoEl.load();
  }

  dataURLtoBlob(dataURL: string): Blob {
    const arr = dataURL.split(',');
    const mime = arr[0].match(/:(.*?);/)![1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) u8arr[n] = bstr.charCodeAt(n);
    return new Blob([u8arr], { type: mime });
  }

  onDocumentacionSeleccionada(event: any): void {
    const files: FileList = event.target.files;
    this.errorArchivo = '';

    // Calcular el tamaño que ya llevas acumulado
    let totalSize = this.documentos.reduce((acc, doc) => acc + doc.size, 0);
    const nuevosDocumentos = [...this.documentos]; // 👈 parte de los que ya tienes

    for (let i = 0; i < files.length; i++) {
      const file = files[i];

      // Evitar duplicados por nombre
      if (nuevosDocumentos.some((d) => d.name === file.name)) {
        continue;
      }

      if (totalSize + file.size > this.MAX_TOTAL_DOCS_SIZE) {
        this.errorArchivo = `"${file.name}" no se puede añadir: superaría el límite de 10 MB en total (llevas ${(totalSize / 1024 / 1024).toFixed(1)} MB)`;
        break;
      }

      totalSize += file.size;
      nuevosDocumentos.push(file);
    }

    this.documentos = nuevosDocumentos;
  }

  enviarProyecto(form: any) {
    this.errorFormulario = '';
    this.mensajeExito = '';

    if (form.invalid) {
      form.control.markAllAsTouched();
      this.errorFormulario = 'Por favor, revisa los campos obligatorios.';
      return;
    }

    if (!this.video) {
      this.errorVideo = 'Es obligatorio subir un vídeo.';
      return;
    }

    const formData = new FormData();
    formData.append('nombre', this.proyecto.titulo);
    formData.append('resumen', this.proyecto.titulo);
    formData.append('alumnos', this.autoresTexto);
    formData.append('ciclo', this.proyecto.ciclo);
    formData.append('anio', this.proyecto.curso);
    formData.append('descripcion', this.proyecto.descripcion);
    formData.append('tags', this.etiquetasTexto);
    formData.append('video', this.video);

    // Añadir thumbnail generado en el navegador
    if (this.videoPreviewUrl) {
      const blob = this.dataURLtoBlob(this.videoPreviewUrl);
      const thumbnailFile = new File([blob], 'thumbnail.jpg', { type: 'image/jpeg' });
      formData.append('thumbnail', thumbnailFile);
    }

    this.documentos.forEach((doc) => {
      formData.append('documentos[]', doc);
    });

    this.enviando = true;

    this.http.post('http://localhost:8000/api/proyectos', formData).subscribe({
      next: (res: any) => {
        this.enviando = false;
        this.mensajeExito = 'Proyecto creado correctamente.';
        this.authService.notificarProyectoSubido();
        const id = (res as any).data?.id ?? (res as any).proyecto?.id;
        console.log('Respuesta completa:', res); // 👈 para ver qué devuelve exactamente
        console.log('ID obtenido:', id);
        setTimeout(() => this.router.navigate(['/details-form', id]), 1500);
      },
      error: (err) => {
        this.enviando = false;
        console.error('Errores de validación:', err.error?.errors);
        this.errorFormulario = err.error?.message || 'Error al crear el proyecto.';
      },
    });
  }
  
  eliminarDocumento(doc: File): void {
    this.documentos = this.documentos.filter((d) => d.name !== doc.name);
    this.errorArchivo = '';
  }
}

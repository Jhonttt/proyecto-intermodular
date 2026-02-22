import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';

@Component({
  selector: 'app-upload-file',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './upload-file.html',
  styleUrls: ['./upload-file.css'],
})
export class UploadFileComponent {
  constructor(private http: HttpClient, private router: Router) {}

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
    videoEl.src = url;
    videoEl.currentTime = 1;
    videoEl.muted = true;

    videoEl.addEventListener('seeked', () => {
      const canvas = document.createElement('canvas');
      canvas.width = videoEl.videoWidth;
      canvas.height = videoEl.videoHeight;
      canvas.getContext('2d')?.drawImage(videoEl, 0, 0);
      this.videoPreviewUrl = canvas.toDataURL('image/jpeg');
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
    this.documentos = [];

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      if (file.size > this.MAX_DOC_SIZE) {
        this.errorArchivo = `"${file.name}" supera los 10 MB`;
        this.documentos = [];
        return;
      }
      this.documentos.push(file);
    }
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
    formData.append('nombre',      this.proyecto.titulo);
    formData.append('resumen',     this.proyecto.titulo);
    formData.append('alumnos',     this.autoresTexto);
    formData.append('ciclo',       this.proyecto.ciclo);
    formData.append('anio',        this.proyecto.curso);
    formData.append('descripcion', this.proyecto.descripcion);
    formData.append('tags',        this.etiquetasTexto);
    formData.append('video',       this.video);

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

    this.http.post('http://127.0.0.1:8000/api/proyectos', formData).subscribe({
      next: (res) => {
        this.enviando = false;
        this.mensajeExito = 'Proyecto creado correctamente.';
        setTimeout(() => this.router.navigate(['/mi-proyecto']), 1500);
      },
      error: (err) => {
        this.enviando = false;
        console.error('Errores de validación:', err.error?.errors);
        this.errorFormulario = err.error?.message || 'Error al crear el proyecto.';
      },
    });
  }
}
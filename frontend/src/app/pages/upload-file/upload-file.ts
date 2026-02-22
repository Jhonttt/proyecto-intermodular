import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule, NgForm } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-upload-file',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './upload-file.html',
  styleUrls: ['./upload-file.css']
})
export class UploadFileComponent {
  proyecto: any = {
    titulo: '',
    curso: '',
    ciclo: '',
    descripcion: ''
  };
  autoresTexto = '';
  etiquetasTexto = '';

  videoFile: File | null = null;
  docFile: File | null = null;

  // Mensajes de error individuales
  errorTitulo = '';
  errorAutores = '';
  errorCurso = '';
  errorCiclo = '';
  errorDescripcion = '';
  errorVideo = '';
  errorDoc = '';

  MAX_VIDEO_SIZE = 30 * 1024 * 1024; // 30 MB
  MAX_DOC_SIZE = 10 * 1024 * 1024;   // 10 MB

  constructor(private http: HttpClient) {}

  onVideoSeleccionado(event: any) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > this.MAX_VIDEO_SIZE) {
      this.errorVideo = 'El vídeo no puede superar los 30 MB';
      this.videoFile = null;
    } else {
      this.errorVideo = '';
      this.videoFile = file;
    }
  }

  onDocumentacionSeleccionada(event: any) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > this.MAX_DOC_SIZE) {
      this.errorDoc = 'La documentación no puede superar los 10 MB';
      this.docFile = null;
      return;
    }

    const allowedExtensions = ['.zip', '.rar'];
    const extension = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
    if (!allowedExtensions.includes(extension)) {
      this.errorDoc = 'Solo se permiten archivos ZIP o RAR';
      this.docFile = null;
      return;
    }

    this.errorDoc = '';
    this.docFile = file;
  }

  enviarProyecto(form: NgForm) {
    // Reset errores individuales
    this.errorTitulo = '';
    this.errorAutores = '';
    this.errorCurso = '';
    this.errorCiclo = '';
    this.errorDescripcion = '';
    this.errorVideo = '';
    this.errorDoc = '';

    // Validaciones manuales
    let valid = true;

    if (!this.proyecto.titulo.trim()) {
      this.errorTitulo = 'El título es obligatorio';
      valid = false;
    }
    if (!this.autoresTexto.trim()) {
      this.errorAutores = 'Debes indicar al menos un autor';
      valid = false;
    }
    if (!this.proyecto.curso) {
      this.errorCurso = 'Debes seleccionar un curso';
      valid = false;
    }
    if (!this.proyecto.ciclo) {
      this.errorCiclo = 'Debes seleccionar un ciclo';
      valid = false;
    }
    if (!this.proyecto.descripcion.trim()) {
      this.errorDescripcion = 'La descripción es obligatoria';
      valid = false;
    } else if (this.proyecto.descripcion.length < 25) {
      this.errorDescripcion = 'La descripción debe tener al menos 25 caracteres';
      valid = false;
    }
    if (!this.videoFile) {
      this.errorVideo = 'Es obligatorio subir un vídeo';
      valid = false;
    }

    if (!valid) return;

    // Preparar FormData
    const formData = new FormData();
    formData.append('nombre', this.proyecto.titulo);
    formData.append('resumen', this.proyecto.titulo);
    formData.append('descripcion', this.proyecto.descripcion);
    formData.append('anio', this.proyecto.curso);
    formData.append('ciclo', this.proyecto.ciclo);
    formData.append('alumnos', JSON.stringify(this.autoresTexto.split(',').map(a => a.trim())));
    formData.append('tags', JSON.stringify(this.etiquetasTexto.split(',').map(e => e.trim())));

    formData.append('video', this.videoFile!, this.videoFile!.name);
    if (this.docFile) formData.append('archivo', this.docFile, this.docFile.name);

    // Petición HTTP
    this.http.post('http://127.0.0.1:8000/alumno/proyectos', formData)
      .subscribe({
        next: res => {
          console.log('Proyecto creado:', res);
          form.resetForm();
          this.videoFile = null;
          this.docFile = null;
        },
        error: err => {
          console.error(err);
          // Mostrar mensaje individual si viene del backend
          if (err.error?.errors) {
            const errors = err.error.errors;
            this.errorTitulo = errors.nombre?.[0] ?? '';
            this.errorDescripcion = errors.descripcion?.[0] ?? '';
            this.errorVideo = errors.video?.[0] ?? '';
            this.errorDoc = errors.archivo?.[0] ?? '';
          } else {
            alert('Error al enviar el proyecto');
          }
        }
      });
  }
}

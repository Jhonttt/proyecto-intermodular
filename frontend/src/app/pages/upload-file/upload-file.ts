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
  constructor(private http: HttpClient) {}

  proyecto: any = {
    titulo: '',
    curso: '',
    ciclo: '',
    descripcion: ''
  };

  autoresTexto = '';
  etiquetasTexto = '';

  imagen: File | null = null;
  video: File | null = null;
  archivo: File | null = null;

  errorVideo: string = '';
  errorArchivo: string = '';

  MAX_VIDEO_SIZE = 30 * 1024 * 1024; // 30 MB
  MAX_DOC_SIZE = 10 * 1024 * 1024;   // 10 MB

  // Validación y guardado del video
  onVideoSeleccionado(event: any) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > this.MAX_VIDEO_SIZE) {
      this.errorVideo = 'El vídeo no puede superar los 30 MB';
      this.video = null;
    } else {
      this.errorVideo = '';
      this.video = file;
    }
  }

  // Validación y guardado del ZIP/RAR
  onDocumentacionSeleccionada(event: any): void {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > this.MAX_DOC_SIZE) {
      this.errorArchivo = 'La documentación no puede superar los 10 MB';
      this.archivo = null;
      return;
    }

    const allowedExtensions = ['.zip', '.rar'];
    const extension = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
    if (!allowedExtensions.includes(extension)) {
      this.errorArchivo = 'Solo se permiten archivos ZIP o RAR';
      this.archivo = null;
      return;
    }

    this.errorArchivo = '';
    this.archivo = file;
  }

  // Envío del proyecto al backend
  enviarProyecto(form: NgForm) {
    // Validación general
    if (form.invalid) {
      form.form.markAllAsTouched(); // Marca todos los campos para mostrar errores
      return;
    }

    if (!this.video) {
      this.errorVideo = 'Es obligatorio subir un vídeo';
      return;
    }

    const formData = new FormData();
    formData.append('nombre', this.proyecto.titulo);
    formData.append('titulo', this.proyecto.titulo);
    formData.append('alumnos', this.autoresTexto);
    formData.append('curso', this.proyecto.curso);
    formData.append('ciclo', this.proyecto.ciclo);
    formData.append('descripcion', this.proyecto.descripcion);
    formData.append('autores', JSON.stringify(this.autoresTexto.split(',').map(a => a.trim())));
    formData.append('tags', JSON.stringify(this.etiquetasTexto.split(',').map(e => e.trim())));
    formData.append('video', this.video);

    if (this.archivo) {
      formData.append('documentos', this.archivo);
    }

    this.http.post('http://127.0.0.1:8000/api/proyectos', formData)
      .subscribe({
        next: res => {
          console.log('Proyecto creado:', res);
          // Reset form y variables
          form.resetForm();
          this.video = null;
          this.archivo = null;
          this.errorVideo = '';
          this.errorArchivo = '';
        },
        error: err => {
          console.error('Error al crear el proyecto:', err);
          if (err.error?.message) {
            alert(err.error.message);
          } else {
            alert('Error al enviar el proyecto');
          }
        }
      });
  }
}

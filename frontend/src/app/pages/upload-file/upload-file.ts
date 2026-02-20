
import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
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

  errorImagen: string = '';
  errorVideo: string = '';
  errorArchivo: string = '';

  MAX_SIZE = 30 * 1024 * 1024; // 30 MB


  onVideoSeleccionado(event: any) {
    const file = event.target.files[0];
    if (file) {
      if (file.size > this.MAX_SIZE) {
        this.errorVideo = 'El vídeo no puede superar los 30 MB';
        this.video = null;
      } else {
        this.errorVideo = '';
        this.video = file;
      }
    }
  }

  onArchivoSeleccionado(event: any) {
    const file = event.target.files[0];
    if (file) {
      if (file.size > this.MAX_SIZE) {
        this.errorArchivo = 'El archivo no puede superar los 30 MB';
        this.archivo = null;
        return;
      }

      const extensionesPermitidas = ['.zip', '.rar'];
      const nombre = file.name.toLowerCase();
      const extension = nombre.substring(nombre.lastIndexOf('.'));
      if (!extensionesPermitidas.includes(extension)) {
        this.errorArchivo = 'Solo se permiten archivos ZIP o RAR';
        this.archivo = null;
        return;
      }

      this.errorArchivo = '';
      this.archivo = file;
    }
  }

  enviarProyecto(form: any) {
    // ❌ Si el formulario es inválido
    if (form.invalid) {
      alert('Por favor, revisa los campos obligatorios');
      return;
    }

    if (!this.video) {
      this.errorVideo = 'Es obligatorio subir un vídeo';
      return;
    }

    const formData = new FormData();
    formData.append('nombre', this.proyecto.titulo);
    formData.append('alumnos', this.autoresTexto);
    formData.append('titulo', this.proyecto.titulo);
    formData.append('curso', this.proyecto.curso);
    formData.append('ciclo', this.proyecto.ciclo);
    formData.append('descripcion', this.proyecto.descripcion);
    formData.append('autores', JSON.stringify(this.autoresTexto.split(',').map(a => a.trim())));
    formData.append('tags', JSON.stringify(this.etiquetasTexto.split(',').map(e => e.trim())));
    formData.append('video_url', this.video);

    if (this.archivo) {
      formData.append('documentos', this.archivo);
    }

    this.http.post('http://127.0.0.1:8000/api/proyectos', formData)
  .subscribe({
    next: (res) => {
      alert('Proyecto creado correctamente');
      console.log(res);
    },
    error: (err) => {
      alert('Error al crear el proyecto');
      console.error(err);
    }
  });
  }

  // Tamaño máximo permitido para documentación (10 MB)
  MAX_DOC_SIZE = 10 * 1024 * 1024;

  // Método que se ejecuta cuando el usuario selecciona la documentación
  onDocumentacionSeleccionada(event: any): void {

    const file = event.target.files[0]; // Obtenemos el archivo seleccionado

    if (file) {

      // 1️⃣ Validar tamaño máximo (10MB)
      if (file.size > this.MAX_DOC_SIZE) {
        this.errorArchivo = 'La documentación no puede superar los 10 MB';
        this.archivo = null;
        return;
      }
    }
  }
}


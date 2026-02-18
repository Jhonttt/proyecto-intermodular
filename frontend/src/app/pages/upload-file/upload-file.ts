
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

  onImagenSeleccionada(event: any) {
    const file = event.target.files[0];
    if (file) {
      if (file.size > this.MAX_SIZE) {
        this.errorImagen = 'La imagen no puede superar los 30 MB';
        this.imagen = null;
      } else {
        this.errorImagen = '';
        this.imagen = file;
      }
    }
  }

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

  enviarProyecto() {
    if (!this.imagen) {
      this.errorImagen = 'Es obligatorio subir una imagen';
      return;
    }

    if (!this.video) {
      this.errorVideo = 'Es obligatorio subir un vídeo';
      return;
    }

    const formData = new FormData();
    formData.append('titulo', this.proyecto.titulo);
    formData.append('curso', this.proyecto.curso);
    formData.append('ciclo', this.proyecto.ciclo);
    formData.append('descripcion', this.proyecto.descripcion);
    formData.append('autores', JSON.stringify(this.autoresTexto.split(',').map(a => a.trim())));
    formData.append('etiquetas', JSON.stringify(this.etiquetasTexto.split(',').map(e => e.trim())));
    formData.append('imagen', this.imagen);
    formData.append('video', this.video);

    if (this.archivo) {
      formData.append('archivo', this.archivo);
    }

    console.log('Proyecto listo para enviar a backend:', formData);
  }

}

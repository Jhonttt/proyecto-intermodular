// Importamos Component para poder crear un componente en Angular
import { Component } from '@angular/core';

// Importamos FormsModule para poder usar [(ngModel)] en formularios template-driven
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

// Decorador @Component: define los metadatos del componente
@Component({
  selector: 'app-upload-file',       // Nombre del selector para usar en HTML
  standalone: true,                   // Indica que es un componente standalone
  imports: [FormsModule, CommonModule],             // Importa FormsModule para usar ngModel
  templateUrl: './upload-file.html',  // Archivo HTML del template
  styleUrls: ['./upload-file.css']    // Archivo(s) CSS del componente
})
export class UploadFileComponent {

  /* ===============================
     DATOS DEL PROYECTO
     =============================== */

  // Objeto principal que almacena los datos básicos del proyecto
  proyecto: any = {
    titulo: '',
    curso: '',
    descripcion: ''
  };

  // Campos de texto que luego se convertirán en arrays
  autoresTexto: string = '';    // Ej: "Juan, María"
  etiquetasTexto: string = '';  // Ej: "Angular, Laravel"

  /* ===============================
     ARCHIVOS
     =============================== */

  // Archivos seleccionados por el usuario
  imagen: File | null = null;   // Imagen representativa del proyecto
  video: File | null = null;    // Vídeo del proyecto

  // Mensajes de error para mostrar en el HTML
  errorImagen: string = '';
  errorVideo: string = '';

  // Tamaño máximo permitido (30 MB)
  MAX_SIZE = 30 * 1024 * 1024; // 30 MB en bytes

  /* ===============================
     MÉTODOS DE SELECCIÓN DE ARCHIVOS
     =============================== */

  // Método que se ejecuta cuando el usuario selecciona una imagen
  onImagenSeleccionada(event: any): void {
    const file = event.target.files[0]; // Obtenemos el archivo seleccionado

    if (file) {
      // Comprobamos que el tamaño no supere el máximo permitido
      if (file.size > this.MAX_SIZE) {
        this.errorImagen = 'La imagen no puede superar los 30 MB';
        this.imagen = null;
      } else {
        this.errorImagen = '';
        this.imagen = file;
      }
    }
  }

  // Método que se ejecuta cuando el usuario selecciona un vídeo
  onVideoSeleccionado(event: any): void {
    const file = event.target.files[0]; // Obtenemos el archivo seleccionado

    if (file) {
      // Comprobamos que el tamaño no supere el máximo permitido
      if (file.size > this.MAX_SIZE) {
        this.errorVideo = 'El vídeo no puede superar los 30 MB';
        this.video = null;
      } else {
        this.errorVideo = '';
        this.video = file;
      }
    }
  }

  /* ===============================
     ENVÍO DEL FORMULARIO
     =============================== */

  // Método que se ejecuta al enviar el formulario
  enviarProyecto(): void {

    // Validamos que se haya seleccionado una imagen
    if (!this.imagen) {
      this.errorImagen = 'Es obligatorio subir una imagen';
      return;
    }

    // Validamos que se haya seleccionado un vídeo
    if (!this.video) {
      this.errorVideo = 'Es obligatorio subir un vídeo';
      return;
    }

    // Creamos un objeto FormData para enviar datos y archivos al backend
    const formData = new FormData();

    // Añadimos los campos de texto
    formData.append('titulo', this.proyecto.titulo);
    formData.append('curso', this.proyecto.curso);
    formData.append('descripcion', this.proyecto.descripcion);

    // Convertimos el texto de autores en un array limpio y lo enviamos como JSON
    formData.append(
      'autores',
      JSON.stringify(
        this.autoresTexto
          .split(',')
          .map(autor => autor.trim())
          .filter(autor => autor.length > 0)
      )
    );

    // Convertimos el texto de etiquetas en un array limpio y lo enviamos como JSON
    formData.append(
      'etiquetas',
      JSON.stringify(
        this.etiquetasTexto
          .split(',')
          .map(etiqueta => etiqueta.trim())
          .filter(etiqueta => etiqueta.length > 0)
      )
    );

    // Añadimos los archivos
    formData.append('imagen', this.imagen);
    formData.append('video', this.video);

    // Aquí iría la llamada HTTP al backend (Laravel)
    // this.http.post('url-del-backend', formData).subscribe(...);

    // Por ahora mostramos el FormData en consola
    console.log('Proyecto listo para enviar a Laravel', formData);
  }
}

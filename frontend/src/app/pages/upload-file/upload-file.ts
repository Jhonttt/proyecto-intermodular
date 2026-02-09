// Importamos Component para crear un componente Angular
// Importamos FormsModule para poder usar [(ngModel)] en el template
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';

// Decorador @Component define metadatos del componente
@Component({
  selector: 'app-upload-file',       // Nombre del selector para usar en HTML
  standalone: true,                   // Indica que es un componente standalone
  imports: [FormsModule],             // Importa FormsModule para usar ngModel
  templateUrl: './upload-file.html',  // Archivo HTML del template
  styleUrls: ['./upload-file.css']    // Archivo(s) CSS del componente
})
export class UploadFileComponent {
  
  // Objeto que guarda la información principal del proyecto
  proyecto: any = {
    titulo: '',
    curso: '',
    descripcion: ''
  };

  // Variables para campos de texto que se convertirán en arrays
  autoresTexto = '';    // Texto ingresado por el usuario para los autores
  etiquetasTexto = '';  // Texto ingresado por el usuario para etiquetas

  // Archivos seleccionados por el usuario
  imagen: File | null = null; // Imagen representativa
  video: File | null = null;  // Vídeo del proyecto

  // Mensajes de error para mostrar en el HTML
  errorImagen: string = '';
  errorVideo: string = '';

  // Constante que define el tamaño máximo permitido: 30 MB
  MAX_SIZE = 30 * 1024 * 1024; // 30 MB en bytes

  // Método que se ejecuta cuando se selecciona una imagen
  onImagenSeleccionada(event: any) {
    const file = event.target.files[0]; // Tomamos el primer archivo seleccionado
    if (file) {
      // Verificamos si el tamaño supera el máximo permitido
      if (file.size > this.MAX_SIZE) {
        this.errorImagen = 'La imagen no puede superar los 30 MB';
        this.imagen = null; // No guardamos el archivo si es demasiado grande
      } else {
        this.errorImagen = ''; // Limpiamos errores previos
        this.imagen = file;    // Guardamos el archivo
      }
    }
  }

  // Método que se ejecuta cuando se selecciona un vídeo
  onVideoSeleccionado(event: any) {
    const file = event.target.files[0]; // Tomamos el primer archivo seleccionado
    if (file) {
      // Verificamos tamaño máximo
      if (file.size > this.MAX_SIZE) {
        this.errorVideo = 'El vídeo no puede superar los 30 MB';
        this.video = null; // No guardamos el archivo si es demasiado grande
      } else {
        this.errorVideo = ''; // Limpiamos errores previos
        this.video = file;    // Guardamos el archivo
      }
    }
  }

  // Método que se ejecuta al enviar el formulario
  enviarProyecto() {
    // Validamos que se haya seleccionado una imagen
    if (!this.imagen) {
      this.errorImagen = 'Es obligatorio subir una imagen';
      return; // Detenemos el envío si no hay imagen
    }

    // Validamos que se haya seleccionado un vídeo
    if (!this.video) {
      this.errorVideo = 'Es obligatorio subir un vídeo';
      return; // Detenemos el envío si no hay vídeo
    }

    // Creamos un objeto FormData para enviar datos y archivos al backend
    const formData = new FormData();
    formData.append('titulo', this.proyecto.titulo);
    formData.append('curso', this.proyecto.curso);
    formData.append('descripcion', this.proyecto.descripcion);

    // Convertimos autoresTexto en array y lo agregamos como JSON
    formData.append(
      'autores',
      JSON.stringify(this.autoresTexto.split(',').map(a => a.trim()))
    );

    // Convertimos etiquetasTexto en array y lo agregamos como JSON
    formData.append(
      'etiquetas',
      JSON.stringify(this.etiquetasTexto.split(',').map(e => e.trim()))
    );

    // Agregamos los archivos al FormData
    formData.append('imagen', this.imagen);
    formData.append('video', this.video);

    // Por ahora solo mostramos en consola el FormData
    // Aquí se haría la llamada HTTP hacia Laravel o el backend
    console.log('Proyecto listo para enviar a Laravel', formData);
  }
}

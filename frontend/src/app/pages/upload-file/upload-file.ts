import { Component } from '@angular/core';

@Component({
  selector: 'app-upload-file',
  imports: [],
  templateUrl: './upload-file.html',
  styleUrl: './upload-file.css',
})
export class UploadFile {

}


export class UploadFileComponent {

  enviarFormulario() {
    console.log('Formulario enviado');
  }

}

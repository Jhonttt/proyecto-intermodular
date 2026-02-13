// forgot-password.ts
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
@Component({
  selector: 'app-forgot-password',
   standalone: true,
     imports: [FormsModule, CommonModule],
  templateUrl: './forgot-password.html',
  styleUrls: ['./forgot-password.css']
})

export class ForgotPasswordComponent {
email: string = '';
  message: string = '';
  messageType: 'success' | 'error' | '' = '';

constructor() {
    console.log("¡Componente cargado con éxito!");
  }
  
   sendEmail() {
    console.log('Botón pulsado', this.email);
    this.message = '';
    this.messageType = '';

    if (!this.email.trim()) {
      this.message = 'Por favor, introduce un correo válido.';
      this.messageType = 'error';
      return;
    }

    this.message = `Se ha enviado un correo de recuperación a ${this.email}`;
    this.messageType = 'success';
    this.email = '';
  }
}
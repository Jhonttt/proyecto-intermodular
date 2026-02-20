// forgot-password.ts
import { Component } from '@angular/core';
import { Router, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
@Component({
  selector: 'app-forgot-password', // Nombre del selector para usar el componente en HTML
  standalone: true,
    imports: [FormsModule, CommonModule, RouterModule],
  templateUrl: './forgot-password.html', // Archivo HTML del componente
  styleUrls: ['./forgot-password.css'], // Archivo CSS del componente
})
export class ForgotPassword {
   // Propiedades del componente
  email: string = '';
  message: string = '';
  messageType: 'success' | 'error' | '' = '';

// Constructor del componente
  constructor(private router: Router) {
    console.log('¡Componente cargado con éxito!');
  }

  
  // Función que se ejecuta al pulsar el botón de enviar correo
  sendEmail() {
    console.log('Botón pulsado', this.email);
    this.message = '';
    this.messageType = '';

      //si el correo está vacío
    if (!this.email.trim()) {
      this.message = 'Por favor, introduce un correo válido.';
      this.messageType = 'error';
      return;
    }

    this.message = `Se ha enviado un correo de recuperación a ${this.email}`;
    this.messageType = 'success';
    this.email = '';
  }

  // Función que se ejecuta al pulsar el botón de cancelar
  cancelar() {
    this.email = ''; // Limpia el input
    this.message = ''; // Limpia mensajes
    this.messageType = ''; // Limpia tipo de mensaje
    console.log('Formulario cancelado'); 
    this.router.navigate(['/login']); // Redirige a la página de login
  }
}

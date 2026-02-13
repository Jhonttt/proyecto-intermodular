import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-forgot-password',
  imports: [FormsModule, CommonModule],
  standalone: true,
  templateUrl: './forgot-password.html',
  styleUrls: ['./forgot-password.css', "./base.css", "./componentes.css", "./layout.css"],
})
export class ForgotPassword {

  email: string = '';
  message: string = '';
  messageClass: string = '';

  sendEmail() {
    if (!this.email.trim()) {
      this.message = 'Por favor, introduce un correo válido.';
      this.messageClass = 'error';
      return;
    }

    this.message = `Se ha enviado un correo de recuperación a ${this.email}`;
    this.messageClass = 'success';
    this.email = '';
  }
}

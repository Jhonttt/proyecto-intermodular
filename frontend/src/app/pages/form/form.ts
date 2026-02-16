import { Component, signal } from '@angular/core';
import { Router, RouterOutlet, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-form',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule],
  templateUrl: './form.html',
  styleUrls: ['./form.css']
})

export class Form { 
  loginForm: FormGroup;
  showModal: boolean = false; // Controla la visibilidad del modal

  constructor(private fb: FormBuilder, private router: Router) {
    this.loginForm = this.fb.group({
      correo: ['', [Validators.required, Validators.email]],
      passwd: ['', [Validators.required, Validators.minLength(6)]]
    });
  }

  private usuariosValidos = [
    { correo: 'usuario@test.com', clave: '123456'},
    { correo: 'admin@test.com', clave: '123456'}
  ];

  onLogin() {
    if (this.loginForm.valid) {
      const { correo, passwd } = this.loginForm.value;

      const usuarioEncontrado = this.usuariosValidos.find(
        u => u.correo === correo && u.clave === passwd
      );

      if (usuarioEncontrado) {
        console.log('Login exitoso');
        this.router.navigate(['/home']); 
      } else {
        // En lugar de alert, activamos el modal
        this.showModal = true;
      }
    }
  }

  closeModal() {
    this.showModal = false;
  }
}
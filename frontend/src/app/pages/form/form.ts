import { Component, signal } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-form',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './form.html',
  styleUrls: ['./form.css']
})

export class Form { 
  loginForm: FormGroup;

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

      // Buscamos si los credenciales coinciden con algún usuario de nuestra "lista"
      const usuarioEncontrado = this.usuariosValidos.find(
        u => u.correo === correo && u.clave === passwd
      );

      if (usuarioEncontrado) {
        console.log('Login exitoso');
        // Redirigimos al Home
        this.router.navigate(['./home']); 
      } else {
        alert('Correo o contraseña incorrectos.');
      }
    }
  }
}
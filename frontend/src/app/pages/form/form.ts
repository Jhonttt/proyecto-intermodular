import { Component } from '@angular/core';
import { Router, RouterModule } from '@angular/router'; // <--- Importante: RouterModule
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-form',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule], // <--- Añádelo aquí
  templateUrl: './form.html',
  styleUrls: ['./form.css']
})
export class AppComponent { 
  loginForm: FormGroup;
  loginError: string = ''; // <--- Nueva variable para controlar el mensaje de error visual

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
    this.loginError = ''; // Reiniciamos el error al intentar loguear

    if (this.loginForm.valid) {
      const { correo, passwd } = this.loginForm.value;

      const usuarioEncontrado = this.usuariosValidos.find(
        u => u.correo === correo && u.clave === passwd
      );

      if (usuarioEncontrado) {
        console.log('Login exitoso');
        this.router.navigate(['/home']); 
      } else {
        // En lugar de alert(), usamos la variable para activar la clase .alert-error
        this.loginError = 'Correo o contraseña incorrectos.';
      }
    }
  }
}
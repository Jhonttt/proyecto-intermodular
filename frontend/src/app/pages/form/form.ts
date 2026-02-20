import { Component, ChangeDetectorRef } from '@angular/core'; // <-- 1. Importar ChangeDetectorRef
import { Router, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpErrorResponse, HttpClientModule } from '@angular/common/http'; 

import { UserService } from '../../core/services/user.service';
import { LoginRequest, LoginResponse } from '../../core/models/user.model';

@Component({
  selector: 'app-form',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule, HttpClientModule], 
  providers: [UserService],
  templateUrl: './form.html',
  styleUrls: ['./form.css']
})
export class Form { 
  loginForm: FormGroup;
  showModal: boolean = false;
  mensajeError: string = 'Las credenciales introducidas no son correctas.'; 

  constructor(
    private fb: FormBuilder, 
    private router: Router,
    private userService: UserService,
    private cdr: ChangeDetectorRef
  ) {
    this.loginForm = this.fb.group({
      correo: ['', [Validators.required, Validators.email]],
      passwd: ['', [Validators.required]] 
    });
  }

  onLogin() {
    this.showModal = false;

    if (this.loginForm.valid) {
      const credentials: LoginRequest = {
        email: this.loginForm.value.correo,
        password: this.loginForm.value.passwd
      };

      this.userService.login(credentials).subscribe({
        next: (response: LoginResponse) => {
          console.log('✅ Login exitoso. Respuesta:', response);
          
          localStorage.setItem('token', response.access_token);
          localStorage.setItem('user', JSON.stringify(response.user));
          
          this.router.navigate(['/home']); 
        },
        error: (err: HttpErrorResponse) => {
          console.error('❌ ERROR DEL SERVIDOR (Laravel):', err.error);
          console.error('❌ CÓDIGO DE ESTADO:', err.status);
          
          if (err.status === 404) {
             this.mensajeError = 'Error 404: La ruta de la API no existe. Revisa tu api.php en Laravel.';
          } else if (err.status === 0) {
             this.mensajeError = 'Error 0: Problema de CORS o el servidor de Laravel está apagado.';
          } else {
             this.mensajeError = 'El correo electrónico o la contraseña no son correctos.';
          }

          
          this.showModal = true;
          this.cdr.detectChanges(); 
        }
      });
      
    } else {
      this.loginForm.markAllAsTouched();
    }
  }

  closeModal() {
    this.showModal = false;
    this.loginForm.get('passwd')?.reset(); 
    this.cdr.detectChanges(); 
  }
}
import { Component, ChangeDetectorRef } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpErrorResponse, HttpClientModule } from '@angular/common/http';

import { AuthService } from '../../core/services/auth.service';
import { LoginRequest } from '../../core/models/user.model';

@Component({
  selector: 'app-form',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule, HttpClientModule],
  templateUrl: './form.html',
  styleUrls: ['./form.css']
})
export class Form {
  loginForm: FormGroup;
  showModal: boolean = false;
  mensajeError: string = 'Las credenciales introducidas no son correctas.';

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
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

      this.authService.login(credentials, (err: HttpErrorResponse) => {
        if (err.status === 404) {
          this.mensajeError = 'Error 404: La ruta de la API no existe.';
        } else if (err.status === 0) {
          this.mensajeError = 'Error de CORS o servidor apagado.';
        } else {
          this.mensajeError = 'El correo electrónico o la contraseña no son correctos.';
        }
        this.showModal = true;
        this.cdr.detectChanges();
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
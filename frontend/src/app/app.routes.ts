import { Routes } from '@angular/router';
import { Home } from './pages/home/home'; 
import { HomeAdmin } from './pages/home-admin/home-admin';
import { NotFound } from './pages/not-found/not-found';

import { DetailsForm } from './pages/details-form/details-form';
import { Form } from './pages/form/form';
import { Shared } from './pages/shared/shared';
import { ForgotPassword } from './pages/forgot-password/forgot-password';
import { UploadFileComponent } from './pages/upload-file/upload-file';
import { sinProyectoGuard } from './core/guards/sin-proyecto.guard';

export const routes: Routes = [
  { path: 'login', component: Form},
  { path: 'home', component: Home },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'admin', component: HomeAdmin },
  { path: "details-form/:id", component: DetailsForm }, //php artisan storage:link → ejecutar en el backend para el video
  { path: 'shared', component: Shared },
  { path: 'forgot-password', component: ForgotPassword},
  { path: 'formulario-subida', component: UploadFileComponent, canActivate: [sinProyectoGuard]},
  { path: "**", component: NotFound},
];
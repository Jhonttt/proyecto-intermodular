import { Routes } from '@angular/router';
import { Home } from './pages/home/home';

import { DetailsForm } from './pages/details-form/details-form';
import { Form } from './pages/form/form';
import { Shared } from './pages/shared/shared';
import { UploadFileComponent } from './pages/upload-file/upload-file';

export const routes: Routes = [
  { path: 'login', component: Form},
  { path: 'home', component: Home },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: "details-form/:id", component: DetailsForm },
  { path: 'shared', component: Shared },
  { path: 'formulario-subida', component: UploadFileComponent}
];
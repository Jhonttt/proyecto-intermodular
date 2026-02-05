import { Routes } from '@angular/router';
import { Home } from './pages/home/home';

import { DetailsForm } from './pages/details-form/details-form';

export const routes: Routes = [
  { path: "", redirectTo: "home", pathMatch: "full" },
  { path: 'home', component: Home },
  { path: "details-form/:id", component: DetailsForm },
];

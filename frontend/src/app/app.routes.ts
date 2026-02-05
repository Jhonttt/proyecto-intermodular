import { Routes } from '@angular/router';
import { Home } from './pages/home/home'; 
import { HomeAdmin } from './pages/home-admin/home-admin';

import { DetailsForm } from './pages/details-form/details-form';

export const routes: Routes = [
  { path: "", redirectTo: "home", pathMatch: "full" },
  { path: 'home', component: Home },
  { path: 'admin', component: HomeAdmin },
  { path: "details-form/:id", component: DetailsForm },
];

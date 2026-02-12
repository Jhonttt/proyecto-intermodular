import { Routes } from '@angular/router';
import { Home } from './pages/home/home';

import { DetailsForm } from './pages/details-form/details-form';
import { AppComponent } from './pages/form/form';

export const routes: Routes = [
  { path: 'login', component: AppComponent},
  { path: 'home', component: Home },
  { path: "", redirectTo: "home", pathMatch: "full" },
  { path: "details-form/:id", component: DetailsForm }
];
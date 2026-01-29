import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Shared } from './pages/shared/shared';

export const routes: Routes = [
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'home', component: Home },
  { path: 'shared', component: Shared },
];

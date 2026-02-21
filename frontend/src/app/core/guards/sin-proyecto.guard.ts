import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { ProyectoService } from '../services/proyecto.service';
import { map, catchError, of } from 'rxjs';

export const sinProyectoGuard: CanActivateFn = () => {
  const proyectoService = inject(ProyectoService);
  const router = inject(Router);

  const token = localStorage.getItem('token');

  // Si no está logueado, redirigir al login
  if (!token) {
    router.navigate(['/login']);
    return of(false);
  }

  return proyectoService.getMiProyecto().pipe(
    map(() => {
      // Si tiene proyecto, redirigir a su proyecto
      router.navigate(['/home']);
      return false;
    }),
    catchError(() => {
      // Si no tiene proyecto (404), dejar pasar
      return of(true);
    })
  );
};
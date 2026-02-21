import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { ProyectoService } from '../services/proyecto.service';
import { map, catchError, of } from 'rxjs';

export const sinProyectoGuard: CanActivateFn = () => {
  const proyectoService = inject(ProyectoService);
  const router = inject(Router);

  const token = localStorage.getItem('token');
  if (!token) {
    router.navigate(['/login']);
    return of(false);
  }

  const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')!) : null;

  // Si es admin, no puede subir proyectos
  if (user && user.rol === 'admin') {
    router.navigate(['/home']);
    return of(false);
  }

  // Si el alumno no tiene proyecto_subido, dejamos pasar sin llamar al backend
  if (user && !user.proyecto_subido) {
    return of(true);
  }

  // Si tiene proyecto_subido, verificamos en backend
  return proyectoService.getMiProyecto().pipe(
    map(() => {
      router.navigate(['/home']);
      return false;
    }),
    catchError(() => of(true))
  );
};
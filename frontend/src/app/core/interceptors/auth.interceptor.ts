import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { Router } from '@angular/router';
import { catchError, throwError } from 'rxjs';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const router = inject(Router);
  const token = localStorage.getItem('token');

  // No añadir token para rutas públicas (login y GET de proyectos)
  const isPublicRoute = req.url.includes('/login') || 
                        (req.url.includes('/proyectos') && req.method === 'GET');

  let authReq = req.clone({
    setHeaders: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  });

  // Añadir token solo si existe y no es ruta pública
  if (token && !isPublicRoute) {
    authReq = authReq.clone({
      setHeaders: {
        'Authorization': `Bearer ${token}`
      }
    });
  }

  return next(authReq).pipe(
    catchError(error => {
      console.error('HTTP Error:', error);
      
      // Si es 401 y no es ruta pública, redirigir a login
      if (error.status === 401 && !isPublicRoute) {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        router.navigate(['/login']);
      }
      
      return throwError(() => error);
    })
  );
};
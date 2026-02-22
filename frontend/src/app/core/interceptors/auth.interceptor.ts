import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { Router } from '@angular/router';
import { catchError, throwError } from 'rxjs';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const router = inject(Router);
  const token = localStorage.getItem('token');

  const isPublicRoute =
    req.url.includes('/login') ||
    (req.url.includes('/proyectos') &&
      req.method === 'GET' &&
      !req.url.includes('/mi-proyecto') &&
      !token);

  // Si es FormData NO tocar Content-Type, el navegador lo gestiona solo
  const isFormData = req.body instanceof FormData;

  let authReq = isFormData
    ? req.clone({ setHeaders: { Accept: 'application/json' } })
    : req.clone({ setHeaders: { 'Content-Type': 'application/json', Accept: 'application/json' } });

  if (token && !isPublicRoute) {
    authReq = authReq.clone({
      setHeaders: { Authorization: `Bearer ${token}` },
    });
  }

  return next(authReq).pipe(
    catchError((error) => {
      console.error('HTTP Error:', error);

      if (error.status === 401 && !isPublicRoute) {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        router.navigate(['/login']);
      }

      return throwError(() => error);
    }),
  );
};

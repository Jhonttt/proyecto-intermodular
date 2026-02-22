import { Injectable, NgZone } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private tieneProyectoSubject = new BehaviorSubject<boolean>(false);
  public tieneProyecto$ = this.tieneProyectoSubject.asObservable();
  private isLoggedInSubject = new BehaviorSubject<boolean>(!!localStorage.getItem('token'));
  public isLoggedIn$: Observable<boolean> = this.isLoggedInSubject.asObservable();

  private userSubject = new BehaviorSubject<any>(
    localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')!) : null,
  );
  public user$: Observable<any> = this.userSubject.asObservable();

  private apiUrl = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,
    private router: Router,
    private ngZone: NgZone,
  ) {}

  login(credentials: { email: string; password: string }, onError?: (err: any) => void) {
    this.http.post<any>(`${this.apiUrl}/login`, credentials).subscribe({
      next: (res) => {
        localStorage.setItem('token', res.access_token);
        localStorage.setItem('user', JSON.stringify(res.user));

        this.ngZone.run(() => {
          this.isLoggedInSubject.next(true);
          this.userSubject.next(res.user);
          this.router.navigate(['/home']);
        });
      },
      error: (err) => {
        if (onError) {
          onError(err);
        } else {
          alert(err.error?.message || 'Error en login');
        }
      },
    });
  }

  logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');

    this.ngZone.run(() => {
      this.isLoggedInSubject.next(false);
      this.userSubject.next(null);
      this.router.navigate(['/login']);
    });
  }

  notificarProyectoSubido() {
    this.tieneProyectoSubject.next(true);
  }

  notificarProyectoEliminado() {
    this.tieneProyectoSubject.next(false);
  }
}

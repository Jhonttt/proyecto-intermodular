import { Injectable, NgZone } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  // 🔹 Estado de login observable
  private isLoggedInSubject = new BehaviorSubject<boolean>(false);
  public isLoggedIn$: Observable<boolean> = this.isLoggedInSubject.asObservable();

  // 🔹 Información del usuario
  private userSubject = new BehaviorSubject<any>(null);
  public user$: Observable<any> = this.userSubject.asObservable();

  private apiUrl = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,
    private router: Router,
    private ngZone: NgZone
  ) {
    // 🔹 Restaurar sesión si ya hay token
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');

    if (token && user) {
      this.isLoggedInSubject.next(true);
      this.userSubject.next(JSON.parse(user));
    }
  }

  // 🔹 Login
  login(credentials: { email: string; password: string }) {
    this.http.post<any>(`${this.apiUrl}/login`, credentials).subscribe({
      next: (res) => {
        // Guardar token y usuario
        localStorage.setItem('token', res.access_token);
        localStorage.setItem('user', JSON.stringify(res.user));

        // 🔹 Emitir estado inmediatamente
        this.ngZone.run(() => {
          this.isLoggedInSubject.next(true);
          this.userSubject.next(res.user);

          // Navegar a home
          this.router.navigate(['/home']);
        });
      },
      error: (err) => alert(err.error.message || 'Error en login')
    });
  }

  // 🔹 Logout
  logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');

    this.ngZone.run(() => {
      this.isLoggedInSubject.next(false);
      this.userSubject.next(null);
      this.router.navigate(['/login']);
    });
  }
}
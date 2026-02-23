import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User, ApiResponse, CreateUserRequest, UpdateUserRequest, LoginRequest, LoginResponse } from '../models/user.model' ;

@Injectable({
  providedIn: 'root'
})
export class UserService {
  // Rutas de tu API
  private adminApiUrl = 'http://localhost:8000/api/admin/users';
  private authApiUrl = 'http://localhost:8000/api/login';

  constructor(private http: HttpClient) {}

  // ==========================================
  // LOGIN (Con cabeceras JSON forzadas)
  // ==========================================
  login(credentials: LoginRequest): Observable<LoginResponse> {
    const headers = new HttpHeaders({
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    });
    return this.http.post<LoginResponse>(this.authApiUrl, credentials, { headers });
  }

  // ==========================================
  // CRUD DE USUARIOS (Admin)
  // ==========================================
  getAll(): Observable<ApiResponse<User[]>> {
    return this.http.get<ApiResponse<User[]>>(this.adminApiUrl);
  }

  getById(id: number): Observable<ApiResponse<User>> {
    return this.http.get<ApiResponse<User>>(`${this.adminApiUrl}/${id}`);
  }

  create(user: CreateUserRequest): Observable<ApiResponse<User>> {
    return this.http.post<ApiResponse<User>>(this.adminApiUrl, user);
  }

  update(id: number, user: UpdateUserRequest): Observable<ApiResponse<User>> {
    return this.http.put<ApiResponse<User>>(`${this.adminApiUrl}/${id}`, user);
  }

  delete(id: number): Observable<ApiResponse<void>> {
    return this.http.delete<ApiResponse<void>>(`${this.adminApiUrl}/${id}`);
  }
}
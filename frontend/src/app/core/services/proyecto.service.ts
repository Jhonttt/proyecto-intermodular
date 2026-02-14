import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Proyecto, CreateProyectoRequest, UpdateProyectoRequest } from '../models/proyecto.model';
import { ApiResponse } from '../models/user.model';

@Injectable({
  providedIn: 'root'
})
export class ProyectoService {
  private apiUrl = 'http://localhost:8000/api/proyectos';

  constructor(private http: HttpClient) {}

  // Listar todos los proyectos
  getAll(): Observable<ApiResponse<Proyecto[]>> {
    return this.http.get<ApiResponse<Proyecto[]>>(this.apiUrl);
  }

  // Obtener un proyecto específico
  getById(id: number): Observable<ApiResponse<Proyecto>> {
    return this.http.get<ApiResponse<Proyecto>>(`${this.apiUrl}/${id}`);
  }

  // Crear proyecto (solo admin)
  create(proyecto: CreateProyectoRequest): Observable<ApiResponse<Proyecto>> {
    return this.http.post<ApiResponse<Proyecto>>(this.apiUrl, proyecto);
  }

  // Actualizar proyecto (solo admin)
  update(id: number, proyecto: UpdateProyectoRequest): Observable<ApiResponse<Proyecto>> {
    return this.http.put<ApiResponse<Proyecto>>(`${this.apiUrl}/${id}`, proyecto);
  }

  // Eliminar proyecto (solo admin)
  delete(id: number): Observable<ApiResponse<void>> {
    return this.http.delete<ApiResponse<void>>(`${this.apiUrl}/${id}`);
  }
}
import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeaderAdmin } from './header-admin/header-admin';
import { SectionAdmin } from './section-admin/section-admin';
import { ArticleAdmin } from './article-admin/article-admin';
import { Footer } from '../home/footer/footer';

/* Tipos correctos */
type EstadoProyecto = 'validado' | 'pendiente';

interface Proyecto {
  id: number;
  titulo: string;
  anio: number;
  descripcion: string;
  tecnologias: string[];
  estado: EstadoProyecto;
}
@Component({
  selector: 'app-home-admin',
  standalone: true,
  imports: [CommonModule, HeaderAdmin, SectionAdmin, ArticleAdmin, Footer],
  template: `
    <app-header-admin></app-header-admin>
    <app-section-admin></app-section-admin>
    <div class="container-fluid">
      <table class="table">
        <tr>
          <th>Título</th>
          <th>Año</th>
          <th>Descripción</th>
          <th>Tecnologías</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>

        <tr *ngFor="let proyecto of proyectos">
          <app-article-admin
            [titulo]="proyecto.titulo"
            [anio]="proyecto.anio"
            [descripcion]="proyecto.descripcion"
            [tecnologias]="proyecto.tecnologias"
            [estado]="proyecto.estado"
            [acciones]="['validar', 'editar', 'eliminar']"
            (validar)="validarProyecto(proyecto.id)"
          ></app-article-admin>
        </tr>
      </table>
    </div>

    <!-- PAGINACIÓN ESTÁTICA -->
      <div
        class="paginacion"
        style="
          display: flex;
          justify-content: center;
          align-items: center;
          gap: 1rem;
          margin-top: 1rem;
        "
      >
        <span>1–3 de 5</span>

        <button disabled>‹</button>
        <button>›</button>
      </div>

    <app-footer></app-footer>
  `,
})
export class HomeAdmin {

  proyectos: Proyecto[] = [
    {
      id: 1,
      titulo: 'Sistema de Biblioteca Escolar',
      anio: 2024,
      descripcion: 'Proyecto de gestión de biblioteca',
      tecnologias: ['Angular', 'React', 'Javascript'],
      estado: 'pendiente'
    },
    {
      id: 2,
      titulo: 'Gestor de Reservas',
      anio: 2024,
      descripcion: 'Sistema de reservas de aulas',
      tecnologias: ['Angular'],
      estado: 'validado'
    },
    {
      id: 3,
      titulo: 'Plataforma Educativa',
      anio: 2024,
      descripcion: 'Portal educativo para alumnos',
      tecnologias: ['Vue', 'Node'],
      estado: 'pendiente'
    }
  ];

  validarProyecto(id: number) {
    const proyecto = this.proyectos.find(p => p.id === id);
    if (proyecto) {
      proyecto.estado = 'validado';
    }
  }
}
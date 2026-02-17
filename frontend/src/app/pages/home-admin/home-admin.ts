import { Component } from '@angular/core';
import { SectionAdmin } from './section-admin/section-admin';
import { ArticleAdmin } from './article-admin/article-admin';

@Component({
  selector: 'app-home-admin',
  standalone: true,
  imports: [SectionAdmin, ArticleAdmin],
  styleUrl: './home-admin.css',
  template: `
    <app-section-admin></app-section-admin>
    <div class="container-fluid text-center mb-4">
      <table class="table">
        <tr>
          <th>Título</th>
          <th>Año</th>
          <th>Descripción</th>
          <th>Tecnologías</th>
          <th>Estado</th>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            descripcion="aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>

        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
            estado="Pendiente";
          ></app-article-admin>
        </tr>
      </table>

      <div
        class="paginacion d-flex justify-content-center align-items-center gap-3">
        <span>1–8 de 15</span>
        <input type="number" class="form-control text-center" style="width: 50px">
        <button class="btn fs-5" disabled>‹</button>
        <button class="btn fs-5">›</button>
      </div>
    </div>
  `,
})
export class HomeAdmin {}

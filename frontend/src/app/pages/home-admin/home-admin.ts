import { Component } from '@angular/core';
import { HeaderAdmin } from './header-admin/header-admin';
import { SectionAdmin } from './section-admin/section-admin';
import { ArticleAdmin } from './article-admin/article-admin';
import { Footer } from '../home/footer/footer';

@Component({
  selector: 'app-home-admin',
  standalone: true,
  imports: [HeaderAdmin, SectionAdmin, ArticleAdmin, Footer],
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
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            descripcion="aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>

        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>
        <tr>
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article-admin>
        </tr>
      </table>
    </div>

    <app-footer></app-footer>
  `,
})
export class HomeAdmin {}

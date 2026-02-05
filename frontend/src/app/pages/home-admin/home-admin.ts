import { Component } from '@angular/core';
import { HeaderAdmin } from './header-admin/header-admin';
import { SectionAdmin } from './section-admin/section-admin';
import { ArticleAdmin } from './article-admin/article-admin';
import { Footer } from '../home/footer/footer';
/* Añadir boton ver detalle */
@Component({
  selector: 'app-home-admin',
  standalone: true,
  imports: [HeaderAdmin, SectionAdmin, ArticleAdmin, Footer],
  template: `
  <app-header-admin></app-header-admin>
  <app-section-admin></app-section-admin>
  <div>
    <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
        <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
        <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
        <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
        <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
        <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
        <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
        <app-article-admin
    titulo = "Sistema de Biblioteca Escolar"
    [anio] = "2024"
    [tecnologias]="['Angular', 'React', 'Javascript']"
    ></app-article-admin>
  </div>

  <app-footer></app-footer>
  `
})
export class HomeAdmin { }

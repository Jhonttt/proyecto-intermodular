import { Component } from '@angular/core';
import { Header } from './header/header';
import { Article } from './article/article';
import { Section } from './section/section';
import { Footer } from './footer/footer';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [Header, Article, Section, Footer],
  template: `
    <app-header></app-header>
    <app-section></app-section>
    <div class="container mb-4 justify-content-center ">
      <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
        <div class="col">
          <app-article
            imagen="images/prueba.webp"
            titulo="Sistema de Gestión Universitaria"
            anio="2019"
            descripcion="Sistema para la administración académica y administrativa."
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article>
        </div>
        <div class="col">
          <app-article
            imagen="images/prueba.webp"
            titulo="Sistema de Gestión Universitaria"
            anio="2019"
            descripcion="Sistema para la administración académica y administrativa."
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article>
        </div>
        <div class="col">
          <app-article
            imagen="images/prueba.webp"
            titulo="Sistema de Gestión Universitaria"
            anio="2019"
            descripcion="Sistema para la administración académica y administrativa."
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article>
        </div>
        <div class="col">
          <app-article
            imagen="images/prueba.webp"
            titulo="Sistema de Gestión Universitaria"
            anio="2019"
            descripcion="Sistema para la administración académica y administrativa."
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article>
        </div>
        <div class="col">
          <app-article
            imagen="images/prueba.webp"
            titulo="Sistema de Gestión Universitaria"
            anio="2019"
            descripcion="Sistema para la administración académica y administrativa."
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article>
        </div>
        <div class="col">
          <app-article
            imagen="images/prueba.webp"
            titulo="Sistema de Gestión Universitaria"
            anio="2019"
            descripcion="Sistema para la administración académica y administrativa."
            [tecnologias]="['Angular', 'React', 'Javascript']"
          ></app-article>
        </div>
      </div>
    </div>
    <app-footer></app-footer>
  `,
})
export class Home {}

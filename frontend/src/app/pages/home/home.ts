import { Component } from '@angular/core';
import { Article } from './article/article';
import { Section } from './section/section';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [Article, Section],
  template: `
    <app-section clsas="mb-5" />
    <div class="container py-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
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
  `,
})
export class Home {}

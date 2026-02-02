import { Component } from '@angular/core';
import { Header } from './header/header';
import { Article } from './article/article';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [Article],
  template: `<app-article
    imagen="images/prueba.webp"
    titulo="Sistema de Gestión Universitaria"
    anio="2019"
    descripcion="Sistema para la administración académica y administrativa."
    [tecnologias]="['Angular', 'React', 'Javascript']"
  ></app-article> `,
})
export class Home {}

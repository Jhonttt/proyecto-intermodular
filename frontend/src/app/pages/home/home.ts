import { Component } from '@angular/core';
import { Header } from './header/header';
import { Article } from './article/article';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [Article],
  template: `<app-article></app-article>`
})
export class Home {}
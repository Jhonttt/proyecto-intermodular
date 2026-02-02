import { Component } from '@angular/core';
import { Header } from './header/header';
import { Section } from './section/section';
import { Footer } from './footer/footer';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [Header,Section,Footer],
  template: `
  <app-header></app-header>
  <app-section></app-section>
  <app-footer></app-footer>
  `
})


export class Home {}
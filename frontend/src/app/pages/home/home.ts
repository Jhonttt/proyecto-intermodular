import { Component } from '@angular/core';
import { Header } from './header/header';
import { Section } from './section/section';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [Header,Section],
  template: `
  <app-header></app-header>
  <app-section></app-section>
  `
})


export class Home {}
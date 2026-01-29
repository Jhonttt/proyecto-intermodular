import { Component } from '@angular/core';
import { Header } from './header/header';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [Header],
  template: `<app-header></app-header>`
})
export class Home {}
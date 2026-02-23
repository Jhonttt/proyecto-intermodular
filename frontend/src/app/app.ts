import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { Navbar } from './pages/layout/navbar/navbar';
import { Footer } from './pages/layout/footer/footer';
import { signal } from '@angular/core';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, Navbar, Footer],
  templateUrl: './app.html',
  styleUrls: ['./app.css']
})
export class App {
  protected readonly title = signal('frontend');
}
import { Component, OnInit } from '@angular/core';
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
export class App implements OnInit {
  protected readonly title = signal('frontend');

  ngOnInit(): void {
    // 🔹 Solo recargar la página la primera vez que entra
    if (!sessionStorage.getItem('reloaded')) {
      sessionStorage.setItem('reloaded', 'true');
      window.location.href = window.location.href; // 🔹 Recarga completa
    }
  }
}
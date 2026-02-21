import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { AuthService } from '../../../core/services/auth.service';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './navbar.html',
  styleUrls: ['./navbar.css']
})
export class Navbar {

  constructor(private authService: AuthService) {}

  // 🔹 Getter directo desde localStorage
  get isLoggedIn(): boolean {
    return !!localStorage.getItem('token');
  }

  get user(): any {
    const u = localStorage.getItem('user');
    return u ? JSON.parse(u) : null;
  }

  logout() {
    this.authService.logout();
  }

  get hasProject(): boolean {
    return this.user?.proyecto_subido === true;
  }
}
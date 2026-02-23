import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';

@Component({
  selector: 'app-article',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './article.html',
  styleUrl: './article.css',
})
export class Article {
  @Input() id!: number; // ← NUEVO: añadir ID del proyecto
  @Input() imagen!: string;
  @Input() titulo!: string;
  @Input() anio!: string | number;
  @Input() descripcion!: string;
  @Input() tecnologias: string[] = [];

  constructor(private router: Router) {}

  verDetalle(): void {
    this.router.navigate(['/details-form', this.id]);
  }
}
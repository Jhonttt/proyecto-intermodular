import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-article',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './article.html',
  styleUrl: './article.css',
})
export class Article {
  @Input() imagen!: string;
  @Input() titulo!: string;
  @Input() anio!: string | number;
  @Input() descripcion!: string;
  @Input() tecnologias: string[] = [];
}

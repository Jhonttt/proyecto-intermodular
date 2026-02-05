import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-article-admin',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './article-admin.html',
  styleUrl: './article-admin.css',
})
export class ArticleAdmin {
  //@Input() imagen!: string;
  @Input() titulo!: string;
  @Input() anio!: string | number;
  @Input() descripcion!: string;
  @Input() tecnologias: string[] = [];
}

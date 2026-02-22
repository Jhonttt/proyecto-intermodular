import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-article-admin',
  standalone: true,
  imports: [CommonModule ],
  templateUrl: './article-admin.html',
  styleUrl: './article-admin.css',
    host: {
    '[style.display]': '"contents"'
  }
})
export class ArticleAdmin {
  @Input() titulo!: string;
  @Input() anio!: string | number;
  @Input() tecnologias: string[] = [];
  @Input() ciclo!: string;
  @Input() descripcion!: string;
  @Input() estado!: 'Validado' | 'Pendiente';
}

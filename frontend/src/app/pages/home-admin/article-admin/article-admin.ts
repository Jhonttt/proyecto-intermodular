import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BotonesProyecto } from '../../shared/botones-proyecto/botones-proyecto';

@Component({
  selector: 'app-article-admin',
  standalone: true,
  imports: [CommonModule, BotonesProyecto ],
  templateUrl: './article-admin.html',
  styleUrl: './article-admin.css',
    host: {
    '[style.display]': '"contents"'
  }
})
export class ArticleAdmin {
  //@Input() imagen!: string;
  @Input() titulo!: string;
  @Input() anio!: string | number;
  @Input() descripcion!: string;
  @Input() tecnologias: string[] = [];
  @Input() estado!: 'Valido' | 'Pendiente';
}

import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-article-admin',
  standalone: true,
  imports: [CommonModule],
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
  @Input() acciones: string[] = [];
  @Input() estado!: 'validado' | 'pendiente';
  
  @Output() validar = new EventEmitter<void>();

  onValidar() {
    this.validar.emit();
  }

  onEditar() {}
  onEliminar() {}
}

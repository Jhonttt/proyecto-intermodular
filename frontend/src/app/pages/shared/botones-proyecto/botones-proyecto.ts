import { Component, Input, output } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-botones-proyecto',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './botones-proyecto.html',
  styleUrl: './botones-proyecto.css',
})
export class BotonesProyecto {
  // Input para saber si está en la zona privada
  @Input() esPrivado: boolean = false;

  // Acciones que puede tener el componente
  // onValidar = output<void>();
  onModificar = output<void>();
  onEliminar = output<void>();

  // validar() {
    // this.onValidar.emit();
  // }
  modificar() {
    this.onModificar.emit();
  }
  eliminar() {
    this.onEliminar.emit();
  }
}

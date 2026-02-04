import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-details-form',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './details-form.html',
  styleUrls: ['./details-form.css'],
})
export class DetailsForm implements OnInit {
  projectId!: number;

  //Estados de la pantalla
  loading: boolean = true;
  error: boolean = false;

  //Pruebas
  project: {
    title: string;
    autores: string | string[];
    descripcion: string;
    curso: string;
    etiquetas: string;
  } | null = null;

  constructor(private route: ActivatedRoute) {}

  ngOnInit(): void {
    this.projectId = Number(this.route.snapshot.paramMap.get('id'));

    //Carga simulada del backend

    try {
      this.project = {
        title: 'Desarrollo web en Laravel',
        autores: ['Felipe V', 'Gustavo Sánchez'],
        descripcion: 'Texto de ejemplo para muestra de práctica',
        curso: '2º DAW',
        etiquetas: 'Laravel, PHP, Angular',
      };

      this.loading = false;
    } catch (e) {
      this.error = true;
      this.loading = false;
    }
  }

  //Para el HTML (evita usar instanceof en template)
  get autoresEsArray(): boolean {
    return Array.isArray(this.project?.autores);
  }
}

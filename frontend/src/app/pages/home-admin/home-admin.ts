import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SectionAdmin } from './section-admin/section-admin';
import { ArticleAdmin } from './article-admin/article-admin';
@Component({
  selector: 'app-home-admin',
  standalone: true,
  imports: [SectionAdmin, ArticleAdmin, CommonModule],
  styleUrl: './home-admin.css',
  template: `
    <app-section-admin></app-section-admin>

    <div class="container-fluid text-center mb-4">
      <table class="table">
        <tr>
          <th>Título</th>
          <th>Año</th>
          <th>Curso</th>
          <th>Descripción</th>
          <th>Estado</th>
        </tr>

        <!-- ===== PÁGINA 1 ===== -->
        <tr *ngIf="paginaActual === 1">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion="aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            estado="Pendiente">
          </app-article-admin>
        </tr>

        <tr *ngIf="paginaActual === 1">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion=""
            estado="Pendiente">
          </app-article-admin>
        </tr>

        <tr *ngIf="paginaActual === 1">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion=""
            estado="Pendiente">
          </app-article-admin>
        </tr>

        <!-- ===== PÁGINA 2 ===== -->
        <tr *ngIf="paginaActual === 2">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion=""
            estado="Pendiente">
          </app-article-admin>
        </tr>

        <tr *ngIf="paginaActual === 2">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion=""
            estado="Pendiente">
          </app-article-admin>
        </tr>

        <tr *ngIf="paginaActual === 2">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion=""
            estado="Pendiente">
          </app-article-admin>
        </tr>

        <!-- ===== PÁGINA 3 ===== -->
        <tr *ngIf="paginaActual === 3">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion=""
            estado="Pendiente">
          </app-article-admin>
        </tr>

        <tr *ngIf="paginaActual === 3">
          <app-article-admin
            titulo="Sistema de Biblioteca Escolar"
            [anio]="2024"
            curso="DAW 2º"
            descripcion=""
            estado="Pendiente">
          </app-article-admin>
        </tr>
      </table>

      <!-- CONTROLES DE PAGINACIÓN -->
      <div class="paginacion d-flex justify-content-center align-items-center gap-3">
        <span>Página {{ paginaActual }} de {{ totalPaginas }}</span>

        <input
          type="number"
          class="form-control text-center"
          style="width: 60px"
          [value]="paginaActual"
          min="1"
          [max]="totalPaginas"
          (change)="irAPagina($event)">

        <button
          class="btn fs-5"
          (click)="paginaAnterior()"
          [disabled]="paginaActual === 1">
          ‹
        </button>

        <button
          class="btn fs-5"
          (click)="paginaSiguiente()"
          [disabled]="paginaActual === totalPaginas">
          ›
        </button>
      </div>
    </div>
  `,
})
export class HomeAdmin {
  paginaActual = 1;
  totalPaginas = 3;

  paginaSiguiente() {
    if (this.paginaActual < this.totalPaginas) {
      this.paginaActual++;
    }
  }

  paginaAnterior() {
    if (this.paginaActual > 1) {
      this.paginaActual--;
    }
  }

  irAPagina(event: Event) {
    const valor = Number((event.target as HTMLInputElement).value);
    if (valor >= 1 && valor <= this.totalPaginas) {
      this.paginaActual = valor;
    }
  }
}
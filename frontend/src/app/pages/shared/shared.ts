import { Component } from '@angular/core';
import { BotonesProyecto } from './botones-proyecto/botones-proyecto';

@Component({
  selector: 'app-shared',
  standalone: true,
  imports: [BotonesProyecto],
  template: ` <app-botones-proyecto [esPrivado]="true"></app-botones-proyecto> `,
})
export class Shared {}

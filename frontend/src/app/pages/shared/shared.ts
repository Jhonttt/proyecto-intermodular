import { Component } from '@angular/core';
import { BotonesProyecto } from './botones-proyecto/botones-proyecto';

@Component({
  selector: 'app-shared',
  standalone: true,
  imports: [BotonesProyecto],
  template: ` <app-botones-proyecto [esPrivado]="true"></app-botones-proyecto> 
   <app-botones-proyecto [esPrivado]="false"></app-botones-proyecto> `, 
  //  Para el home público, [esPrivado]="false", esto quita el botón de validar automáticamente
  //  Se puede hacer que cada botón ejecute una función del padre poniendo <app-botones-proyecto (onValidar)="funciónPadre()">
})
export class Shared {}

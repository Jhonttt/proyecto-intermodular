import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BotonesProyecto } from './botones-proyecto';

describe('BotonesProyecto', () => {
  let component: BotonesProyecto;
  let fixture: ComponentFixture<BotonesProyecto>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BotonesProyecto],
    }).compileComponents();

    fixture = TestBed.createComponent(BotonesProyecto);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
  it('debería emitir onModificar al hacer click', async () => {
    const eventoPromesa = new Promise<void>((resolve) => {
      component.onModificar.subscribe(() => {
        resolve();
      });
    });

    const btnMod = fixture.nativeElement.querySelector('.btn-warning');
    btnMod.click();

    await eventoPromesa;
  });

  it('debería emitir onEliminar al hacer click', async () => {
    const eventoPromesa = new Promise<void>((resolve) => {
      component.onEliminar.subscribe(() => {
        resolve();
      });
    });

    const btnEli = fixture.nativeElement.querySelector('.btn-danger');
    btnEli.click();

    await eventoPromesa;
  });
});

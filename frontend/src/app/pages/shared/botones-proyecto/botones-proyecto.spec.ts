import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BotonesProyecto } from './botones-proyecto';

describe('BotonesProyecto', () => {
  let component: BotonesProyecto;
  let fixture: ComponentFixture<BotonesProyecto>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BotonesProyecto]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BotonesProyecto);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

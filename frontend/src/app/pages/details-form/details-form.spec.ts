import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsForm } from './details-form';

describe('DetailsForm', () => {
  let component: DetailsForm;
  let fixture: ComponentFixture<DetailsForm>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DetailsForm]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DetailsForm);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

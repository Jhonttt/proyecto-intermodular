import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SectionAdmin } from './section-admin';

describe('SectionAdmin', () => {
  let component: SectionAdmin;
  let fixture: ComponentFixture<SectionAdmin>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SectionAdmin]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SectionAdmin);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

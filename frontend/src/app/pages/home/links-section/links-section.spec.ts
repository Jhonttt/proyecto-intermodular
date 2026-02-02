import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LinksSection } from './links-section';

describe('LinksSection', () => {
  let component: LinksSection;
  let fixture: ComponentFixture<LinksSection>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [LinksSection]
    })
    .compileComponents();

    fixture = TestBed.createComponent(LinksSection);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

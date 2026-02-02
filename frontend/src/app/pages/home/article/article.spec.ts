import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Article } from './article';

describe('Article', () => {
  let component: Article;
  let fixture: ComponentFixture<Article>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Article]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Article);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

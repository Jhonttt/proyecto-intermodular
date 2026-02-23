import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ArticleAdmin } from './article-admin';

describe('ArticleAdmin', () => {
  let component: ArticleAdmin;
  let fixture: ComponentFixture<ArticleAdmin>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ArticleAdmin]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ArticleAdmin);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

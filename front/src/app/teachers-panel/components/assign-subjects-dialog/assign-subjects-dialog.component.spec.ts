import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AssignSubjectsDialogComponent } from './assign-subjects-dialog.component';

describe('AssignSubjectsDialogComponent', () => {
  let component: AssignSubjectsDialogComponent;
  let fixture: ComponentFixture<AssignSubjectsDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AssignSubjectsDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AssignSubjectsDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

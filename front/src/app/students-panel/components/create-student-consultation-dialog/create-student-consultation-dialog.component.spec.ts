import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateStudentConsultationDialogComponent } from './create-student-consultation-dialog.component';

describe('CreateStudentConsultationDialogComponent', () => {
  let component: CreateStudentConsultationDialogComponent;
  let fixture: ComponentFixture<CreateStudentConsultationDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreateStudentConsultationDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateStudentConsultationDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

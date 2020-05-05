import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditStudentsConsultationComponent } from './edit-students-consultation.component';

describe('EditStudentsConsultationComponent', () => {
  let component: EditStudentsConsultationComponent;
  let fixture: ComponentFixture<EditStudentsConsultationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditStudentsConsultationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditStudentsConsultationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

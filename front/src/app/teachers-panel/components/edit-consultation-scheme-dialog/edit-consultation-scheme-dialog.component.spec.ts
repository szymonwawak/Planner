import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditConsultationSchemeDialogComponent } from './edit-consultation-scheme-dialog.component';

describe('EditConsultationSchemeDialogComponent', () => {
  let component: EditConsultationSchemeDialogComponent;
  let fixture: ComponentFixture<EditConsultationSchemeDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditConsultationSchemeDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditConsultationSchemeDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

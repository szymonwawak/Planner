import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddConsultationSchemeDialogComponent } from './add-consultation-scheme-dialog.component';

describe('AddConsultationSchemeDialogComponent', () => {
  let component: AddConsultationSchemeDialogComponent;
  let fixture: ComponentFixture<AddConsultationSchemeDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AddConsultationSchemeDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddConsultationSchemeDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

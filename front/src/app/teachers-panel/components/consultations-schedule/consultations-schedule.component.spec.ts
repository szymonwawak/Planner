import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConsultationsScheduleComponent } from './consultations-schedule.component';

describe('ConsultationsScheduleComponent', () => {
  let component: ConsultationsScheduleComponent;
  let fixture: ComponentFixture<ConsultationsScheduleComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConsultationsScheduleComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConsultationsScheduleComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

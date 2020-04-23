import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IncomingConsultationsComponent } from './incoming-consultations.component';

describe('IncomingConsultationsComponent', () => {
  let component: IncomingConsultationsComponent;
  let fixture: ComponentFixture<IncomingConsultationsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IncomingConsultationsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IncomingConsultationsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

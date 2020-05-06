import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ChangeTeacherDataComponent } from './change-teacher-data.component';

describe('ChangeTeacherDataComponent', () => {
  let component: ChangeTeacherDataComponent;
  let fixture: ComponentFixture<ChangeTeacherDataComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ChangeTeacherDataComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ChangeTeacherDataComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

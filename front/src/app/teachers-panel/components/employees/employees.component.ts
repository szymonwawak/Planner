import {Component, OnInit} from '@angular/core';
import {Teacher} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {PageEvent} from "@angular/material/paginator";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-employees',
  templateUrl: './employees.component.html',
  styleUrls: ['./employees.component.css']
})
export class EmployeesComponent implements OnInit {

  teachers: Teacher[];
  teacher: Teacher;
  paginatedTeachers: Teacher[];
  pageSize: number = 10;
  length: number;
  disabled: boolean = true;
  createUserForm: FormGroup;

  constructor(private apiService: ApiService, private formBuilder: FormBuilder, private utils: UtilsService) {
  }

  ngOnInit(): void {
    this.teacher = new Teacher();
    this.getTeachers();
    this.createUserForm = this.formBuilder.group({
      'name': [{value: this.teacher.name, disabled: true}, Validators.required],
      'surname': [{value: this.teacher.surname, disabled: true}, Validators.required],
      'email': [{value: this.teacher.email, disabled: true}, Validators.required],
    });
  }

  getTeachers(): void {
    this.apiService.getAllTeachers().subscribe(
      res => {
        this.teachers = res;
        this.paginatedTeachers = this.teachers.slice(0, this.pageSize)
        this.length = this.teachers.length;
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
  }

  setTeacher(teacher: Teacher) {
    this.teacher = teacher;
    this.createUserForm.setValue({
      'name': this.teacher.name,
      'surname': this.teacher.surname,
      'email': this.teacher.email
    });
  }

  prepareNewTeacher() {
    this.enableInputs();
    this.clearUser();
  }

  enableInputs() {
    for (let controlsKey in this.createUserForm.controls) {
      this.createUserForm.controls[controlsKey].enable();
    }
  }

  clearUser() {
    this.createUserForm.setValue({
      'name': '',
      'surname': '',
      'email': ''
    });
    this.teacher = null;
  }

  createTeacher() {
    if (this.createUserForm.invalid)
      return;
    this.teacher = this.createUserForm.value;
    this.apiService.createTeacher(this.teacher).subscribe(
      res => {
        this.utils.openSnackBar(res.message);
        this.ngOnInit()
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
  }

  dismissCreating() {
    this.ngOnInit()
  }

  disableInputs() {
    for (let controlsKey in this.createUserForm.controls) {
      this.createUserForm.controls[controlsKey].disable();
    }
  }

  changePage(event: PageEvent): void {
    let offset = event.pageSize * event.pageIndex;
    this.paginatedTeachers = this.teachers.slice(offset, offset + this.pageSize);
  }
}

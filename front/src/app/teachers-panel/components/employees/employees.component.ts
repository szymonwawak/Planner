import {Component, OnInit} from '@angular/core';
import {Teacher} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";

@Component({
  selector: 'app-employees',
  templateUrl: './employees.component.html',
  styleUrls: ['./employees.component.css']
})
export class EmployeesComponent implements OnInit {

  teachers: Teacher[];
  teacher: Teacher = {
    id: '',
    name: '',
    surname: '',
    email: '',
    subjects: []
  };

  disabled: boolean = true;

  constructor(private apiService: ApiService) {
  }

  ngOnInit(): void {
    this.getTeachers();
  }

  getTeachers(): void {
    this.apiService.getAllTeachers().subscribe(
      res => {
        this.teachers = res;
      },
      err => {
        alert("Wystąpił błąd");
      }
    )
  }

  createTeacher() {
    this.apiService.createTeacher(this.teacher).subscribe(
      res => {
        alert("Użytkownik został dodany!")
      },
      err => {
        alert("Wystąpił błąd");
      }
    )
  }

  setTeacher(teacher: Teacher) {
    this.teacher = teacher;
  }

  prepareNewTeacher() {
    this.disabled = false;
    this.teacher = {
      id: '',
      name: '',
      surname: '',
      email: '',
      subjects: null
    };
  }

  dismissCreating() {
    this.disabled = true;
    this.teacher = {
      id: '',
      name: '',
      surname: '',
      email: '',
      subjects: []
    };
  }
}

import {Component, Input, OnInit} from '@angular/core';
import {LessonModel} from "../planner-view/planner-view.component";
import {ApiService} from "../../../shared/api.service";

@Component({
  selector: 'app-search-panel',
  templateUrl: './search-panel.component.html',
  styleUrls: ['./search-panel.component.css']
})
export class SearchPanelComponent implements OnInit {

  subjects: Array<Subject>;

  teachers: Array<Teacher>;

  @Input() lessonModel: LessonModel;
  search: string = '';

  constructor(private apiService: ApiService) {
  }

  ngOnInit(): void {
    this.getTeachers();
    this.getSubjects();
  }

  setTeacher(teacher: Teacher) {
    this.lessonModel.teacher = teacher;
    this.lessonModel.subject = null;
    this.search = '';
  }

  filterSubjects() {
    if (this.lessonModel.teacher == null)
      return this.subjects;
    else
      return this.lessonModel.teacher.subjects;
  }

  filterTeachers() {
    if (this.lessonModel.subject == null)
      return this.teachers;
    else
      return this.teachers.filter(item => item.subjects.indexOf(this.lessonModel.subject) != -1);
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

  getSubjects(): void {
    this.apiService.getAllSubjects().subscribe(
      res => {
        this.subjects = res;
      },
      err => {
        alert("Wystąpił błąd");
      }
    )
  }
}

export class Teacher {
  id: string;
  name: string;
  surname: string;
  email: string;
  subjects: Array<Subject>;
}

export class Subject {
  id: string;
  subject_name: string;
}

import {Component, Input, OnInit} from '@angular/core';
import {LessonModel} from "../planner-view/planner-view.component";

@Component({
  selector: 'app-search-panel',
  templateUrl: './search-panel.component.html',
  styleUrls: ['./search-panel.component.css']
})
export class SearchPanelComponent implements OnInit {

  subjects: Array<Subject> = [
    {idsubject: 1, subjectname: 'Fizyka'},
    {idsubject: 2, subjectname: 'Matematyka'},
    {idsubject: 3, subjectname: 'Podstawy projektowania sieci internetowych'},
    {idsubject: 4, subjectname: 'Podstawy programowania'},
    {idsubject: 5, subjectname: 'Wprowadzenie do informatyki'},
    {idsubject: 6, subjectname: 'Języki dynamicznych stron internetowych'},
    {idsubject: 7, subjectname: 'Projektowanie aplikacji internetowych'},
  ];

  teachers: Array<Teacher> = [
    {id: 1, name: 'Jan', surname: 'Kowalski', subjects: [this.subjects[0], this.subjects[2]]},
    {id: 2, name: 'Adam', surname: 'Mickiewicz', subjects: [this.subjects[1], this.subjects[3]]},
    {id: 3, name: 'Marian', surname: 'Żółtek', subjects: [this.subjects[5], this.subjects[4]]},
    {id: 4, name: 'Stanisław', surname: 'Lem', subjects: [this.subjects[2], this.subjects[6]]},
    {id: 5, name: 'Henryk', surname: 'Komorowski', subjects: [this.subjects[3], this.subjects[1]]},
    {id: 6, name: 'Przemysław', surname: 'Jagiełło', subjects: [this.subjects[4], this.subjects[2]]},
    {id: 7, name: 'Marcin', surname: 'Lewandowski', subjects: [this.subjects[5], this.subjects[3]]},
  ];

  @Input() lessonModel: LessonModel;
  search: string = '';

  constructor() {
  }

  ngOnInit(): void {
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
}

export interface Teacher {
  id: number;
  name: string;
  surname: string;
  subjects: Array<Subject>;
}

export interface Subject {
  idsubject: number;
  subjectname: string;
}

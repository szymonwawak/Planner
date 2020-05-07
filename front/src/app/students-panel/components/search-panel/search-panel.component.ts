import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {LessonModel} from "../planner-view/planner-view.component";
import {ApiService} from "../../../shared/api.service";
import {ConsultationScheme} from "../../../teachers-panel/components/consultations-schedule/consultations-schedule.component";
import {StudentsConsultation} from "../../../teachers-panel/components/incoming-consultations/incoming-consultations.component";
import {EventInput} from "@fullcalendar/core/structs/event";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-search-panel',
  templateUrl: './search-panel.component.html',
  styleUrls: ['./search-panel.component.css']
})
export class SearchPanelComponent implements OnInit {

  search: string = '';
  subjects: Array<Subject>;
  teachers: Array<Teacher>;
  @Input() lessonModel: LessonModel;
  @Output() onSelect = new EventEmitter<boolean>();

  constructor(private apiService: ApiService, private utils: UtilsService) {
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

  getTeachers(): void {
    this.apiService.getAllTeachers().subscribe(
      res => {
        this.teachers = res;
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
  }

  getSubjects(): void {
    this.apiService.getAllSubjects().subscribe(
      res => {
        this.subjects = res;
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
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
      return this.teachers.filter(
        (item) => item.subjects.find(
          ({name}) => name == this.lessonModel.subject.name
        )
      );
  }

  loadCalendarIfEverythingIsSet() {
    if (this.lessonModel.teacher) {
      this.onSelect.emit();
    }
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
  name: string;
  pivot: TeacherSubject;
}

export class TeacherSubject {
  id: string;
  teacher_id: string;
  subject_id: string;
}

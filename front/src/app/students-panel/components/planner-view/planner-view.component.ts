import {Component, OnInit, ViewChild, ViewContainerRef} from '@angular/core';
import {Subject, Teacher} from "../search-panel/search-panel.component";
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import {EventInput} from "@fullcalendar/core/structs/event";
import {ApiService} from "../../../shared/api.service";
import {StudentsConsultation} from "../../../teachers-panel/components/incoming-consultations/incoming-consultations.component";
import {FullCalendarComponent} from "@fullcalendar/angular";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {CreateStudentConsultationDialogComponent} from "../create-student-consultation-dialog/create-student-consultation-dialog.component";
import {ConsultationScheme} from "../../../teachers-panel/components/consultations-schedule/consultations-schedule.component";

@Component({
  selector: 'app-planner-view',
  templateUrl: './planner-view.component.html',
  styleUrls: ['./planner-view.component.css']
})
export class PlannerViewComponent implements OnInit {
  @ViewChild('calendarComponent') calendarComponent: FullCalendarComponent;

  validDate;

  calendarPlugins = [timeGridPlugin, interactionPlugin];
  events: EventInput[] = [];
  teacherEvents: EventInput[] = [];
  consultations;

  lessonModel: LessonModel = {
    teacher: null,
    subject: null
  };

  consultationSchemes: ConsultationScheme[];
  studentConsultations: StudentsConsultation[];

  constructor(private apiService: ApiService, public viewContainerRef: ViewContainerRef, private dialog: MatDialog) {
  }

  openNewEventDialog(event) {
    if (this.events.filter((el) => this.events.find(
      () => el.color == '#60c04f') && el.daysOfWeek.indexOf(event.start.getDay()) != -1 &&
      event.start.toLocaleTimeString() >= el.startTime && event.end.toLocaleTimeString() <= el.endTime).length > 0
    ) {
      const dialogConfig = new MatDialogConfig();
      dialogConfig.disableClose = true;
      dialogConfig.autoFocus = true;
      dialogConfig.width = '450px';
      dialogConfig.data = event;
      this.dialog.open(CreateStudentConsultationDialogComponent, dialogConfig).afterClosed().subscribe(
        () => this.loadCalendar()
      );
    }
  }

  calendarValidStart() {
    return new Date();
  }

  calendarValidEnd() {
    let currentDate: Date = new Date();
    let lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    let difference = (lastDay.getTime() - currentDate.getTime());
    difference = difference / (1000 * 3600 * 24);
    if (difference > 7)
      return lastDay;
    lastDay.setMonth(lastDay.getMonth() + 1);
    lastDay.setDate(0);
    return lastDay;
  }

  ngOnInit(): void {
    this.validDate = {start: this.calendarValidStart(), end: this.calendarValidEnd()}
  }

  loadCalendar(): void {
    let id = this.lessonModel.teacher.id;
    this.events = [];
    this.apiService.getConsultationSchemesByTeacherId(id).subscribe(
      res => {
        this.consultationSchemes = res;
        this.prepareConsultationSchemes();
      },
      err => {

      }
    );
    this.apiService.getStudentsConsultationsByTeacherId(id).subscribe(
      res => {
        this.studentConsultations = res;
        this.prepareEvents();
      },
      err => {

      }
    );
  }

  prepareConsultationSchemes(): void {
    let events = [];
    this.consultationSchemes.forEach(function (value: ConsultationScheme) {
      this.push({
        startRecur: value.start_date,
        endRecur: value.end_date,
        daysOfWeek: [value.day],
        startTime: value.start_time,
        endTime: value.finish_time,
        rendering: 'background',
        color: '#60c04f'
      })
    }, events);
    this.events = this.events.concat(events);
  }

  prepareEvents(): void {
    let events = [];
    this.studentConsultations.forEach(function (value: StudentsConsultation) {
      this.push({
        title: value.subject.name,
        start: value.date + 'T' + value.start_time,
        end: value.date + 'T' + value.finish_time
      })
    }, events);
    this.events = this.events.concat(events);
  }
}

export interface LessonModel {
  teacher: Teacher;
  subject: Subject;
}

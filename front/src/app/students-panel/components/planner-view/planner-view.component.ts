import {Component, OnInit, ViewChild, ViewContainerRef} from '@angular/core';
import {Subject, Teacher} from "../search-panel/search-panel.component";
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import {EventInput} from "@fullcalendar/core/structs/event";
import {ApiService} from "../../../shared/api.service";
import {StudentsConsultation} from "../../../teachers-panel/components/incoming-consultations/incoming-consultations.component";
import {FullCalendarComponent} from "@fullcalendar/angular";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {EditStudentsConsultationComponent} from "../../../teachers-panel/components/edit-students-consultation/edit-students-consultation.component";
import {CreateStudentConsultationDialogComponent} from "../create-student-consultation-dialog/create-student-consultation-dialog.component";

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
  consultations;

  constructor(private apiService: ApiService, public viewContainerRef: ViewContainerRef, private dialog: MatDialog) {
  }


  initConsultations() {
    this.apiService.getConsultationSchemes({
      start_date: this.calendarValidStart(),
      end_date: this.calendarValidEnd(),
      teacher_id: 2
    }).subscribe(
      res => {
        this.consultations = res;
        this.prepareEvents();
      }, err => {
        alert('Błąd!');
      }
    )
  }

  openNewEventDialog(event) {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    dialogConfig.data = event;
    this.dialog.open(CreateStudentConsultationDialogComponent, dialogConfig);
  }

  prepareEvents(): void {
    let events = [];
    this.consultations.forEach(function (value: StudentsConsultation) {
      this.push({
        title: value.subject.name,
        start: value.date + 'T' + value.start_time,
        end: value.date + 'T' + value.finish_time
      })
    }, events);
    this.events = events;
  }

  lessonModel: LessonModel = {
    teacher: null,
    subject: null
  };

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
    this.initConsultations();
  }
}

export interface LessonModel {
  teacher: Teacher;
  subject: Subject;
}

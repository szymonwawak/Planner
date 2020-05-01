import {Component, ElementRef, OnInit, ViewChild, ViewContainerRef} from '@angular/core';
import {Subject, Teacher} from "../search-panel/search-panel.component";
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import {CdkOverlayOrigin, ConnectedPositionStrategy, Overlay, OverlayConfig, OverlayRef} from '@angular/cdk/overlay';

@Component({
  selector: 'app-planner-view',
  templateUrl: './planner-view.component.html',
  styleUrls: ['./planner-view.component.css']
})
export class PlannerViewComponent implements OnInit {
  @ViewChild("full-calendar") overlayOrigin: CdkOverlayOrigin;

  calendarPlugins = [timeGridPlugin, interactionPlugin];
  events: [
    {
      title: 'BCH237',
      start: '2020-04-20T10:30:00',
      end: '2020-04-20T11:30:00',
      description: 'Lecture'
    }
  ];

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

  constructor( private overlay: Overlay, public viewContainerRef: ViewContainerRef) {
  }

  ngOnInit(): void {
  }
}

export interface LessonModel {
  teacher: Teacher;
  subject: Subject;
}

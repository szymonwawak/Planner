import {Component, OnInit} from '@angular/core';
import {Subject, Teacher} from "../search-panel/search-panel.component";

@Component({
  selector: 'app-planner-view',
  templateUrl: './planner-view.component.html',
  styleUrls: ['./planner-view.component.css']
})
export class PlannerViewComponent implements OnInit {

  lessonModel: LessonModel = {
    teacher: null,
    subject: null
  };

  constructor() {
  }

  ngOnInit(): void {
  }
}

export interface LessonModel {
  teacher: Teacher;
  subject: Subject;
}

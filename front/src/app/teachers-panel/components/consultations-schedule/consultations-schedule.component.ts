import {Component, OnInit} from '@angular/core';
import {ApiService} from "../../../shared/api.service";
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {Time} from "@angular/common";

@Component({
  selector: 'app-consultations-schedule',
  templateUrl: './consultations-schedule.component.html',
  styleUrls: ['./consultations-schedule.component.css']
})
export class ConsultationsScheduleComponent implements OnInit {

  consultationSchemes: ConsultationScheme[];
  days: Days = new Days;
  constructor(private apiService: ApiService) {
  }

  ngOnInit(): void {
    this.setConsultationSchemes();
  }

  setConsultationSchemes(): void {
    this.apiService.getCurrentUserConsultationSchemes().subscribe(
      res => {
        this.consultationSchemes = res;
      },
      err => {

      }
    )
  }
}

export interface ConsultationScheme {
  id: number;
  subject: Subject;
  day: number;
  end_date: Date;
  finish_time: Time;
  start_date: Date;
  start_time: Time;
  teacher_subject_id: number;
}

export class Days {
  1: string = 'Poniedziałek';
  2: string = 'Wtorek';
  3: string = 'Sroda';
  4: string = 'Czwartek';
  5: string = 'Piątek';
  6: string = 'Sobota';
  7: string = 'Niedziela';
}

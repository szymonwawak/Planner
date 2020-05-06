import {Component, Inject, OnInit} from '@angular/core';
import {StudentsConsultation} from "../incoming-consultations/incoming-consultations.component";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {ApiService} from "../../../shared/api.service";
import {ConsultationScheme} from "../consultations-schedule/consultations-schedule.component";

@Component({
  selector: 'app-add-consultation-scheme-dialog',
  templateUrl: './add-consultation-scheme-dialog.component.html',
  styleUrls: ['./add-consultation-scheme-dialog.component.css']
})
export class AddConsultationSchemeDialogComponent implements OnInit {

  consultationScheme: ConsultationScheme = new ConsultationScheme();
  startTime: Date;
  endTime: Date;

  constructor(public dialogRef: MatDialogRef<AddConsultationSchemeDialogComponent>,
              private apiService: ApiService,
              @Inject(MAT_DIALOG_DATA) public days) {
  }

  ngOnInit(): void {
  }

  close(): void {
    this.dialogRef.close();
  }

  save(): void {
    let scheme: ConsultationScheme = this.consultationScheme
    scheme.start_time = this.startTime.toLocaleTimeString();
    scheme.finish_time = this.endTime.toLocaleTimeString();
    this.apiService.createConsultationScheme(scheme).subscribe(
      res => {
        this.dialogRef.close();
      },
      err => {
        alert(err.error.message)
      }
    )
  }

  checkMinutes(timeFrom: Date): void {
    let minutes: number = timeFrom.getMinutes(),
      incorrectMinutes: number = minutes % 10;
    if (incorrectMinutes != 0) {
      timeFrom.setMinutes(minutes - incorrectMinutes);
      this.startTime = new Date(timeFrom);
    }
    let timeTo = new Date(timeFrom);
    timeTo.setHours(timeFrom.getHours() + 1);
    this.endTime = new Date(timeTo)
  }
}

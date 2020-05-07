import {Component, Inject, OnInit} from '@angular/core';
import {ConsultationScheme} from "../consultations-schedule/consultations-schedule.component";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {ApiService} from "../../../shared/api.service";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-edit-consultation-scheme-dialog',
  templateUrl: './edit-consultation-scheme-dialog.component.html',
  styleUrls: ['./edit-consultation-scheme-dialog.component.css']
})
export class EditConsultationSchemeDialogComponent implements OnInit {

  consultationScheme: ConsultationScheme;
  days;
  startTime: Date;
  endTime: Date;

  constructor(public dialogRef: MatDialogRef<EditConsultationSchemeDialogComponent>,
              private apiService: ApiService,
              private utils: UtilsService,
              @Inject(MAT_DIALOG_DATA) public data) {
  }

  ngOnInit(): void {
    this.consultationScheme = {...this.data[0]};
    this.days = this.data[1];
    this.startTime = new Date(new Date().toDateString() + ' ' + this.consultationScheme.start_time);
    this.endTime = new Date(new Date().toDateString() + ' ' + this.consultationScheme.finish_time);
  }

  save(): void {
    let scheme: ConsultationScheme = this.consultationScheme;
    scheme.start_time = this.startTime.toLocaleTimeString();
    scheme.finish_time = this.endTime.toLocaleTimeString();
    this.apiService.updateConsultationScheme(scheme).subscribe(
      res => {
        this.dialogRef.close();
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
  }

  close(): void {
    this.dialogRef.close();
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

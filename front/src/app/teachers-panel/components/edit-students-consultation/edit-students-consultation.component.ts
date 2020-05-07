import {Component, Inject, Input, OnInit} from '@angular/core';
import {StudentsConsultation} from "../incoming-consultations/incoming-consultations.component";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {ApiService} from "../../../shared/api.service";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-edit-students-consultation',
  templateUrl: './edit-students-consultation.component.html',
  styleUrls: ['./edit-students-consultation.component.css']
})
export class EditStudentsConsultationComponent implements OnInit {

  consultation: StudentsConsultation;
  day: Date;
  startTime: Date;
  endTime: Date;

  constructor(public dialogRef: MatDialogRef<EditStudentsConsultationComponent>,
              private apiService: ApiService,
              private utils: UtilsService,
              @Inject(MAT_DIALOG_DATA) public studentsConsultation: StudentsConsultation) {
  }

  ngOnInit(): void {
    this.day = this.studentsConsultation.date;
    this.startTime = new Date(this.day + ' ' + this.studentsConsultation.start_time);
    this.endTime = new Date(this.day + ' ' + this.studentsConsultation.finish_time);
    this.studentsConsultation.date = new Date(this.day);
  }

  save(): void {
    let consultation: StudentsConsultation = this.studentsConsultation;
    consultation.start_time = this.startTime.toLocaleTimeString();
    consultation.finish_time = this.endTime.toLocaleTimeString();
    consultation.date = this.day;
    this.apiService.updateStudentsConsultations(consultation).subscribe(
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

  checkMinutes(dateTime: Date, field: String): void {
    let minutes: number = dateTime.getMinutes(),
      incorrectMinutes: number = minutes % 10;
    if (incorrectMinutes != 0) {
      dateTime.setMinutes(minutes - incorrectMinutes);
      if (field == 'start')
        this.startTime = new Date(dateTime);
      else if (field == 'end')
        this.endTime = new Date(dateTime);
    }
  }
}

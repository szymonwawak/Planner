import {Component, Inject, OnInit} from '@angular/core';
import {StudentsConsultation} from "../../../teachers-panel/components/incoming-consultations/incoming-consultations.component";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {ApiService} from "../../../shared/api.service";

@Component({
  selector: 'app-create-student-consultation-dialog',
  templateUrl: './create-student-consultation-dialog.component.html',
  styleUrls: ['./create-student-consultation-dialog.component.css']
})
export class CreateStudentConsultationDialogComponent implements OnInit {

  studentsConsultation: StudentsConsultation = new StudentsConsultation();
  startTime: Date;
  endTime: Date;
  date: Date;

  constructor(public dialogRef: MatDialogRef<CreateStudentConsultationDialogComponent>,
              private apiService: ApiService,
              @Inject(MAT_DIALOG_DATA) public event) {
  }

  ngOnInit(): void {
    this.startTime = this.event.start;
    this.endTime = this.event.end;
    this.date = this.event.start;
  }

  close(): void {
    this.dialogRef.close();
  }

  save(): void {
    let consultation: StudentsConsultation = this.studentsConsultation
    consultation.start_time = this.startTime.toLocaleTimeString();
    consultation.finish_time = this.endTime.toLocaleTimeString();
    consultation.date = this.date;
    consultation.teacher_id = 2;
    consultation.subject_id = 2;
    consultation.student_name = 'sdasd';
    consultation.student_surname = 'asdasd';
    consultation.student_email = 'dasd';
    this.apiService.createStudentConsultation(consultation).subscribe(
      res => {
        this.dialogRef.close();
      },
      err => {
        alert(err.error.message)
      }
    )
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

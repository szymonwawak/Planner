import {Component, Inject, Input, OnInit} from '@angular/core';
import {StudentsConsultation} from "../incoming-consultations/incoming-consultations.component";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {TimepickerConfig} from "ngx-bootstrap/timepicker";

@Component({
  selector: 'app-edit-students-consultation',
  templateUrl: './edit-students-consultation.component.html',
  styleUrls: ['./edit-students-consultation.component.css']
})
export class EditStudentsConsultationComponent implements OnInit {

  consultation: StudentsConsultation;

  constructor(public dialogRef: MatDialogRef<EditStudentsConsultationComponent>, @Inject(MAT_DIALOG_DATA) public studentsConsultation: StudentsConsultation) {
  }

  day: Date = this.studentsConsultation.date;
  start_time = this.studentsConsultation.start_time;
  public dayTime = new Date(this.day + ' '  + this.studentsConsultation.start_time);
  ngOnInit(): void {
  }

  close(): void {
    this.dialogRef.close();
  }
}

import {Component, Inject, OnInit} from '@angular/core';
import {StudentsConsultation} from "../../../teachers-panel/components/incoming-consultations/incoming-consultations.component";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {ApiService} from "../../../shared/api.service";
import {UtilsService} from "../../../shared/utils.service";
import {LessonModel} from "../planner-view/planner-view.component";

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
  event;
  lesson: LessonModel;

  constructor(public dialogRef: MatDialogRef<CreateStudentConsultationDialogComponent>,
              private apiService: ApiService,
              private utils: UtilsService,
              @Inject(MAT_DIALOG_DATA) public data) {
  }

  ngOnInit(): void {
    this.event = this.data[0];
    this.lesson = this.data[1];
    this.startTime = this.event.start;
    this.endTime = this.event.end;
    this.date = this.event.start;
  }

  save(): void {
    let consultation: StudentsConsultation = this.studentsConsultation
    consultation.start_time = this.startTime.toLocaleTimeString();
    consultation.finish_time = this.endTime.toLocaleTimeString();
    consultation.date = this.date;
    consultation.teacher_id = this.lesson.teacher.id;
    consultation.subject_id = this.lesson.subject.id;
    this.apiService.createStudentConsultation(consultation).subscribe(
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

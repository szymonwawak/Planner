import {Component, OnInit} from '@angular/core';
import {ApiService} from "../../../shared/api.service";
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {CreateSubjectDialogComponent} from "../create-subject-dialog/create-subject-dialog.component";
import {EditStudentsConsultationComponent} from "../edit-students-consultation/edit-students-consultation.component";

@Component({
  selector: 'app-incoming-consultations',
  templateUrl: './incoming-consultations.component.html',
  styleUrls: ['./incoming-consultations.component.css']
})
export class IncomingConsultationsComponent implements OnInit {

  public studentsConsultations: StudentsConsultation[];
  public studentsConsultation: StudentsConsultation;

  constructor(private apiService: ApiService, private dialog: MatDialog) {
  }

  model: Dates = new Dates();

  ngOnInit(): void {
    this.setConsultations();
  }

  setConsultations(): void {
    let today = new Date();
    let lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    let difference = (lastDay.getTime() - today.getTime());
    difference = difference / (1000 * 3600 * 24);
    if (!(difference > 7)) {
      lastDay.setMonth(lastDay.getMonth() + 1);
      lastDay.setDate(0);
    }

    this.model.start_date = today.toDateString();
    this.model.end_date = lastDay.toDateString();
    this.apiService.getCurrentUserStudentsConsultations(this.model).subscribe(
      res => {
        this.studentsConsultations = res;
      },
      err => {

      }
    )
  }

  acceptConsultation(): void {
    let consultation: StudentsConsultation = this.studentsConsultation[0];
    consultation.accepted = true;
    this.apiService.updateStudentsConsultations(consultation).subscribe(
      res => {
        this.setConsultations();
      },
      err => {
        alert('Wystąpił błąd')
      }
    )
  }

  openEditConsultationDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    dialogConfig.data = this.studentsConsultation[0];
    this.dialog.open(EditStudentsConsultationComponent, dialogConfig);
  }
}

export class Dates {
  start_date: String;
  end_date: String;
}

export interface StudentsConsultation {
  id: number,
  consultation_id: number;
  student_name: string;
  student_surname: string;
  student_email: string;
  date: Date;
  start_time: string;
  finish_time: string;
  accepted: boolean;
  subject: Subject;
}

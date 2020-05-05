import {Component, OnInit} from '@angular/core';
import {ApiService} from "../../../shared/api.service";
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {CreateSubjectDialogComponent} from "../create-subject-dialog/create-subject-dialog.component";
import {EditStudentsConsultationComponent} from "../edit-students-consultation/edit-students-consultation.component";
import {ConsultationScheme} from "../consultations-schedule/consultations-schedule.component";
import {PageEvent} from "@angular/material/paginator";

@Component({
  selector: 'app-incoming-consultations',
  templateUrl: './incoming-consultations.component.html',
  styleUrls: ['./incoming-consultations.component.css']
})
export class IncomingConsultationsComponent implements OnInit {

  public studentsConsultations: StudentsConsultation[];
  public studentsConsultation: StudentsConsultation;
  paginatedStudentConsultations: StudentsConsultation[];
  pageSize: number = 10;
  length: number;

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
        this.paginatedStudentConsultations = this.studentsConsultations.slice(0, this.pageSize)
        this.length = this.studentsConsultations.length;
      },
      err => {
        alert(err.error.message);
      }
    )
  }

  setConsultation(consultation: StudentsConsultation) {
    this.studentsConsultation = consultation;
  }

  acceptConsultation(): void {
    let consultation: StudentsConsultation = this.studentsConsultation;
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
    dialogConfig.data = this.studentsConsultation;
    this.dialog.open(EditStudentsConsultationComponent, dialogConfig);
  }

  changePage(event: PageEvent): void {
    let offset = event.pageSize * event.pageIndex;
    this.paginatedStudentConsultations = this.studentsConsultations.slice(offset, offset + this.pageSize);
  }
}

export class Dates {
  start_date: String;
  end_date: String;
}

export class StudentsConsultation {
  id: number;
  student_name: string;
  student_surname: string;
  student_email: string;
  date: Date;
  start_time: string;
  finish_time: string;
  accepted: boolean;
  subject: Subject;
}

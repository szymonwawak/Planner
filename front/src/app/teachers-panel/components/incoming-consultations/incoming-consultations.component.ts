import {Component, OnInit} from '@angular/core';
import {ApiService} from "../../../shared/api.service";
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {EditStudentsConsultationComponent} from "../edit-students-consultation/edit-students-consultation.component";
import {PageEvent} from "@angular/material/paginator";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-incoming-consultations',
  templateUrl: './incoming-consultations.component.html',
  styleUrls: ['./incoming-consultations.component.css']
})
export class IncomingConsultationsComponent implements OnInit {

  public studentsConsultations: StudentsConsultation[];
  public studentsConsultation: StudentsConsultation;
  paginatedStudentConsultations: StudentsConsultation[];
  consultationDateRange: DateRange = new DateRange();
  pageSize: number = 8;
  length: number;

  constructor(private apiService: ApiService, private dialog: MatDialog, private utils: UtilsService) {
  }

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
    this.consultationDateRange.start_date = today.toDateString();
    this.consultationDateRange.end_date = lastDay.toDateString();
    this.apiService.getCurrentUserStudentsConsultations(this.consultationDateRange).subscribe(
      res => {
        this.studentsConsultations = res;
        this.paginatedStudentConsultations = this.studentsConsultations.slice(0, this.pageSize)
        this.length = this.studentsConsultations.length;
      },
      err => {
        this.utils.openSnackBar(err.error.message);
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
        this.utils.openSnackBar(err.error.message);
      }
    )
  }

  openEditConsultationDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    dialogConfig.data = this.studentsConsultation;
    this.dialog.open(EditStudentsConsultationComponent, dialogConfig).afterClosed().subscribe(
      () => this.ngOnInit()
    );
  }

  changePage(event: PageEvent): void {
    let offset = event.pageSize * event.pageIndex;
    this.paginatedStudentConsultations = this.studentsConsultations.slice(offset, offset + this.pageSize);
  }
}

export class DateRange {
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
  teacher_id: string;
  subject_id: string;
}

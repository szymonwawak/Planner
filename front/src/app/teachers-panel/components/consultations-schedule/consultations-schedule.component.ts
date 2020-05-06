import {Component, OnInit} from '@angular/core';
import {ApiService} from "../../../shared/api.service";
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {AddConsultationSchemeDialogComponent} from "../add-consultation-scheme-dialog/add-consultation-scheme-dialog.component";
import {EditConsultationSchemeDialogComponent} from "../edit-consultation-scheme-dialog/edit-consultation-scheme-dialog.component";
import {PageEvent} from "@angular/material/paginator";

@Component({
  selector: 'app-consultations-schedule',
  templateUrl: './consultations-schedule.component.html',
  styleUrls: ['./consultations-schedule.component.css']
})
export class ConsultationsScheduleComponent implements OnInit {

  consultationSchemes: ConsultationScheme[];
  consultationScheme: ConsultationScheme;
  paginatedSchemes: ConsultationScheme[];
  pageSize: number = 2;
  length: number;
  days = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela'];

  constructor(private apiService: ApiService, private dialog: MatDialog) {
  }


  ngOnInit(): void {
    this.setConsultationSchemes();
  }

  setConsultationScheme(consultationScheme: ConsultationScheme): void {
    this.consultationScheme = consultationScheme;
  }

  setConsultationSchemes(): void {
    this.apiService.getCurrentUserConsultationSchemes().subscribe(
      res => {
        this.consultationSchemes = res;
        this.paginatedSchemes = this.consultationSchemes.slice(0, this.pageSize)
        this.length = this.consultationSchemes.length;
      },
      err => {
        alert(err.error.message);
      }
    )
  }

  openAddConsultationSchemeDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    dialogConfig.data = this.days;
    this.dialog.open(AddConsultationSchemeDialogComponent, dialogConfig);
  }

  openEditConsultationSchemeDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    dialogConfig.data = [this.consultationScheme, this.days];
    this.dialog.open(EditConsultationSchemeDialogComponent, dialogConfig).afterClosed().subscribe(
      () => this.ngOnInit()
    );
  }

  deleteScheme(): void {
    this.apiService.deleteConsultationScheme(this.consultationScheme.id).subscribe(
      res => {
        this.ngOnInit();
      },
      err => {
        alert(err.error.message);
      }
    );
  }

  changePage(event: PageEvent): void {
    let offset = event.pageSize * event.pageIndex;
    this.paginatedSchemes = this.consultationSchemes.slice(offset, offset + this.pageSize);
  }
}

export class ConsultationScheme {
  id: number;
  subject: Subject;
  day: number;
  end_date: Date;
  finish_time: string;
  start_date: Date;
  start_time: string;
  teacher_id: number;
}

import {Component, OnInit} from '@angular/core';
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {AssignSubjectsDialogComponent} from "../assign-subjects-dialog/assign-subjects-dialog.component";
import {Subject, Teacher} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {CreateSubjectDialogComponent} from "../create-subject-dialog/create-subject-dialog.component";

@Component({
  selector: 'app-subjects-card',
  templateUrl: './subjects-card.component.html',
  styleUrls: ['./subjects-card.component.css']
})
export class SubjectsCardComponent implements OnInit {

  public userSubjects: Subject[];
  public selectedSubject: Subject;

  constructor(private dialog: MatDialog, private apiService: ApiService) {
  }

  ngOnInit(): void {
    this.apiService.getCurrentUserSubjects().subscribe(
      res => {
        this.userSubjects = res;
      },
      err => {
        alert("Wystąpił błąd");
      }
    )
  }

  setSubject(subject: Subject) {
    this.selectedSubject = subject;
  }

  deleteSubject(): void {
    this.apiService.deleteTeacherSubject(this.selectedSubject.pivot.id).subscribe(
      res => {
        this.ngOnInit();
      },
      err => {
        alert("Wystąpił błąd");
      }
    );
    this.ngOnInit();
  }

  openSubjectsDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    dialogConfig.data = this.userSubjects
    this.dialog.open(AssignSubjectsDialogComponent, dialogConfig).afterClosed().subscribe(
      () => this.ngOnInit()
    )
  }

  openNewSubjectDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    this.dialog.open(CreateSubjectDialogComponent, dialogConfig);
  }
}

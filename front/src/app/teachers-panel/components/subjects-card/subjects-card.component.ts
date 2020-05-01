import {Component, OnInit} from '@angular/core';
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {AssignSubjectsDialogComponent} from "../assign-subjects-dialog/assign-subjects-dialog.component";
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {CreateSubjectDialogComponent} from "../create-subject-dialog/create-subject-dialog.component";

@Component({
  selector: 'app-subjects-card',
  templateUrl: './subjects-card.component.html',
  styleUrls: ['./subjects-card.component.css']
})
export class SubjectsCardComponent implements OnInit {

  public subjects: Subject[];
  public selectedSubject: Subject;

  constructor(private dialog: MatDialog, private apiService: ApiService) {
  }

  ngOnInit(): void {
    this.initElement()
  }

  openSubjectsDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    this.dialog.open(AssignSubjectsDialogComponent, dialogConfig).afterClosed().subscribe(
      () => this.initElement()
    )
  }

  openNewSubjectDialog(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '450px';
    this.dialog.open(CreateSubjectDialogComponent, dialogConfig);
  }

  initElement(): void {
    this.apiService.getCurrentUserSubjects().subscribe(
      res => {
        this.subjects = res;
      },
      err => {
        alert("Wystąpił błąd");
      }
    )
  }

  removeSubject(): void {
    this.apiService.deleteTeacherSubject(this.selectedSubject[0].pivot.id).subscribe(
      res => {
        this.subjects = this.subjects.filter(obj => obj != this.selectedSubject);
        this.selectedSubject = null;
        this.initElement();
      },
      err => {
        alert("Wystąpił błąd");
      }
    );
    this.initElement();
  }
}

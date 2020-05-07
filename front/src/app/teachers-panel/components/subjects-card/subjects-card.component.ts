import {Component, OnInit} from '@angular/core';
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {AssignSubjectsDialogComponent} from "../assign-subjects-dialog/assign-subjects-dialog.component";
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {CreateSubjectDialogComponent} from "../create-subject-dialog/create-subject-dialog.component";
import {PageEvent} from "@angular/material/paginator";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-subjects-card',
  templateUrl: './subjects-card.component.html',
  styleUrls: ['./subjects-card.component.css']
})
export class SubjectsCardComponent implements OnInit {

  public userSubjects: Subject[];
  public selectedSubject: Subject;
  paginatedUserSubjects: Subject[];
  pageSize: number = 3;
  length: number;

  constructor(private dialog: MatDialog, private apiService: ApiService, private utils: UtilsService) {
  }

  ngOnInit(): void {
    this.apiService.getCurrentUserSubjects().subscribe(
      res => {
        this.userSubjects = res;
        this.paginatedUserSubjects = this.userSubjects.slice(0, this.pageSize)
        this.length = this.userSubjects.length;
      },
      err => {
        this.utils.openSnackBar(err.error.message);
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
        this.utils.openSnackBar(err.error.message);
      }
    );
  }

  openJoinToSubjectDialog(): void {
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

  changePage(event: PageEvent): void {
    let offset = event.pageSize * event.pageIndex;
    this.paginatedUserSubjects = this.userSubjects.slice(offset, offset + this.pageSize);
  }
}

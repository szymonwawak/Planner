import {Component, Inject, OnInit} from '@angular/core';
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";

@Component({
  selector: 'app-assign-subjects-dialog',
  templateUrl: './assign-subjects-dialog.component.html',
  styleUrls: ['./assign-subjects-dialog.component.css']
})
export class AssignSubjectsDialogComponent implements OnInit {

  subjects: Subject[];
  subject: Subject;

  constructor(private apiService: ApiService,
              public dialogRef: MatDialogRef<AssignSubjectsDialogComponent>,
              @Inject(MAT_DIALOG_DATA) private userSubjects: Subject[]) {
  }

  ngOnInit(): void {
    this.apiService.getAllSubjects().subscribe(
      res => {
        this.subjects = res;
        this.subjects = this.subjects.filter((el) => !this.userSubjects.find(({id}) => el.id == id));
      },
      err => {
        alert("Wystąpił błąd");
      }
    );
  }

  close() {
    this.dialogRef.close();
  }

  save() {
    this.apiService.addSubjectToCurrentlyLoggedTeacher({'subject_id': this.subject.id}).subscribe(
      res => {
        this.dialogRef.close();
      },
      err => {
        alert("Wystąpił błąd");
      }
    )
  }
}

import {Component, OnInit} from '@angular/core';
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {MatDialogRef} from "@angular/material/dialog";

@Component({
  selector: 'app-create-subject-dialog',
  templateUrl: './create-subject-dialog.component.html',
  styleUrls: ['./create-subject-dialog.component.css']
})
export class CreateSubjectDialogComponent implements OnInit {

  subject: Subject = new Subject();

  constructor(private apiService: ApiService, public dialogRef: MatDialogRef<CreateSubjectDialogComponent>) {
  }

  ngOnInit(): void {
  }

  close() {
    this.dialogRef.close();
  }

  save() {
    this.apiService.createSubject(this.subject).subscribe(
      res => {
        this.dialogRef.close();
      },
      err => {
        alert("Wystąpił błąd");
      }
    )
  }

}

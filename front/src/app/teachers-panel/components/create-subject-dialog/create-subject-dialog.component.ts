import {Component, OnInit} from '@angular/core';
import {Subject} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {MatDialogRef} from "@angular/material/dialog";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-create-subject-dialog',
  templateUrl: './create-subject-dialog.component.html',
  styleUrls: ['./create-subject-dialog.component.css']
})
export class CreateSubjectDialogComponent implements OnInit {

  subject: Subject = new Subject();

  constructor(private apiService: ApiService, public dialogRef: MatDialogRef<CreateSubjectDialogComponent>,
              private utils: UtilsService) {
  }

  ngOnInit(): void {
  }

  save() {
    this.apiService.createSubject(this.subject).subscribe(
      res => {
        this.dialogRef.close();
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
  }

  close() {
    this.dialogRef.close();
  }
}

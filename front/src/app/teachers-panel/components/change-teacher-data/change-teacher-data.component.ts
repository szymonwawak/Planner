import {Component, OnInit} from '@angular/core';
import {Teacher} from "../../../students-panel/components/search-panel/search-panel.component";
import {ApiService} from "../../../shared/api.service";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-change-teacher-data',
  templateUrl: './change-teacher-data.component.html',
  styleUrls: ['./change-teacher-data.component.css']
})
export class ChangeTeacherDataComponent implements OnInit {

  teacher: Teacher;

  constructor(private apiService: ApiService, private utils: UtilsService) {
  }

  ngOnInit(): void {
    this.teacher = new Teacher();
    this.loadUser();
  }

  loadUser(): void {
    this.apiService.getCurrentUserData().subscribe(
      res => {
        this.teacher = res;
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
  }

  saveTeacherData(): void {
    this.apiService.updateTeacher(this.teacher).subscribe(
      res => {
        this.utils.openSnackBar(res.message);
      },
      err => {
        this.utils.openSnackBar(err.error.message);
      }
    )
  }
}

import {Component, OnInit} from '@angular/core';
import {ApiService} from "../../../shared/api.service";
import {Router} from "@angular/router";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-delete-account',
  templateUrl: './delete-account.component.html',
  styleUrls: ['./delete-account.component.css']
})
export class DeleteAccountComponent implements OnInit {

  confirmed: boolean;

  constructor(private apiService: ApiService, private router: Router, private utils: UtilsService) {
  }

  ngOnInit(): void {
  }

  deleteAccount(): void {
    this.apiService.deleteAccount().subscribe(
      res => {
        localStorage.removeItem('token');
        this.router.navigate(['/']);
      },
      err => {
        let error = err.error;
        this.utils.openSnackBar(err.error.message);
      }
    )
  }
}

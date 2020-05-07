import {Component, OnInit} from '@angular/core';
import {AuthService} from "../../auth.service";
import {Router} from "@angular/router";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  model: LoginViewModel = {
    email: '',
    password: ''
  };

  constructor(private authService: AuthService, private router: Router, private utils: UtilsService) {
  }

  ngOnInit(): void {
  }

  login(): void {
    this.authService.login(this.model).subscribe(
      res => {
        let token: any = res.token;
        if (token) {
          localStorage.setItem('token', token)
          this.router.navigate(['/panel/dashboard'])
        }
      },
      err => this.utils.openSnackBar(err.error.message)
    )
  }
}

export interface LoginViewModel {
  email: string;
  password: string;
}

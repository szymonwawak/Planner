import {Component, OnInit} from '@angular/core';
import {AuthService} from "../../auth.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  model: LoginViewModel = {
    mail: '',
    password: ''
  };

  constructor(private authService: AuthService, private router: Router) {
  }

  ngOnInit(): void {
  }

  login(): void {
    this.authService.login(this.model).subscribe(
      res => {
        let token: any = res.token;
        if (token) {
          localStorage.setItem('token', token)
          this.router.navigate(['/calendar'])
        }
      },
      err => alert('Wprowadzono błędne dane!')
    )
  }
}

export interface LoginViewModel {
  mail: string;
  password: string;
}

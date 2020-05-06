import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {JwtHelperService} from "@auth0/angular-jwt";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loginUrl = "http://localhost:8888/auth/login"

  constructor(private http: HttpClient, public jwtHelper: JwtHelperService) {
  }

  login(user) {
    return this.http.post<any>(this.loginUrl, user);
  }

  public isAuthenticated(): boolean {
    const token = localStorage.getItem('token');
    return !this.jwtHelper.isTokenExpired(token);
  }
}

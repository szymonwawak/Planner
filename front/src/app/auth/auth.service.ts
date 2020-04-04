import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loginUrl = "http://localhost:8888/login"

  constructor(private http: HttpClient) {
  }

  login(user) {
    return this.http.post<any>(this.loginUrl, user);
  }
}

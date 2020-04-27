import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Subject, Teacher} from "../students-panel/components/search-panel/search-panel.component";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private BASE_URL = 'http://localhost:8888/api';
  private TEACHERS_URL = this.BASE_URL + '/teachers';
  private SUBJECTS_URL = this.BASE_URL + '/subjects';

  constructor(private http: HttpClient) {
  }

  getAllTeachers(): Observable<Teacher[]> {
    return this.http.get<Teacher[]>(this.TEACHERS_URL);
  }

  getAllSubjects(): Observable<Subject[]> {
    return this.http.get<Subject[]>(this.SUBJECTS_URL);
  }

  createTeacher(teacher: Teacher): Observable<any> {
    return this.http.post<any>(this.TEACHERS_URL, teacher);
  }
}

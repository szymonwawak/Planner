import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Subject, Teacher} from "../students-panel/components/search-panel/search-panel.component";
import {PasswordChangeModel} from "../teachers-panel/components/password-change/password-change.component";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private BASE_URL = 'http://localhost:8888/api';
  private TEACHERS_URL = this.BASE_URL + '/teachers';
  private SUBJECTS_URL = this.BASE_URL + '/subjects';
  private TEACHER_SUBJECTS_URL = this.BASE_URL + '/teacher-subjects';

  constructor(private http: HttpClient) {
  }

  getAllTeachers(): Observable<Teacher[]> {
    return this.http.get<Teacher[]>(this.TEACHERS_URL);
  }

  getAllSubjects(): Observable<Subject[]> {
    return this.http.get<Subject[]>(this.SUBJECTS_URL);
  }

  createSubject(subject: Subject): Observable<Subject[]> {
    return this.http.post<any>(this.SUBJECTS_URL, subject);
  }

  deleteCurrentlyLoggedTeacherSubject(subject: Subject): Observable<any> {
    return this.http.delete(this.SUBJECTS_URL + '/subject/' + subject.id)
  }

  createTeacher(teacher: Teacher): Observable<any> {
    return this.http.post<any>(this.TEACHERS_URL, teacher);
  }

  addSubjectToCurrentlyLoggedTeacher(data): Observable<any> {
    return this.http.post<any>(this.TEACHER_SUBJECTS_URL, data);
  }

  deleteAccount(): Observable<any> {
    return this.http.delete<any>(this.TEACHERS_URL + '/account')
  }

  changePassword(passwordChangeModel: PasswordChangeModel): Observable<any> {
    return this.http.post<any>(this.TEACHERS_URL + '/password', passwordChangeModel)
  }
}

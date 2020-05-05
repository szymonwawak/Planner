import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {PanelViewComponent} from './components/panel-view/panel-view.component';
import {MatToolbarModule} from "@angular/material/toolbar";
import {MatButtonModule} from "@angular/material/button";
import {RouterModule, Routes} from "@angular/router";
import {RoleSelectorComponent} from "../components/role-selector/role-selector.component";
import {MatSidenavModule} from "@angular/material/sidenav";
import {MatListModule} from "@angular/material/list";
import {MatIconModule} from "@angular/material/icon";
import {FontAwesomeModule} from "@fortawesome/angular-fontawesome";
import {IncomingConsultationsComponent} from './components/incoming-consultations/incoming-consultations.component';
import {MatCardModule} from "@angular/material/card";
import {SubjectsCardComponent} from './components/subjects-card/subjects-card.component';
import {ConsultationsScheduleComponent} from './components/consultations-schedule/consultations-schedule.component';
import {DashboardComponent} from './components/dashboard/dashboard.component';
import {EmployeesComponent} from './components/employees/employees.component';
import {MatInputModule} from "@angular/material/input";
import {MatNativeDateModule, MatOptionModule} from "@angular/material/core";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {MatDialogModule} from "@angular/material/dialog";
import {AssignSubjectsDialogComponent} from './components/assign-subjects-dialog/assign-subjects-dialog.component';
import {MatSelectModule} from "@angular/material/select";
import { CreateSubjectDialogComponent } from './components/create-subject-dialog/create-subject-dialog.component';
import { SettingsComponent } from './components/settings/settings.component';
import { PasswordChangeComponent } from './components/password-change/password-change.component';
import { DeleteAccountComponent } from './components/delete-account/delete-account.component';
import {MatCheckboxModule} from "@angular/material/checkbox";
import { EditStudentsConsultationComponent } from './components/edit-students-consultation/edit-students-consultation.component';
import {TimepickerModule} from "ngx-bootstrap/timepicker";
import {MatDatepickerModule} from "@angular/material/datepicker";
import { ChangeTeacherDataComponent } from './components/change-teacher-data/change-teacher-data.component';
import {StudentsPanelModule} from "../students-panel/students-panel.module";

const appRoutes: Routes = [
  {
    path: 'logout', component: RoleSelectorComponent,
  },
];

@NgModule({
  declarations: [PanelViewComponent, IncomingConsultationsComponent, SubjectsCardComponent, ConsultationsScheduleComponent, DashboardComponent, EmployeesComponent, AssignSubjectsDialogComponent, CreateSubjectDialogComponent, SettingsComponent, PasswordChangeComponent, DeleteAccountComponent, EditStudentsConsultationComponent, ChangeTeacherDataComponent],
  imports: [
    CommonModule,
    MatToolbarModule,
    MatButtonModule,
    RouterModule.forRoot(appRoutes),
    MatSidenavModule,
    MatListModule,
    MatIconModule,
    FontAwesomeModule,
    MatCardModule,
    MatInputModule,
    MatOptionModule,
    FormsModule,
    MatDialogModule,
    MatSelectModule,
    MatCheckboxModule,
    TimepickerModule.forRoot(),
    MatDatepickerModule,
    MatNativeDateModule,
    ReactiveFormsModule,
    StudentsPanelModule
  ]
})

export class TeachersPanelModule {
}

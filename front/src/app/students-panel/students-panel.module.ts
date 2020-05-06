import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {RouterModule, Routes} from "@angular/router";
import {LoginComponent} from "../auth/components/login/login.component";
import {MatButtonModule} from "@angular/material/button";
import {PlannerViewComponent} from './components/planner-view/planner-view.component';
import {MatToolbarModule} from "@angular/material/toolbar";
import {SearchPanelComponent} from './components/search-panel/search-panel.component';
import {MatCardModule} from "@angular/material/card";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatInputModule} from "@angular/material/input";
import {MatSelectModule} from "@angular/material/select";
import {FormsModule} from "@angular/forms";
import {TeacherSearchPipe} from './components/search-panel/teacher-search.pipe';
import {FullCalendarModule} from "@fullcalendar/angular";
import {OverlayModule} from '@angular/cdk/overlay';
import { CreateStudentConsultationDialogComponent } from './components/create-student-consultation-dialog/create-student-consultation-dialog.component';
import {MatDialogModule} from "@angular/material/dialog";
import {MatDatepickerModule} from "@angular/material/datepicker";
import {TimepickerModule} from "ngx-bootstrap/timepicker";
import {MatIconModule} from "@angular/material/icon";

const appRoutes: Routes = [
  {path: 'login', component: LoginComponent},
];

@NgModule({
    declarations: [PlannerViewComponent, SearchPanelComponent, TeacherSearchPipe, CreateStudentConsultationDialogComponent],
    exports: [
        SearchPanelComponent
    ],
  imports: [
    CommonModule,
    MatButtonModule,
    RouterModule.forRoot(appRoutes),
    MatToolbarModule,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    FormsModule,
    FullCalendarModule,
    OverlayModule,
    MatDialogModule,
    MatDatepickerModule,
    TimepickerModule,
    MatIconModule
  ]
})
export class StudentsPanelModule {
}

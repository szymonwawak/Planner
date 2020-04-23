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
import { IncomingConsultationsComponent } from './components/incoming-consultations/incoming-consultations.component';
import {MatCardModule} from "@angular/material/card";
import { SubjectsCardComponent } from './components/subjects-card/subjects-card.component';
import { ConsultationsScheduleComponent } from './components/consultations-schedule/consultations-schedule.component';

const appRoutes: Routes = [
  {path: 'logout', component: RoleSelectorComponent},
];

@NgModule({
  declarations: [PanelViewComponent, IncomingConsultationsComponent, SubjectsCardComponent, ConsultationsScheduleComponent],
  imports: [
    CommonModule,
    MatToolbarModule,
    MatButtonModule,
    RouterModule.forRoot(appRoutes),
    MatSidenavModule,
    MatListModule,
    MatIconModule,
    FontAwesomeModule,
    MatCardModule
  ]
})
export class TeachersPanelModule {
}

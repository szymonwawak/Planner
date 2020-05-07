import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {RoleSelectorComponent} from './components/role-selector/role-selector.component';
import {RouterModule, Routes} from '@angular/router';
import {MatGridListModule} from '@angular/material/grid-list';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {MatButtonModule} from "@angular/material/button";
import {AuthModule} from "./auth/auth.module";
import {PlannerViewComponent} from "./students-panel/components/planner-view/planner-view.component";
import {StudentsPanelModule} from "./students-panel/students-panel.module";
import {FullCalendarModule} from '@fullcalendar/angular';
import {PanelViewComponent} from "./teachers-panel/components/panel-view/panel-view.component";
import {TeachersPanelModule} from "./teachers-panel/teachers-panel.module";
import {DashboardComponent} from "./teachers-panel/components/dashboard/dashboard.component";
import {EmployeesComponent} from "./teachers-panel/components/employees/employees.component";
import {SettingsComponent} from "./teachers-panel/components/settings/settings.component";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {JWTInterceptor} from "./shared/jwt.interceptor";
import {AuthGuardService} from "./shared/auth-guard.service";
import {AuthService} from "./auth/auth.service";
import {JwtModule} from "@auth0/angular-jwt";
import {MatSnackBarModule} from "@angular/material/snack-bar";

const appRoutes: Routes = [
  {path: 'planner', component: PlannerViewComponent},
  {
    path: 'panel', component: PanelViewComponent, canActivate: [AuthGuardService], children: [
      {path: "", redirectTo: "dashboard", pathMatch: "full"},
      {path: "dashboard", component: DashboardComponent},
      {path: "employees", component: EmployeesComponent},
      {path: "settings", component: SettingsComponent},
    ]
  },
  {path: '', component: RoleSelectorComponent, pathMatch: 'full'}
]

@NgModule({
  declarations: [
    AppComponent,
    RoleSelectorComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    AuthModule,
    RouterModule.forRoot(appRoutes),
    BrowserAnimationsModule,
    MatGridListModule,
    MatButtonModule,
    StudentsPanelModule,
    TeachersPanelModule,
    MatSnackBarModule,
    FullCalendarModule,
    JwtModule.forRoot({
      config: {
        tokenGetter: function tokenGetter() {
          return localStorage.getItem('token');
        }
      }
    })
  ],
  providers: [
    {provide: HTTP_INTERCEPTORS, useClass: JWTInterceptor, multi: true},
    AuthGuardService, AuthService
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}

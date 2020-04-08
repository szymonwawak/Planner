import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {RoleSelectorComponent} from './components/role-selector/role-selector.component';
import {RouterModule, Routes} from '@angular/router';
import {CalendarComponent} from './components/calendar/calendar.component';
import {MatGridListModule} from '@angular/material/grid-list';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {MatButtonModule} from "@angular/material/button";
import {AuthModule} from "./auth/auth.module";

const appRoutes: Routes = [
  {path: 'calendar', component: CalendarComponent},
  {path: '', component: RoleSelectorComponent, pathMatch: 'full'}
]

@NgModule({
  declarations: [
    AppComponent,
    RoleSelectorComponent,
    CalendarComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    AuthModule,
    RouterModule.forRoot(appRoutes),
    BrowserAnimationsModule,
    MatGridListModule,
    MatButtonModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}

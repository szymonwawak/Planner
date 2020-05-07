import {Component, OnInit} from '@angular/core';
import {AuthService} from "../../../auth/auth.service";

@Component({
  selector: 'app-panel-view',
  templateUrl: './panel-view.component.html',
  styleUrls: ['./panel-view.component.css']
})
export class PanelViewComponent implements OnInit {

  constructor(public authService: AuthService) {
  }

  ngOnInit(): void {
  }

}

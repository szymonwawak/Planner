import {Component, OnInit} from '@angular/core';
import {ApiService} from "../../../shared/api.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {UtilsService} from "../../../shared/utils.service";

@Component({
  selector: 'app-password-change',
  templateUrl: './password-change.component.html',
  styleUrls: ['./password-change.component.css']
})
export class PasswordChangeComponent implements OnInit {

  passwordChangeForm: FormGroup;
  passwordChangeModel: PasswordChangeModel;

  constructor(private apiService: ApiService, private formBuilder: FormBuilder, private utils: UtilsService) {
  }

  ngOnInit(): void {
    this.passwordChangeModel = new PasswordChangeModel();
    this.passwordChangeForm = this.formBuilder.group({
      'oldPassword': [this.passwordChangeModel.oldPassword, Validators.required],
      'newPassword': [this.passwordChangeModel.newPassword, Validators.required],
      'passwordConfirmation': [this.passwordChangeModel.passwordConfirmation, Validators.required],
    }, {
      validator: MustMatch('newPassword', 'passwordConfirmation')
    });
  }

  get oldPassword() {
    return this.passwordChangeForm.get('oldPassword');
  }

  get newPassword() {
    return this.passwordChangeForm.get('newPassword');
  }

  get passwordConfirmation() {
    return this.passwordChangeForm.get('passwordConfirmation');
  }

  changePassword(): void {
    if (this.passwordChangeForm.invalid)
      return;
    this.passwordChangeModel = this.passwordChangeForm.value;
    this.apiService.changePassword(this.passwordChangeModel).subscribe(
      res => {
        this.utils.openSnackBar(res.message);
        this.ngOnInit();
      },
      err => {
        this.utils.openSnackBar(err.error.message);
        this.ngOnInit();
      })
  }
}

export class PasswordChangeModel {
  oldPassword: string;
  newPassword: string;
  passwordConfirmation: string;
}

export function MustMatch(newPassword: string, passwordConfirmation: string) {
  return (formGroup: FormGroup) => {
    const control = formGroup.controls[newPassword];
    const matchingControl = formGroup.controls[passwordConfirmation];
    if (matchingControl.errors && !matchingControl.errors.mustMatch) {
      return;
    }
    if (control.value !== matchingControl.value) {
      matchingControl.setErrors({mustMatch: true});
    } else {
      matchingControl.setErrors(null)
    }
  }
}

import { HttpErrorResponse } from '@angular/common/http';
import { Component,  OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Observable, catchError, of, tap } from 'rxjs';
import { Password } from 'src/app/models/Password';
import { User } from 'src/app/models/User';
import { UserService } from 'src/app/services/user.service';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { AsyncPipe } from '@angular/common';
import { MessageComponent } from '../shared/message/message.component';
import { SpinnerComponent } from '../shared/spinner/spinner.component';
import { LayoutComponent } from '../shared/layout/layout.component';

declare var window: any;
@Component({
    selector: 'app-profile',
    templateUrl: './profile.component.html',
    styleUrls: ['./profile.component.css'],
    standalone: true,
    imports: [LayoutComponent, SpinnerComponent, MessageComponent, ReactiveFormsModule, MessagesValidatorsComponent, AsyncPipe]
})
export class ProfileComponent implements OnInit{
  profile: User;
  user: User| null = null;
  formChangePassword: FormGroup;
  backendErrors: string[] = [];
  modal: any;
  showPassword = false;
  get loading(): boolean {
    return this.userService.getLoading()();
  }

  get message(): string{
    return this.userService.getMessage()();
  }
  constructor(private userService: UserService, private formBuilder: FormBuilder){ }
  ngOnInit(): void {
    this.showProfile();
    this.initializeFormChangePassword();
    this.modal = new window.bootstrap.Modal(
      document.getElementById("changePassword")
    );
  }

  toggleShowPassword() {
    this.showPassword = !this.showPassword;
  }

  showProfile(){
    this.userService.profile()
    .pipe( tap((response: User) => { this.profile = response; }))
    .subscribe();
    this.user = this.userService.getUser()();
  }

  initializeFormChangePassword(){
    this.formChangePassword = this.formBuilder.group({
      current_password: [''],
      password:[''],
      password_confirmation:['']
    });
  }

  changePassword(){
    const form = this.formChangePassword.getRawValue() as Password;
    const handleSuccess = () =>  {
      this.formChangePassword.reset(); 
      this.backendErrors = [];
      this.showProfile();
      this.closeModalChangePassword();
    };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    this.userService.changePasword(form)
    .pipe(
      tap(handleSuccess), catchError(handleErrors)
    ).subscribe();
  }

  openModalChangePassword(){
    this.modal.show();
  }

  closeModalChangePassword() {
    this.modal.hide();
  }
}

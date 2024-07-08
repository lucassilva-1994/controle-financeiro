import { HttpErrorResponse } from '@angular/common/http';
import { Component,  OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Observable, catchError, of, tap } from 'rxjs';
import { Password } from 'src/app/models/Password';
import { User } from 'src/app/models/User';
import { UserService } from 'src/app/services/user.service';

declare var window: any;

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit{
  profile: User;
  user$: Observable<User | null>;
  loading: boolean;
  message: string;
  formChangePassword: FormGroup;
  backendErrors: string[] = [];
  modal: any;
  constructor(private userService: UserService, private formBuilder: FormBuilder){ }
  ngOnInit(): void {
    this.userService.loading$.subscribe(loading => {
      this.loading = loading;
    });
    this.userService.message$.subscribe(message => {
      this.message = message;
    });
    this.showProfile();
    this.initializeFormChangePassword();
    this.modal = new window.bootstrap.Modal(
      document.getElementById("changePassword")
    );
  }

  showProfile(){
    this.userService.profile()
    .pipe( tap((response: User) => { this.profile = response; }))
    .subscribe();
    this.user$ = this.userService.getUser();
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

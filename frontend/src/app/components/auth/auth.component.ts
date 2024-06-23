import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { catchError, tap } from 'rxjs';
import { User } from 'src/app/models/User';
import { TokenService } from 'src/app/services/token.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css']
})
export class AuthComponent implements OnInit {
  formSignIn: FormGroup;
  formSignUp: FormGroup;
  formForgotPassword: FormGroup;
  authMode: string;
  messageSuccess: string;
  backendErrors: string[] = [];
  constructor(
    private router: ActivatedRoute,
    private formBuilder: FormBuilder,
    private userService: UserService,
    private tokenService: TokenService,
    private route: Router
  ) { }
  ngOnInit(): void {
    this.formSignIn = this.formBuilder.group({
      login: ['', [Validators.required]],
      password: ['', [Validators.required]]
    });
    this.formSignUp = this.formBuilder.group({
      name: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(100)]],
      email: ['', [Validators.required, Validators.minLength(10), Validators.maxLength(100), Validators.email]],
      username: ['', [Validators.minLength(5), Validators.maxLength(40)]],
      password: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(20)]],
      password_confirmation: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(20)]],
    });
    this.formForgotPassword = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]]
    })
    this.authMode = this.router.snapshot.data['authMode'];
  }

  signIn(){
    this.userService.signIn(this.formSignIn.get('login')?.value, this.formSignIn.get('password')?.value)
      .pipe(
        tap(response => {
          this.tokenService.setToken(response.toString());
          this.route.navigate(['/financial-records']);
        }),
        catchError(error => {
          return this.backendErrors = error.error;
        })
      )
      .subscribe();
  }

  signUp(): void {
    this.userService.signUp(this.formSignUp.getRawValue() as User)
      .pipe(
        tap(response => {
          this.messageSuccess = response.message;
          this.formSignUp.reset();
          this.backendErrors = [];
        }),
        catchError(error => {
            return this.backendErrors = Object.values(error.error.errors);
        })
      )
      .subscribe();
  }

  forgotPassword() {

  }
}

import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { catchError, of, tap } from 'rxjs';
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
  email: string;
  token: string;
  errorOccurred: boolean;
  loading: boolean = false;
  message: string;
  titleCard: string;
  backendErrors: string[] = [];
  showPassword = false;
  constructor(
    private router: ActivatedRoute,
    private formBuilder: FormBuilder,
    private userService: UserService,
    private route: Router
  ) { }
  ngOnInit(): void {
    this.userService.message$.subscribe(message => {
      this.message = message
    });
    this.initializeForms();
    this.authMode = this.router.snapshot.data['authMode'];
    this.titleCard = this.getTitleCard(this.authMode);
    if (this.authMode === 'activateAccount') {
      this.email = this.router.snapshot.params['email'];
      this.token = this.router.snapshot.params['token'];
      this.userService.activateAccount(this.email, this.token)
        .pipe(
          catchError(error => {
            this.message = error.error.message;
            this.errorOccurred = true;
            this.route.navigate(['/']);
            return of(null);
          })
        )
        .subscribe();
    }
    this.userService.loading$.subscribe(loading => {
      this.loading = loading;
    });
  }

  toggleShowPassword() {
    this.showPassword = !this.showPassword;
  }


  initializeForms() {
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
  }

  getTitleCard(authMode: string): string {
    switch (authMode) {
      case 'signIn': return 'Entrar';
      case 'signUp': return 'Novo usuário';
      case 'forgotPassword': return 'Recuperar senha';
      default: return '';
    }
  }

  signIn() {
    this.userService.signIn(this.formSignIn.get('login')?.value, this.formSignIn.get('password')?.value)
      .pipe(
        catchError(error => {
          return this.backendErrors = error.error;
        })
      )
      .subscribe();
  }

  signUp(): void {
    this.userService.signUp(this.formSignUp.getRawValue() as User)
      .pipe(
        tap(() => {
          this.backendErrors = [];
        }),
        catchError(error => {
          return this.backendErrors = Object.values(error.error.errors);
        })
      )
      .subscribe();
  }

  forgotPassword() {
    this.userService.forgotPassword(this.formForgotPassword.get('email')?.value)
      .pipe(
        catchError(error => {
          return this.backendErrors = Object.values(error.error.errors);
        })
      )
      .subscribe();
  }
}

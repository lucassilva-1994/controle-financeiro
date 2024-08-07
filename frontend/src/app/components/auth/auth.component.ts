import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { catchError, of, tap } from 'rxjs';
import { User } from 'src/app/models/User';
import { UserService } from 'src/app/services/user.service';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { MessageComponent } from '../shared/message/message.component';

import { SpinnerComponent } from '../shared/spinner/spinner.component';

@Component({
    selector: 'app-auth',
    templateUrl: './auth.component.html',
    styleUrls: ['./auth.component.css'],
    standalone: true,
    imports: [SpinnerComponent, MessageComponent, ReactiveFormsModule, MessagesValidatorsComponent, RouterLink]
})
export class AuthComponent implements OnInit {
  formSignIn: FormGroup;
  formSignUp: FormGroup;
  formForgotPassword: FormGroup;
  authMode: string;
  email: string;
  token: string;
  errorOccurred: boolean;
  titleCard: string;
  backendErrors: string[] = [];
  showPassword = false;
  get loading(): boolean {
    return this.userService.getLoading()();
  }

  get message():string{
    return this.userService.getMessage()();
  }

  set message(value: string) {
    this.userService.setMessage(value);
  }
  
  constructor(
    private router: ActivatedRoute,
    private formBuilder: FormBuilder,
    private userService: UserService,
    private route: Router
  ) {}
  ngOnInit(): void {
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

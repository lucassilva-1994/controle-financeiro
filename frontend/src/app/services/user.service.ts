import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, Subject, delay, finalize, of, takeUntil, tap } from 'rxjs';
import { environment } from 'src/environments/environment';
import { HttpClient, HttpParams } from '@angular/common/http';
import { TokenService } from './token.service';
import jwt_decode from "jwt-decode";
import { User } from '../models/User';
import { Router } from '@angular/router';
import { Password } from '../models/Password';

interface LoginResponse {
    message: string;
    token: string;
}

const apiUrl = environment.apiUrl + '/users';
@Injectable({ providedIn: 'root' })
export class UserService {
    private userSubject = new BehaviorSubject<User | null>(null);
    private loadingSubject = new BehaviorSubject<boolean>(false);
    loading$ = this.loadingSubject.asObservable();
    private messageSubject = new BehaviorSubject<string>('');
    message$ = this.messageSubject.asObservable();
    private destroy$ = new Subject<void>();
    constructor(
        private httpClient: HttpClient,
        private tokenService: TokenService,
        private route: Router) {
        this.tokenService.hasToken() && this.decode();
    }

    setToken(token: string) {
        this.tokenService.setToken(token);
        this.decode();
    }

    getUser(): Observable<User | null> {
        return this.userSubject.asObservable();
    }

    private decode() {
        const token = this.tokenService.getToken();

        if (token) {
            const user = jwt_decode(token) as User;
            this.userSubject.next(user);
        } else {
            console.error('Token não encontrado ou é nulo.');
        }
    }

    signOut(): void {
        this.httpClient.get<{ message: string }>(`${apiUrl}/sign-out`)
            .pipe(
                tap(
                    response => {
                            this.tokenService.removeToken();
                        this.userSubject.next(null);
                        this.route.navigate(['/']);
                    }
                ),
                takeUntil(this.destroy$)
            ).subscribe();
    }


    isLogged() {
        return this.tokenService.hasToken();
    }

    profile():Observable<User>{
        this.loadingSubject.next(true);
        return this.httpClient.get<User>(`${apiUrl}/profile`)
        .pipe(
            finalize(() => this.loadingSubject.next(false)),
            takeUntil(this.destroy$)
        );
    }

    signIn(login: string, password: string): Observable<LoginResponse> {
        this.loadingSubject.next(true);
        return this.httpClient.post<LoginResponse>(`${apiUrl}/sign-in`, { login, password })
            .pipe(
                finalize(() => this.loadingSubject.next(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.setToken(response.token),
                        this.route.navigate(['//financial-records']);
                })
            );
    }

    signUp(user: User): Observable<{ message: string }> {
        this.loadingSubject.next(true);
        return this.httpClient.post<{ message: string }>(apiUrl + '/sign-up', user)
            .pipe(
                finalize(() => this.loadingSubject.next(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.messageSubject.next(response.message),
                        this.route.navigate(['/']);
                })
            );
    }

    forgotPassword(email: string): Observable<{ message: string }> {
        this.loadingSubject.next(true);
        return this.httpClient.post<{ message: string }>(`${apiUrl}/forgot-password`, { email })
            .pipe(
                finalize(() => this.loadingSubject.next(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.messageSubject.next(response.message),
                        this.route.navigate(['/']);
                })
            );
    }

    changePasword(passwords: Password): Observable<{message: string}>{
        this.loadingSubject.next(true);
        return this.httpClient.put<{message: string}>(`${apiUrl}/restore-password`, passwords)
        .pipe(
            finalize(() => this.loadingSubject.next(false)),
            takeUntil(this.destroy$),
            tap( response => {
                this.messageSubject.next(response.message);
                of(null).pipe(
                    delay(5000),
                    takeUntil(this.destroy$)
                ).subscribe(() => this.messageSubject.next(''));
            })
        );
    }

    activateAccount(email: string, token: string): Observable<{ message: string }> {
        const params = new HttpParams()
            .set('email', email)
            .set('token', token);
        return this.httpClient.get<{ message: string }>(apiUrl + '/activate-account', { params })
            .pipe(
                finalize(() => this.loadingSubject.next(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.messageSubject.next(response.message),
                        this.route.navigate(['/']);
                })
            );;
    }
}
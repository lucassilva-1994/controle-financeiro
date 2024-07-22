import { Injectable, signal } from '@angular/core';
import {  Observable, Subject, delay, finalize, of, takeUntil, tap } from 'rxjs';
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
    private destroy$ = new Subject<void>();
    private loading = signal<boolean>(false);
    private message = signal<string>('');
    private user = signal<User | null>(null);


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

    getUser() {
        return this.user;
    }

    getLoading() {
        return this.loading;
    }

    getMessage() {
        return this.message;
    }

    setMessage(value: string): void {
        this.message.set(value);
    }

    private decode() {
        const token = this.tokenService.getToken();

        if (token) {
            const user = jwt_decode(token) as User;
            this.user.set(user);
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
                        this.user.set(null);
                        this.route.navigate(['/']);
                    }
                ),
                takeUntil(this.destroy$)
            ).subscribe();
    }


    isLogged() {
        return this.tokenService.hasToken();
    }

    profile(): Observable<User> {
        this.loading.set(true);
        return this.httpClient.get<User>(`${apiUrl}/profile`)
            .pipe(
                finalize(() => this.loading.set(false)),
                takeUntil(this.destroy$)
            );
    }

    signIn(login: string, password: string): Observable<LoginResponse> {
        this.loading.set(true);
        return this.httpClient.post<LoginResponse>(`${apiUrl}/sign-in`, { login, password })
            .pipe(
                finalize(() => this.loading.set(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.setToken(response.token),
                        this.route.navigate(['/financial-records']);
                })
            );
    }

    signUp(user: User): Observable<{ message: string }> {
        this.loading.set(true)
        return this.httpClient.post<{ message: string }>(apiUrl + '/sign-up', user)
            .pipe(
                finalize(() => this.loading.set(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.message.set(response.message),
                        of(null).pipe(
                            delay(50000),
                            takeUntil(this.destroy$)
                        ).subscribe(() => this.message.set(''));
                    this.route.navigate(['/']);
                })
            );
    }

    forgotPassword(email: string): Observable<{ message: string }> {
        this.loading.set(true);
        return this.httpClient.post<{ message: string }>(`${apiUrl}/forgot-password`, { email })
            .pipe(
                finalize(() => this.loading.set(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.message.set(response.message),
                        of(null).pipe(
                            delay(5000),
                            takeUntil(this.destroy$)
                        ).subscribe(() => this.message.set(''));
                    this.route.navigate(['/']);
                })
            );
    }

    changePasword(passwords: Password): Observable<{ message: string }> {
        this.loading.set(true);
        return this.httpClient.put<{ message: string }>(`${apiUrl}/restore-password`, passwords)
            .pipe(
                finalize(() => this.loading.set(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.message.set(response.message);
                    of(null).pipe(
                        delay(5000),
                        takeUntil(this.destroy$)
                    ).subscribe(() => this.message.set(''));
                })
            );
    }

    activateAccount(email: string, token: string): Observable<{ message: string }> {
        this.loading.set(true);
        const params = new HttpParams()
            .set('email', email)
            .set('token', token);
        return this.httpClient.get<{ message: string }>(apiUrl + '/activate-account', { params })
            .pipe(
                finalize(() => this.loading.set(false)),
                takeUntil(this.destroy$),
                tap(response => {
                    this.message.set(response.message),
                        of(null).pipe(
                            delay(5000),
                            takeUntil(this.destroy$)
                        ).subscribe(() => this.message.set(''));
                    this.route.navigate(['/']);
                })
            );
    }
}
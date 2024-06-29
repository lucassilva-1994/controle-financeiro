import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, finalize } from 'rxjs';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { TokenService } from './token.service';
import jwt_decode from "jwt-decode";
import { User } from '../models/User';

const apiUrl = environment.apiUrl + '/users';
@Injectable({ providedIn: 'root' })
export class UserService {
    private userSubject = new BehaviorSubject<User | null>(null);
    private loadingSubject = new BehaviorSubject<boolean>(false);
    loading$ = this.loadingSubject.asObservable();
    constructor(private httpClient: HttpClient, private tokenService: TokenService) {
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

    logout() {
        this.tokenService.removeToken();
        this.userSubject.next(null);
    }

    isLogged() {
        return this.tokenService.hasToken();
    }

    signIn(login: string, password: string): Observable<{ message: string }> {
        this.loadingSubject.next(true);
        return this.httpClient.post<{ message: string }>(`${apiUrl}/sign-in`, { login, password })
        .pipe(
            finalize(() => this.loadingSubject.next(false))
        );
    }

    signUp(user: User): Observable<{ message: string }> {
        this.loadingSubject.next(true);
        return this.httpClient.post<{ message: string }>(apiUrl + '/sign-up', user)
        .pipe(
            finalize(() => this.loadingSubject.next(false))
        );
    }
}
import { Injectable } from '@angular/core';
import {
    HttpRequest,
    HttpHandler,
    HttpEvent,
    HttpInterceptor
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { LocalStorageService } from '../services/LocalStorageService';

@Injectable()
export class TokenInterceptorInterceptor implements HttpInterceptor {

    constructor(private localStorageService: LocalStorageService) { }

    intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
        if (this.localStorageService.getItem('token')) {
            const token = this.localStorageService.getItem('token');
            request = request.clone({
                setHeaders: {
                    'Authorization': `${token}`
                }
            })
        }
        return next.handle(request);
    }
}
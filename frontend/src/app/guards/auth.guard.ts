import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot } from "@angular/router";
import { Observable, of } from "rxjs";
import { catchError, map } from "rxjs/operators";
import { environment } from "src/environments/environment";
import { TokenService } from "../services/token.service";

const apiUrl = environment.apiUrl + '/users/validate-token';

@Injectable({ providedIn: 'root' })
export class AuthGuard implements CanActivate {
    constructor(private router: Router, private httpClient: HttpClient, private tokenService: TokenService) {}

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        if (!this.tokenService.hasToken()) {
            this.router.navigate(['/'], {
                queryParams: {
                    fromUrl: state.url
                }
            });
            return of(false);
        }

        return this.httpClient.get<{ valid: boolean }>(apiUrl).pipe(
            map(response => {
                if (response.valid) {
                    this.router.navigate(['/financial-records']);
                    return true; 
                } else {
                    return true; 
                }
            }),
            catchError(() => {
                this.router.navigate(['/']);
                return of(false);
            })
        );
    }
}

import { Injectable } from "@angular/core";
import { CanActivate, Router } from "@angular/router";
import { Observable, of } from "rxjs";
import { tap, catchError, map } from "rxjs/operators";
import { UserService } from "../services/user.service";

@Injectable({ providedIn: "root" })
export class AuthGuard implements CanActivate {
    constructor(private userService: UserService, private router: Router) {}

    canActivate(): Observable<boolean> {
        return localStorage.getItem("token")
        ? this.userService.profile().pipe(
            map(() => { this.router.navigate(["/financial-records"]); return false; }),
            catchError(() => of(true))
        )
        : of(true);
    }
}
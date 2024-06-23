import { Injectable } from "@angular/core";

const KEY = 'token';
@Injectable({ providedIn : 'root'})
export class TokenService{
    hasToken(){
        return !!this.getToken();
    }

    setToken(token: string){
        localStorage.setItem(KEY, token);
    }

    getToken(): string | null{
        return localStorage.getItem(KEY);
    }

    removeToken(){
        localStorage.removeItem(KEY);
    }
}
import { Injectable } from "@angular/core";

@Injectable({providedIn:'root'})
export class LocalStorageService{
    getItem(item:string){
        return localStorage.getItem(item);
    }

    setItem(res:Object){
        const response = JSON.parse(JSON.stringify(res));
        localStorage.setItem('token',response.token);
        localStorage.setItem('user_id',response.user.id);
        localStorage.setItem('name',response.user.name);
        localStorage.setItem('email',response.user.email);
        localStorage.setItem('username',response.user.username);
    }

    removeItens(){
        localStorage.clear();
    }
}
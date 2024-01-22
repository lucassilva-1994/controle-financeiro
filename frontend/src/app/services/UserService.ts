import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { User } from "../models/User";
import { environment } from "src/environments/environment";
import { tap } from "rxjs";
import { LocalStorageService } from "./LocalStorageService";

const apiUrl = environment.apiUrl+'users';
@Injectable({
    providedIn:'root'
})
export class UserService{
    constructor(private httpClient:HttpClient, private localStorageService:LocalStorageService){}
    auth(user:User){
        return this.httpClient.post(apiUrl+'/signin',user);
    }
    create(user:User){
        return this.httpClient.post(apiUrl+'/signup',user);
    }
}
import { Resolve } from "@angular/router";
import { Observable } from "rxjs";
import { Injectable } from "@angular/core";
import { ClientCreditor } from "../models/ClientCreditor";
import { ClientCreditorService } from "../services/ClientCreditorService";

@Injectable({ providedIn: 'root'})
export class ClientCreditorResolve implements Resolve<ClientCreditor[]>{
    constructor(private clientCreditorService:ClientCreditorService){}
    resolve(): Observable<ClientCreditor[]> {
        return this.clientCreditorService.show();
    }
}
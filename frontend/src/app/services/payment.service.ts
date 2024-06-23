import { Injectable } from "@angular/core";
import { CrudService } from "./crud.service";
import { Payment } from "../models/Payment";
import { HttpClient } from "@angular/common/http";

@Injectable({ providedIn: 'root'})
export class PaymentService extends CrudService<Payment>{
    constructor(httpClient: HttpClient){
        super(httpClient,'payments')
    }
}
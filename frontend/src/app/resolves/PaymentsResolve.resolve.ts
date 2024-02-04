import { Resolve } from "@angular/router";
import { Observable } from "rxjs";
import { Injectable } from "@angular/core";
import { Payment } from "../models/Payment";
import { PaymentService } from "../services/PaymentService";

@Injectable({ providedIn: 'root'})
export class PaymentResolve implements Resolve<Payment[]>{
    constructor(private paymentService:PaymentService){}
    resolve(): Observable<Payment[]> {
        return this.paymentService.show();
    }
}
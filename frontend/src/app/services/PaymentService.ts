import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { environment } from "src/environments/environment";
import { Payment } from "../models/Payment";

const apiUrl = environment.apiUrl + 'payments/';
@Injectable({ providedIn: 'root' })
export class PaymentService {
    constructor(private httpClient: HttpClient) { }

    show(): Observable<Payment[]> {
        return this.httpClient.get<Payment[]>(apiUrl);
    }

    showById(id: string): Observable<Payment> {
        return this.httpClient.get<Payment>(apiUrl + 'show/' + id);
    }

    create(payment: Payment): Observable<{ message: string }> {
        return this.httpClient.post<{ message: string }>(apiUrl + 'create', payment);
    }

    update(payment: Payment, id: string): Observable<{ message: string }> {
        return this.httpClient.put<{ message: string }>(apiUrl + 'update/' + id, payment);
    }

    delete(id: string): Observable<{ message: string }> {
        return this.httpClient.delete<{ message: string }>(apiUrl + 'delete/' + id);
    }

}
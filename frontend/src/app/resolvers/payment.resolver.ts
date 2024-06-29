import { ActivatedRouteSnapshot, Resolve, RouterStateSnapshot } from '@angular/router';
import { Payment } from '../models/Payment';
import { PaymentService } from '../services/payment.service';
import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })
export class PaymentResolver implements Resolve<{ pages: number, total: number, search: string, itens: Payment[] }> {
  constructor(private paymentService: PaymentService) { }

  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<{ pages: number, total: number, search: string, itens: Payment[] }> {
    return this.paymentService.show();
  }
}

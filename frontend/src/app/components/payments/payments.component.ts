import { Component, OnInit } from '@angular/core';
import { Observable, take } from 'rxjs';
import { Payment } from 'src/app/models/Payment';
import { PaymentService } from 'src/app/services/PaymentService';

@Component({
  selector: 'app-payments',
  templateUrl: './payments.component.html',
  styleUrls: ['./payments.component.css']
})
export class PaymentsComponent implements OnInit {
  title: string = 'Formas de pagamentos';
  payments$: Observable<Payment[]>;
  message: string;
  class: string;
  constructor(private paymentService: PaymentService) { }
  ngOnInit(): void {
    this.show();
  }

  show() {
    this.payments$ = this.paymentService.show();
  }

  delete(id: string) {
    this.paymentService.delete(id)
      .pipe(take(1))
      .subscribe({
        next: (response) => {
          this.message = response.message;
          this.class = 'success';
          this.show();
        },
        error: (error) => {
          this.message = error.message;
          this.class = 'danger';
        }
      });
  }
}

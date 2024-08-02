import { HttpErrorResponse } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { catchError, of, tap } from 'rxjs';
import { Payment } from 'src/app/models/Payment';
import { PaymentService } from 'src/app/services/payment.service';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { TableComponent } from '../shared/table/table.component';

import { MessageComponent } from '../shared/message/message.component';
import { SpinnerComponent } from '../shared/spinner/spinner.component';
import { LayoutComponent } from '../shared/layout/layout.component';

@Component({
    selector: 'app-payments',
    templateUrl: './payments.component.html',
    styleUrls: ['./payments.component.css'],
    standalone: true,
    imports: [LayoutComponent, SpinnerComponent, MessageComponent, TableComponent, CardFormComponent, MessagesValidatorsComponent, ReactiveFormsModule, ButtonSubmitComponent]
})
export class PaymentsComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-credit-card' },
    { key: 'type', label: 'Tipo', icon: 'fas fa-list-alt' },
    { key: 'is_calculable', label: 'Calculado?', icon: 'fas fa-calculator' },
    { key: 'description', label: 'Descrição', icon: 'fas fa-info-circle' },
    { key: 'financial_records_count', label: 'Registros', icon: 'fas fa-database' },
    { key: 'financial_records_sum_amount', label: 'Movimentações', icon: 'fas fa-money-bill-wave' },
    { key: 'created_at', label: 'Criado em', icon: 'fas fa-calendar-plus' },
    { key: 'updated_at', label: 'Alterado em', icon: 'fas fa-calendar-check' },
  ];

  mode: string;
  form: FormGroup;
  id: string;
  message: string;
  payments: Payment[] = [];
  backendErrors: string[] = [];
  pages: number;
  total: number;
  loading: boolean;
  constructor(
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private paymentService: PaymentService) { }
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.initializeForm();
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.paymentService.message$.subscribe( message => {
      this.message = message;
    })
    this.paymentService.loading$.subscribe( loading => {
      this.loading = loading
    })
    this.mode === 'view' ? this.show({perPage:10, page:1, search: ''}) : this.recentRecords();
  }

  show(event: {perPage: number, page: number, search: string}) {
    this.paymentService.show(event.perPage, event.page, event.search)
      .pipe(tap(response => {
        this.payments = response.itens;
        this.pages = response.pages;
        this.total = response.total;
      }))
      .subscribe();
  }

  recentRecords() {
    this.paymentService.recentRecords()
      .pipe(tap(response => this.payments = response.itens))
      .subscribe();
  }

  initializeForm() {
    this.form = this.formBuilder.group({
      name: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(40)]],
      description: ['', [Validators.maxLength(100)]],
      type: ['BOTH', [Validators.required]],
      is_calculable: [0, [Validators.required]]
    })
  }

  showById(id: string) {
    this.paymentService.showById(id)
      .pipe(
        tap(response => {
          this.form.patchValue(response);
        })
      )
      .subscribe();
  }

  onSubmit() {
    const form = this.form.getRawValue() as Payment;
    const handleSuccess = () => { this.mode === 'new' ? this.form.reset() : null; this.show({perPage:10, page:1, search: ''}); this.backendErrors = []; };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' ? this.paymentService.store(form) : this.paymentService.update(form, this.id))
          .pipe(tap(handleSuccess),catchError(handleErrors)).subscribe();
  }

  delete(event: { id: string }) {
    this.paymentService.delete(event.id)
      .pipe(tap(() => {this.show({perPage:10, page:1, search: ''});}))
      .subscribe();
  }
}

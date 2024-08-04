import { Component, OnInit } from '@angular/core';
import { FinancialRecordService } from 'src/app/services/financial-record.service';
import { Payment } from 'src/app/models/Payment';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { FinancialRecord } from 'src/app/models/FinancialRecord';
import { Observable, catchError, of, tap } from 'rxjs';
import { CategoryService } from 'src/app/services/category.service';
import { Category } from 'src/app/models/Category';
import { PaymentService } from 'src/app/services/payment.service';
import { HttpErrorResponse } from '@angular/common/http';
import { SupplierAndCustomer } from 'src/app/models/SupplierAndCustomer';
import { SupplierAndCustomerService } from 'src/app/services/supplier-and-customer.service';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { TableComponent } from '../shared/table/table.component';
import { CurrencyPipe, DatePipe } from '@angular/common';
import { MessageComponent } from '../shared/message/message.component';
import { SpinnerComponent } from '../shared/spinner/spinner.component';
import { LayoutComponent } from '../shared/layout/layout.component';
import { GenericPipe } from 'src/app/pipes/generic-pipe.pipe';

declare var window: any;

@Component({
    selector: 'app-financial-records',
    templateUrl: './financial-records.component.html',
    styleUrls: ['./financial-records.component.css'],
    standalone: true,
    imports: [
      LayoutComponent, SpinnerComponent, MessageComponent, TableComponent, 
      CardFormComponent, MessagesValidatorsComponent, ReactiveFormsModule, 
      ButtonSubmitComponent, CurrencyPipe, GenericPipe, DatePipe]
})
export class FinancialRecordsComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'description', label: 'Descrição', icon: 'fas fa-info-circle' },
    { key: 'amount', label: 'Valor', icon: 'fas fa-money-bill-wave' },
    { key: 'financial_record_type', label: 'Tipo', icon: 'fas fa-list-alt' },
    { key: 'payment', label: 'Pagamento', icon: 'fas fa-credit-card' },
    { key: 'paid', label: 'Pago', icon: 'fas fa-credit-card' },
    { key: 'financial_record_date', label: 'Data', icon: 'fas fa-calendar-plus' },
    { key: 'financial_record_due_date', label: 'Vencimento', icon: 'fas fa-calendar-check' }
  ];
  actions = [
    {
      icon: 'fa fa-eye',
      class: 'btn btn-info',
      title: 'Ver detalhes',
      callback: (item: FinancialRecord) => this.openModalFinancialRecordDetails(item)
    },
    {
      icon: 'fa fa-exchange-alt',
      class: 'btn btn-secondary',
      title: 'Mudar status quitado',
      callback: (item: FinancialRecord) => this.togglePaidStatus(item)
    }
  ];
  
  mode: string;
  form: FormGroup;
  formPayment: FormGroup;
  formCategory: FormGroup;
  errorsPayments: string[] = [];
  errorsCategories: string[] = [];
  errorsSuppliersAndCustomers: string[] = [];
  formSupplierAndCustomer: FormGroup;
  id: string;
  total_income: number;
  total_expense: number;
  balance: number;
  total: number;
  message: string;
  financialRecords: FinancialRecord[] = [];
  payments: Payment[] = [];
  categories: Category[] = [];
  suppliersAndCustomers: SupplierAndCustomer[] = [];
  financialRecord: FinancialRecord;
  pages: number;
  loading: boolean;
  backendErrors: string[] = [];
  isRecurring: boolean = false;
  modalPayment: any;
  modalCategory: any;
  modalSupplierAndCustomer: any;
  modalFinancialDetails: any;
  selectedFiles: File[] = [];

  constructor(
    private financialRecordService: FinancialRecordService,
    private route: ActivatedRoute,
    private categoryService: CategoryService,
    private paymentService: PaymentService,
    private formBuilder: FormBuilder,
    private suppliersAndCustomersService: SupplierAndCustomerService) {
  }
  ngOnInit(): void {
    this.payments = this.route.snapshot.data['payments'];
    this.categories = this.route.snapshot.data['categories'];
    this.suppliersAndCustomers = this.route.snapshot.data['suppliersAndCustomers'];
    this.mode = this.route.snapshot.data['mode'];
    this.modalPayment = this.initializeModal('paymentModal');
    this.modalCategory = this.initializeModal('categoryModal');
    this.modalFinancialDetails = this.initializeModal('financialRecordDetailsModal');
    this.modalSupplierAndCustomer = this.initializeModal('supplierAndCustomerModal');
    this.financialRecordService.loading$.subscribe(loading => {
      this.loading = loading
    })
    this.subscribeToMessage(this.financialRecordService.message$);
    this.subscribeToMessage(this.paymentService.message$);
    this.subscribeToMessage(this.suppliersAndCustomersService.message$);
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.initializeForms();
    this.initializeData();
    this.mode === 'view' ? this.show({ perPage: 10, page: 1, search: '' }) : this.recentRecords();
  }

  subscribeToMessage(message$: Observable<string>) {
    message$.subscribe((message: string) => {
      this.message = message;
    });
  }

  initializeForms() {
    this.initializeForm();
    this.initializeFormPayment();
    this.initializeFormCategory();
    this.initializeFormSupplierAndCustomer();
  }

  initializeModal(modalId: string): any {
    return new window.bootstrap.Modal(document.getElementById(modalId));
  }

  initializeData() {
    this.calculateIncomeExpense();
    this.loadingCategories();
    this.loadingPayments();
    this.loadingSuppliersAndCustomers();
  }

  show(event: { perPage: number, page: number, search: string }) {
    this.financialRecordService.show(event.perPage, event.page, event.search)
      .pipe(
        tap(response => {
          this.financialRecords = response.itens;
          this.pages = response.pages;
          this.total = response.total;
        })
      ).subscribe();
  }

  showById(id: string) {
    this.financialRecordService.showById(id)
      .pipe(
        tap((response: FinancialRecord) => {
          this.form.patchValue(response);
          this.financialRecord = response
        })
      )
      .subscribe();
  }

  calculateIncomeExpense() {
    this.financialRecordService.calculateIncomeExpense().subscribe(response => {
      this.total_income = response.total_income
      this.total_expense = response.total_expense
      this.balance = response.balance
    });
  }

  loadingCategories(type: string = '') {
    this.categoryService.showWithoutPagination(['id', 'name'], type).pipe(
      tap(response => {
        this.categories = response;
      })
    ).subscribe();
  }

  loadingPayments(type: string = '') {
    this.paymentService.showWithoutPagination(['id', 'name'], type).pipe(
      tap(response => {
        this.payments = response;
      })
    ).subscribe();
  }

  loadingSuppliersAndCustomers(type: string = '') {
    this.suppliersAndCustomersService.showWithoutPagination(['id', 'name'], type).pipe(
      tap(response => {
        this.suppliersAndCustomers = response;
      })
    ).subscribe();
  }

  initializeForm() {
    this.form = this.formBuilder.group({
      description: [''],
      amount: [''],
      category_id: [''],
      payment_id: [''],
      supplier_customer_id: [''],
      financial_record_date: [this.currentDate()],
      financial_record_due_date: [this.currentDate()],
      paid: [1],
      financial_record_type: [''],
      details: [''],
      installment_total: [1],
      increment_interval: [1]
    });
    this.loadingPayments();
    this.loadingSuppliersAndCustomers();
    this.loadingCategories();
    this.form.get('financial_record_type')?.valueChanges.subscribe(value => {
      this.loadingPayments(value);
      this.loadingSuppliersAndCustomers(value);
      this.loadingCategories(value);
    });
  }

  initializeFormSupplierAndCustomer() {
    this.formSupplierAndCustomer = this.formBuilder.group({
      name: [''],
      description: [''],
      type: ['CUSTOMER'],
      email: [''],
      phone: ['']
    });
  }

  initializeFormPayment() {
    this.formPayment = this.formBuilder.group({
      name: [''],
      type: ['INCOME'],
      description: [''],
      is_calculable: [1]
    });
  }

  initializeFormCategory() {
    this.formCategory = this.formBuilder.group({
      name: [''],
      type: ['INCOME'],
      description: ['']
    });
  }

  onRecurringChange(event: any): void {
    this.isRecurring = event.target.checked;
    if (!this.isRecurring) {
      this.form.patchValue({
        installment_total: 1,
        increment_interval: 1
      });
    }
  }

  recentRecords() {
    this.financialRecordService.recentRecords()
      .pipe(tap(response => this.financialRecords = response.itens))
      .subscribe();
  }

  delete(event: { id: string }) {
    this.financialRecordService.delete(event.id)
      .pipe(tap(() => { this.show({ perPage: 10, page: 1, search: '' }), this.calculateIncomeExpense() }))
      .subscribe();
  }

  onSubmit() {
    const formData = new FormData();
    formData.append('description', this.form.get('description')?.value);
    formData.append('amount', this.form.get('amount')?.value);
    formData.append('category_id', this.form.get('category_id')?.value);
    formData.append('payment_id', this.form.get('payment_id')?.value);
    formData.append('supplier_customer_id', this.form.get('supplier_customer_id')?.value);
    formData.append('financial_record_date', this.form.get('financial_record_date')?.value);
    formData.append('financial_record_due_date', this.form.get('financial_record_due_date')?.value);
    formData.append('paid', this.form.get('paid')?.value);
    formData.append('financial_record_type', this.form.get('financial_record_type')?.value);
    formData.append('details', this.form.get('details')?.value);
    formData.append('installment_total', this.form.get('installment_total')?.value);
    formData.append('increment_interval', this.form.get('increment_interval')?.value);
    if (this.selectedFiles.length > 0) {
      for (let i = 0; i < this.selectedFiles.length; i++) {
        formData.append('files[]', this.selectedFiles[i]);
      }
    }
    const handleSuccess = () => {
      if (this.mode === 'new') {
        this.initializeForm();
      }
      this.isRecurring = false;
      this.show({ perPage: 10, page: 1, search: '' });
      this.backendErrors = [];
    };

    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' 
      ? this.financialRecordService.store(formData) 
      : this.financialRecordService.update(this.form.getRawValue(), this.id)
    )
    .pipe(
      tap(handleSuccess), 
      catchError(handleErrors) 
    )
    .subscribe();
  }
  

  onFileSelected(event: any) {
    this.selectedFiles = event.target.files;
  }

  currencyMask(event: Event): void {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');
    let formattedValue = '';
    if (value.length <= 2) {
      formattedValue = 'R$ 0,' + value.padStart(2, '0'); // Adiciona zeros à esquerda se necessário
    } else {
      const integerPart = value.slice(0, -2);
      const decimalPart = value.slice(-2);
      const trimmedIntegerPart = integerPart.replace(/^0+/, '');
      formattedValue = 'R$ ' + trimmedIntegerPart.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ',' + decimalPart;
    }
    this.form.get('amount')?.setValue(formattedValue, { emitEvent: false });
  }

  currentDate() {
    return new Date().toISOString().split('T')[0];
  }

  storePayment() {
    const form = this.formPayment.getRawValue() as Payment;
    const handleSuccess = () => {
      this.initializeFormPayment();
      this.loadingPayments();
      this.errorsPayments = [];
      this.modalPayment.hide();
    };
    const handleErrors = (error: HttpErrorResponse) => {
      this.errorsPayments = Object.values(error.error.errors);
      return of(null);
    };
    this.paymentService.store(form)
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }


  storeCategory() {
    const form = this.formCategory.getRawValue() as Category;
    const handleSuccess = () => {
      this.initializeFormCategory();
      this.loadingCategories();
      this.errorsCategories = [];
      this.modalCategory.hide();
    };
    const handleErrors = (error: HttpErrorResponse) => {
      this.errorsCategories = Object.values(error.error.errors);
      return of(null);
    };
    this.categoryService.store(form)
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }

  storeSupplierAndCustomer() {
    const form = this.formSupplierAndCustomer.getRawValue() as SupplierAndCustomer;
    const handleSuccess = () => {
      this.initializeFormSupplierAndCustomer();
      this.loadingSuppliersAndCustomers();
      this.errorsSuppliersAndCustomers = [];
      this.modalSupplierAndCustomer.hide();
    };
    const handleErrors = (error: HttpErrorResponse) => {
      this.errorsSuppliersAndCustomers = Object.values(error.error.errors);
      return of(null);
    };
    this.suppliersAndCustomersService.store(form)
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }

  phoneMask(event: Event): void {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');
    if (value.length > 11) {
      value = value.slice(0, 11);
    }
    let formattedValue = '';
    if (value.length > 0) {
      formattedValue += '(' + value.substring(0, 2);
    }
    if (value.length > 2) {
      formattedValue += ') ' + value.substring(2, value.length >= 7 ? 7 : value.length);
    }
    if (value.length > 7) {
      formattedValue += '-' + value.substring(7, 11);
    }
    input.value = formattedValue.substring(0, 15);
  }

  //Modais
  openModalPayment() {
    this.initializeFormPayment();
    this.modalPayment.show();
  }

  openModalCategory() {
    this.modalCategory.show();
  }

  openModalSupplierAndCustomer() {
    this.modalSupplierAndCustomer.show();
  }

  openModalFinancialRecordDetails(financialRecord: FinancialRecord){
    this.financialRecord = financialRecord;
    this.modalFinancialDetails.show();
  }

  togglePaidStatus(item: FinancialRecord): void {
    item.paid = item.paid ? 0 : 1;
    this.financialRecordService.update(item, item.id)
      .pipe(tap(
        () => {
          this.calculateIncomeExpense()
        }
      ))
      .subscribe();
  }
  
}

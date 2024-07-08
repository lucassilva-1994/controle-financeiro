import { Component, OnInit } from '@angular/core';
import { FinancialRecordService } from 'src/app/services/financial-record.service';
import { Payment } from 'src/app/models/Payment';
import { ActivatedRoute } from '@angular/router';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { FinancialRecord } from 'src/app/models/FinancialRecord';
import { Observable, catchError, of, tap } from 'rxjs';
import { CategoryService } from 'src/app/services/category.service';
import { Category } from 'src/app/models/Category';
import { PaymentService } from 'src/app/services/payment.service';
import { HttpErrorResponse } from '@angular/common/http';
import { SupplierAndCustomer } from 'src/app/models/SupplierAndCustomer';
import { SupplierAndCustomerService } from 'src/app/services/supplier-and-customer.service';

declare var window: any;

@Component({
  selector: 'app-financial-records',
  templateUrl: './financial-records.component.html',
  styleUrls: ['./financial-records.component.css']
})
export class FinancialRecordsComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'description', label: 'Descrição', icon: 'fas fa-info-circle' },
    { key: 'amount', label: 'Valor', icon: 'fas fa-money-bill-wave' },
    { key: 'categories_count', label: 'Categorias', icon: 'fas fa-layer-group' },
    { key: 'financial_record_type', label: 'Tipo', icon: 'fas fa-list-alt' },
    { key: 'payment', label: 'Forma de pagamento', icon: 'fas fa-credit-card' },
    { key: 'paid', label: 'Pago', icon: 'fas fa-credit-card' },
    { key: 'supplier_and_customer', label: 'Fornecedor/Cliente', icon: 'fas fa-briefcase' },
    { key: 'financial_record_date', label: 'Data', icon: 'fas fa-calendar-plus' },
    { key: 'financial_record_due_date', label: 'Vencimento', icon: 'fas fa-calendar-check' },
  ];
  mode: string;
  form: FormGroup;
  formPayment: FormGroup;
  errorsPayments: string[] = [];
  errorsSuppliersAndCustomers: string[] = [];
  formSupplierAndCustomer: FormGroup;
  id: string;
  total_income: number;
  total_expense: number;
  balance: number;
  message: string;
  financialRecords: FinancialRecord[] = [];
  payments: Payment[] = [];
  categories: Category[] = [];
  suppliersAndCustomers: SupplierAndCustomer[] = [];
  pages: number;
  loading: boolean;
  backendErrors: string[] = [];
  isRecurring: boolean = false;
  modalPayment: any;
  modalSupplierAndCustomer: any;

  constructor(
    private financialRecordService: FinancialRecordService,
    private route: ActivatedRoute,
    private categoryService: CategoryService,
    private paymentService: PaymentService,
    private formBuilder: FormBuilder,
    private suppliersAndCustomersService: SupplierAndCustomerService) {
  }
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.modalPayment = this.initializeModal('paymentModal');
    this.modalSupplierAndCustomer = this.initializeModal('supplierAndCustomerModal');
    this.financialRecordService.loading$.subscribe( loading => {
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

  initializeForms(){
    this.initializeForm();
    this.initializeFormPayment();
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
        })
      ).subscribe();
  }

  showById(id: string) {
    this.financialRecordService.showById(id)
      .pipe(
        tap((response: FinancialRecord) => {
          this.form.patchValue(response); // preenche o formulário com os dados do registro financeiro

          // Pre-seleciona as categorias no formulário
          const selectedCategoryIds = response.categoryIds;
          const categoriesFormArray = this.form.get('categories') as FormArray;

          this.categories.forEach(category => {
            if (selectedCategoryIds.includes(category.id)) {
              categoriesFormArray.push(this.formBuilder.control(category.id));
            }
          });
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
      categories: this.formBuilder.array([]),
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
    const initialType = this.form.get('financial_record_type')?.value; 
    this.loadingPayments(initialType);
    this.loadingSuppliersAndCustomers(initialType);
    this.loadingCategories(initialType);
    this.form.get('financial_record_type')?.valueChanges.subscribe(value => {
      this.loadingPayments(value);
      this.loadingSuppliersAndCustomers(value);
      this.loadingCategories(value);
    });
  }

  initializeFormSupplierAndCustomer(){
      this.formSupplierAndCustomer = this.formBuilder.group({
        name:[''],
        description:[''],
        type:['CUSTOMER'],
        email:[''],
        phone:['']
      });
  }

  initializeFormPayment(){
      this.formPayment = this.formBuilder.group({
        name:[''],
        type:['INCOME'],
        description:[''],
        is_calculable:[1]
      });
  }

  onCheckboxChange(e: Event) {
    const target = e.target as HTMLInputElement;
    const categories: FormArray = this.form.get('categories') as FormArray;
    if (target.checked) {
      categories.push(this.formBuilder.control(target.value));
    } else {
      const index = categories.controls.findIndex(x => x.value === target.value);
      categories.removeAt(index);
    }
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
    const form = this.form.getRawValue();
    const handleSuccess = () => { this.mode === 'new' ? this.initializeForm() : null; this.isRecurring = false; this.show({ perPage: 10, page: 1, search: '' }); this.backendErrors = []; };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    console.log(form);
    (this.mode === 'new' ? this.financialRecordService.store(form) : this.financialRecordService.update(form, this.id))
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
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

  storePayment(){
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

  storeSupplierAndCustomer(){
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
  openModalPayment(){
    this.initializeFormPayment();
    this.modalPayment.show();
  }

  openModalSupplierAndCustomer(){
    this.modalSupplierAndCustomer.show();
  }
}

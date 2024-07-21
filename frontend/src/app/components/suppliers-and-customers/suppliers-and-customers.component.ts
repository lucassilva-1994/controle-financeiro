import { HttpErrorResponse } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { catchError, of, tap } from 'rxjs';
import { SupplierAndCustomer } from 'src/app/models/SupplierAndCustomer';
import { SupplierAndCustomerService } from 'src/app/services/supplier-and-customer.service';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { TableComponent } from '../shared/table/table.component';
import { NgIf } from '@angular/common';
import { MessageComponent } from '../shared/message/message.component';
import { SpinnerComponent } from '../shared/spinner/spinner.component';
import { LayoutComponent } from '../shared/layout/layout.component';

@Component({
    selector: 'app-suppliers-and-customers',
    templateUrl: './suppliers-and-customers.component.html',
    styleUrls: ['./suppliers-and-customers.component.css'],
    standalone: true,
    imports: [LayoutComponent, SpinnerComponent, MessageComponent, NgIf, TableComponent, CardFormComponent, MessagesValidatorsComponent, ReactiveFormsModule, ButtonSubmitComponent]
})
export class SuppliersAndCustomersComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-briefcase' },
    { key: 'type', label: 'Tipo', icon: 'fas fa-list-alt' },
    { key: 'description', label: 'Descrição', icon: 'fas fa-info-circle' },
    { key: 'financial_records_count', label: 'Registros', icon: 'fas fa-database' },
    { key: 'financial_records_sum_amount', label: 'Movimentações', icon: 'fas fa-money-bill-wave' },    { key: 'email', label: 'Email', icon: 'fas fa-envelope' },
    { key: 'phone', label: 'Telefone', icon: 'fas fa-phone' },
    { key: 'created_at', label: 'Criado em', icon: 'fas fa-calendar-plus' },
    { key: 'updated_at', label: 'Alterado em', icon: 'fas fa-calendar-check' },
  ];
  mode: string;
  form: FormGroup;
  id: string;
  suppliersAndCustommers: SupplierAndCustomer[] = [];
  backendErrors: string[] = [];
  pages: number;
  total: number;
  message: string;
  loading: boolean;
  constructor(
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private supplierAndCustomerService: SupplierAndCustomerService) { }
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.initializeForm();
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.supplierAndCustomerService.loading$.subscribe( loading => {
      this.loading = loading
    })
    this.supplierAndCustomerService.message$.subscribe( message => {
      this.message = message
    })
    this.mode === 'view' ? this.show({perPage:10, page:1, search:''}) : this.recentRecords();
  }


  show(event: {perPage:number, page: number, search: string}) {
    this.supplierAndCustomerService.show(event.perPage, event.page, event.search)
      .pipe(tap(response => {
        this.suppliersAndCustommers = response.itens;
        this.pages = response.pages;
        this.total = response.total;
      }))
      .subscribe();
  }

  showById(id: string) {
    this.supplierAndCustomerService.showById(id)
      .pipe(tap(response => this.form.patchValue(response)))
      .subscribe();
  }

  recentRecords() {
    this.supplierAndCustomerService.recentRecords()
      .pipe(tap(response => this.suppliersAndCustommers = response.itens))
      .subscribe();
  }

  initializeForm() {
    this.form = this.formBuilder.group({
      name: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(40)]],
      description: ['', [Validators.maxLength(100)]],
      type: ['BOTH', [Validators.required]],
      email: ['', [Validators.maxLength(100), Validators.email]],
      phone: ['', [Validators.maxLength(15)]]
    })
  }

  onSubmit() {
    const form = this.form.getRawValue() as SupplierAndCustomer;
    const handleSuccess = () => { this.mode === 'new' ? this.form.reset() : null; this.show({perPage:10, page:1, search:''}); this.backendErrors = [];};
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' ? this.supplierAndCustomerService.store(form) : this.supplierAndCustomerService.update(form, this.id))
          .pipe(tap(handleSuccess),catchError(handleErrors)).subscribe();
  }

  delete(event: { id: string }) {
    this.supplierAndCustomerService.delete(event.id)
      .pipe(tap(() => this.show({perPage:10, page:1, search:''}))).subscribe();
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
}

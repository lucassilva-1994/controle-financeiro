import { HttpErrorResponse } from '@angular/common/http';
import { Component, inject, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { catchError, of, tap } from 'rxjs';
import { FinancialPlan } from 'src/app/models/FinancialPlan';
import { FinancialPlanService } from 'src/app/services/financial-plan.service';
import { LayoutComponent } from '../shared/layout/layout.component';
import { SpinnerComponent } from '../shared/spinner/spinner.component';
import { MessageComponent } from '../shared/message/message.component';
import { TableComponent } from '../shared/table/table.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { DatePipe } from '@angular/common';
import { GenericPipe } from 'src/app/pipes/generic-pipe.pipe';

declare var window: any;
@Component({
  selector: 'app-financial-plans',
  standalone: true,
  imports: [LayoutComponent, SpinnerComponent, MessageComponent, TableComponent, CardFormComponent,
    MessagesValidatorsComponent, ReactiveFormsModule, ButtonSubmitComponent, DatePipe, GenericPipe
  ],
  templateUrl: './financial-plans.component.html',
  styleUrl: './financial-plans.component.css'
})
export class FinancialPlansComponent implements OnInit {
  mode: string;
  form: FormGroup;
  id: string;
  message: string;
  backendErrors: string[] = [];
  pages: number;
  total: number;
  loading: boolean;
  financialPlans: FinancialPlan[] = [];
  financialPlan: FinancialPlan;
  modalFinancialPlan: any;
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-wallet' },
    { key: 'description', label: 'Descrição', icon: 'fas fa-file-alt' },
    { key: 'plan_type', label: 'Tipo', icon: 'fas fa-chart-line' },
    { key: 'financial_plan_items_count', label: 'Itens', icon: 'fas fa-clipboard-list' },
  ];

  actions = [
    {
      icon: 'fa fa-eye',
      class: 'btn btn-info',
      title: 'Ver detalhes',
      callback: (item: FinancialPlan) => this.openModalFinancialPlanDetails(item)
    },
    {
      icon: 'fa fa-plus-circle',
      class: 'btn btn-success',
      title: 'Adicionar itens',
      callback: (item: FinancialPlan) => this.financialPlanItens(item)
    }
  ];
  private financialPlanService = inject(FinancialPlanService);
  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private formBuilder = inject(FormBuilder);
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.modalFinancialPlan = this.initializeModal('financialPlanModal');
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.initializeForm();
    this.financialPlanService.message$.subscribe(message => {
      this.message = message;
    })
    this.financialPlanService.loading$.subscribe(loading => {
      this.loading = loading
    })
    this.mode === 'view' ? this.show({ perPage: 10, page: 1, search: '' }) : this.recentRecords();
  }

  initializeModal(modalId: string): any {
    return new window.bootstrap.Modal(document.getElementById(modalId));
  }

  openModalFinancialPlanDetails(financialPlan: FinancialPlan){
    this.financialPlan = financialPlan;
    this.modalFinancialPlan.show();
  } 

  financialPlanItens(financialPlan: FinancialPlan){
    console.log(financialPlan);
    this.router.navigateByUrl(`financial-plans-items/${financialPlan.id}`)
  }

  show(event: { perPage: number, page: number, search: string }) {
    this.financialPlanService.show(event.perPage, event.page, event.search)
      .pipe(tap(financialPlans => {
        this.financialPlans = financialPlans.itens;
        this.pages = financialPlans.pages;
        this.total = financialPlans.total;
      }))
      .subscribe();
  }

  recentRecords() {
    this.financialPlanService.recentRecords()
      .pipe(tap(financialPlans => this.financialPlans = financialPlans.itens))
      .subscribe();
  }

  showById(id: string) {
    this.financialPlanService.showById(id)
      .pipe(
        tap(financialPlan => {
          this.form.patchValue(financialPlan);
        })
      )
      .subscribe();
  }

  initializeForm() {
    this.form = this.formBuilder.group({
      name: [''],
      description: [''],
      plan_type: ['BUDGET']
    })
  }

  onSubmit() {
    const form = this.form.getRawValue() as FinancialPlan;
    console.log(form);
    const handleSuccess = () => { this.mode === 'new' ? this.form.reset() : null; this.show({ perPage: 10, page: 1, search: '' }); this.backendErrors = []; };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' ? this.financialPlanService.store(form) : this.financialPlanService.update(form, this.id))
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }

  delete(event: { id: string }) {
    this.financialPlanService.delete(event.id)
      .pipe(tap(() => { this.show({ perPage: 10, page: 1, search: '' }); }))
      .subscribe();
  }
}

import { Component, inject, OnInit } from '@angular/core';
import { LayoutComponent } from '../shared/layout/layout.component';
import { FinancialPlanService } from 'src/app/services/financial-plan.service';
import { FinancialPlan } from 'src/app/models/FinancialPlan';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { catchError, of, pipe, tap } from 'rxjs';
import { MessageComponent } from '../shared/message/message.component';
import { SpinnerComponent } from '../shared/spinner/spinner.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { CommonModule, CurrencyPipe, DatePipe } from '@angular/common';
import { FinancialPlanItemService } from 'src/app/services/financial-plan-item.service';
import { FinancialPlanItem } from 'src/app/models/FinancialPlanItem';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { GenericPipe } from 'src/app/pipes/generic-pipe.pipe';

@Component({
  selector: 'app-financial-plans-items',
  standalone: true,
  imports: [LayoutComponent, MessageComponent, SpinnerComponent,
    CardFormComponent, ReactiveFormsModule, ButtonSubmitComponent,
     FormsModule, DatePipe, CurrencyPipe, CommonModule, MessagesValidatorsComponent,
     GenericPipe, RouterLink
  ],
  templateUrl: './financial-plans-items.component.html',
  styleUrl: './financial-plans-items.component.css'
})
export class FinancialPlansItemsComponent implements OnInit {
  financial_plan_id: string;
  financialPlan: FinancialPlan;
  financialPlanItems: FinancialPlanItem[];
  loading: boolean;
  message: string;
  backendErrors: string[] = [];
  sum_total: number | string;
  sum_checked: number | string;
  units = [
    { value: 'kg', label: 'Quilograma' },
    { value: 'g', label: 'Grama' },
    { value: 'mg', label: 'Miligrama' },
    { value: 'L', label: 'Litro' },
    { value: 'mL', label: 'Mililitro' },
    { value: 'm', label: 'Metro' },
    { value: 'cm', label: 'Centímetro' },
    { value: 'mm', label: 'Milímetro' },
    { value: 'dz', label: 'Dúzia' },
    { value: 'un', label: 'Unidade' },
    { value: 'ct', label: 'Cartela' }
  ];
  private financialPlanService = inject(FinancialPlanService);
  private financialPlanItemService = inject(FinancialPlanItemService);
  private route = inject(ActivatedRoute);
  private formBuilder = inject(FormBuilder);
  form: FormGroup | null = null;;
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.financial_plan_id = params['financial_plan_id'];
      if (this.financial_plan_id) {
        this.financialPlanService.showById(this.financial_plan_id)
          .pipe(tap((financialPlan: FinancialPlan) => {
            this.financialPlan = financialPlan;
            this.initializeForm(financialPlan);
            this.showByFinancialPlan(this.financial_plan_id);
          }))
          .subscribe();
      }
    });

    this.financialPlanItemService.message$.subscribe(message => {
      this.message = message;
    })
    this.financialPlanItemService.loading$.subscribe(loading => {
      this.loading = loading
    })
  }

  showByFinancialPlan(id: string) {
    this.financialPlanItemService.showByFinancialPlan(id)
      .pipe(tap((financialPlanItems) => {
        this.financialPlanItems = financialPlanItems.itens;
        this.sum_total = financialPlanItems.sum_total;
        this.sum_checked = financialPlanItems.sum_checked;
      }))
      .subscribe();
  }

  getUnitLabel(unit: string): string {
    const foundUnit = this.units.find(u => u.value === unit);
    return foundUnit ? foundUnit.label : unit; 
  }
  
  initializeForm(financialPlan: FinancialPlan) {
    this.form = this.formBuilder.group({
      financial_plan_id: [financialPlan.id],
      name: [''],
      amount: [''],
      qtd: [''],
      unit: [''],
      due_date: [''],
      checked: [0],
      plan_type: [financialPlan.plan_type]
    });
  }

  onSubmit() {
    this.financialPlanItemService.store(this.form?.getRawValue() as FinancialPlanItem)
      .pipe(
        tap((response) => {
          this.message = response.message;
          this.form?.patchValue({
            name: '',
            amount: '',
            qtd: '',
            unit: '',
            due_date: '',
          });
          this.showByFinancialPlan(this.financial_plan_id);
        }),
        catchError((error) => {
          if (error && error.error && error.error.errors) {
            this.backendErrors = Object.values(error.error.errors);
          } else {
            this.backendErrors = ['Ocorreu um erro inesperado.'];
          }
          return of(null);
        })
      )
      .subscribe();
  }

  saveEdit(item: FinancialPlanItem) {
    item.editing = false;
    this.form?.patchValue(item);
    this.financialPlanItemService.update(this.form?.getRawValue() as FinancialPlanItem, item.id)
      .pipe(tap(() => {
        this.form?.patchValue({
          name: '',
          unit: 'un',
          qtd: '',
          amount: '',
          due_date:''
        });

        this.showByFinancialPlan(item.financial_plan_id);
      }))
      .subscribe();
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
    this.form?.get('amount')?.setValue(formattedValue, { emitEvent: false });
  }

  quantityMask(event: Event): void {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/[^0-9.]/g, '');
    const parts = value.split('.');
    if (parts.length > 2) {
      value = parts[0] + '.' + parts.slice(1).join('');
    }
    let [integer, decimal] = value.split('.');
    integer = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  
    value = decimal !== undefined ? `${integer}.${decimal}` : integer;
    this.form?.get('qtd')?.setValue(value, { emitEvent: false });
  }

  quantityMaskEdit(item: FinancialPlanItem, event: Event): void {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/[^0-9.,]/g, ''); 
    const parts = value.split('.');
    if (parts.length > 2) {
      value = parts[0] + '.' + parts.slice(1).join('');
    }
    let [integer, decimal] = value.split('.');
    integer = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    const formattedValue = decimal !== undefined ? `${integer}.${decimal}` : integer;
    item.qtd = formattedValue;
  }
  
  currencyMaskEdit(item: FinancialPlanItem, event: Event): void {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');
    let formattedValue = '';

    if (value.length <= 2) {
      formattedValue = 'R$ 0,' + value.padStart(2, '0');
    } else {
      const integerPart = value.slice(0, -2);
      const decimalPart = value.slice(-2);
      const trimmedIntegerPart = integerPart.replace(/^0+/, '');
      formattedValue = 'R$ ' + trimmedIntegerPart.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ',' + decimalPart;
    }

    // Atualiza a propriedade amount do FinancialPlanItem diretamente
    item.amount = formattedValue;

    // Se você precisar atualizar o formulário também, pode fazer isso aqui
    // this.form?.get('amount')?.setValue(formattedValue, { emitEvent: false });
  }

  toggleCheckFinancialPlanItem(item: FinancialPlanItem, event: Event): void {
    const target = event.target as HTMLInputElement;
    item.checked = target.checked;
    this.financialPlanItemService
      .toggleCheckFinancialPlanItem(item.checked, item.id)
      .pipe(
        tap(() => {
          this.showByFinancialPlan(this.financial_plan_id);
        }),
        catchError((error) => {
          console.error('Erro ao alternar o estado do item:', error);
          item.checked = !item.checked;
          return of(null); 
        })
      )
      .subscribe();
  }

  formatAmount(amount: number | undefined): string {
    if (amount === undefined || amount === null) {
      return 'R$ 0,00'; // Valor padrão
    }

    return 'R$ ' + amount.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  delete(id: string) {
    if (confirm('Tem certeza que deseja excluir esse item?')) {
      this.financialPlanItemService.delete(id)
        .pipe(tap((response) => {
          this.showByFinancialPlan(this.financial_plan_id);
          this.message = response.message;
        }))
        .subscribe();
    }
  }
}

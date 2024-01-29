import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PaymentsComponent } from './payments.component';
import { PaymentForm } from './form/form.component';

const routes: Routes = [
  {
    path: '',
    component: PaymentsComponent,
    title: 'Formas de pagamentos'
  },
  {
    path: 'add',
    component: PaymentForm,
    title: 'Nova forma de pagamento'
  },
  {
    path: 'edit/:id',
    component: PaymentForm,
    title: 'Atualizar forma de pagamento'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PaymentsRoutingModule { }

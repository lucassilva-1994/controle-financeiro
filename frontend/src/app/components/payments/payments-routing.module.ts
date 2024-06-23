import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PaymentsComponent } from './payments.component';

const routes: Routes = [
  { 
    path: '', 
    component: PaymentsComponent,
    title: 'Formas de pagamento',
    data: {
      mode: 'view'
    }
  },
  {
    path:'new',
    component: PaymentsComponent,
    title: 'Nova forma de pagamento',
    data: {
      mode: 'new'
    }
  },
  {
    path:'edit/:id',
    component: PaymentsComponent,
    title: 'Editar forma de pagamento',
    data: {
      mode: 'edit'
    }
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PaymentsRoutingModule { }

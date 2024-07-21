import { Routes } from "@angular/router";
import { PaymentsComponent } from "./payments.component";

export const PAYMENTS_ROUTES: Routes = [
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
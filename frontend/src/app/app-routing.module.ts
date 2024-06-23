import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  { path: '', loadChildren: () => import('./components/auth/auth.module').then(m => m.AuthModule) }, 
  { path: 'payments', loadChildren: () => import('./components/payments/payments.module').then(m => m.PaymentsModule) }, 
  { path: 'categories', loadChildren: () => import('./components/categories/categories.module').then(m => m.CategoriesModule) }, 
  { path: 'suppliers-and-customers', loadChildren: () => import('./components/suppliers-and-customers/suppliers-and-customers.module').then(m => m.SuppliersAndCustomersModule) },
  { path: 'financial-records', loadChildren: () => import('./components/financial-records/financial-records.module').then(m => m.FinancialRecordsModule) }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

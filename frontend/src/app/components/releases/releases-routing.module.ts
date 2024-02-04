import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ReleasesComponent } from './releases.component';
import { ReleaseForm } from './form/form.component';
import { CategoriesResolve } from 'src/app/resolves/CategoriesResolve.resolve';
import { PaymentResolve } from 'src/app/resolves/PaymentsResolve.resolve';
import { ClientCreditorResolve } from 'src/app/resolves/ClientCreditorResolve.resolve';

const routes: Routes = [
  {
    path: '',
    component: ReleasesComponent,
    title: 'Lançamentos'
  },
  {
    path: 'add',
    component: ReleaseForm,
    title: 'Novo lançamento',
    resolve: {
      categories: CategoriesResolve,
      payments: PaymentResolve,
      clientsCreditors: ClientCreditorResolve
    }
  },
  {
    path: 'edit/:id',
    component: ReleaseForm,
    title: 'Editar lançamento'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ReleasesRoutingModule { }

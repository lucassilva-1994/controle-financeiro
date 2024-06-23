import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SuppliersAndCustomersComponent } from './suppliers-and-customers.component';

const routes: Routes = [
  { 
    path: '', 
    component: SuppliersAndCustomersComponent,
    title: 'Fornecedores/clientes',
    data: {
      mode: 'view'
    }
  },
  {
    path:'new',
    component: SuppliersAndCustomersComponent,
    title: 'Novo Fornecedor/Cliente',
    data: {
      mode: 'new'
    }
  },
  {
    path:'edit/:id',
    component: SuppliersAndCustomersComponent,
    title: 'Editar Fornecedor/Cliente',
    data: {
      mode:'edit'
    }
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SuppliersAndCustomersRoutingModule { }

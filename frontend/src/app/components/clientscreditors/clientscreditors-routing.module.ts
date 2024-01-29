import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ClientscreditorsComponent } from './clientscreditors.component';
import { ClientCreditorForm } from './form/form.component';

const routes: Routes = [
  {
    path: '',
    component: ClientscreditorsComponent,
    title: 'Fornecedores/clientes'
  },
  {
    path: 'add',
    component: ClientCreditorForm,
    title: 'Cadastrar fornecedor/cliente'
  },
  {
    path: 'edit/:id',
    component: ClientCreditorForm,
    title: 'Atualizar registro'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ClientscreditorsRoutingModule { }

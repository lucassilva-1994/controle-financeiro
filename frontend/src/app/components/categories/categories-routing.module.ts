import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CategoriesComponent } from './categories.component';
import { CategoryForm } from './form/form.component';

const routes: Routes = [
  {
    path: '',
    component: CategoriesComponent,
    title: 'Categorias'
  },
  {
    path: 'add',
    component: CategoryForm,
    title: 'Nova categoria'
  },
  {
    path: 'edit/:id',
    component: CategoryForm,
    title: 'Editar categoria'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CategoriesRoutingModule { }

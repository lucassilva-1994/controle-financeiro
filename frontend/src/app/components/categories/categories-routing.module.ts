import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CategoriesComponent } from './categories.component';

const routes: Routes = [
  { 
    path: '', 
    component: CategoriesComponent,
    title: 'Categorias',
    data: {
      mode: 'view'
    }
  },
  {
    path: 'new',
    component: CategoriesComponent,
    title: 'Nova categorias',
    data: {
      mode: 'new'
    }
  },
  {
    path: 'edit/:id',
    component: CategoriesComponent,
    title: 'Editar categoria',
    data: {
      mode: 'edit'
    }
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CategoriesRoutingModule { }

import { Routes } from "@angular/router";
import { CategoriesComponent } from "./categories.component";

export const CATEGORIES_ROUTES: Routes = [
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
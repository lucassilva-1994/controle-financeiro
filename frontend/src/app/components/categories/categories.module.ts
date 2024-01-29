import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CategoriesRoutingModule } from './categories-routing.module';
import { CategoriesComponent } from './categories.component';
import { SharedModule } from '../shared/Shared.module';
import { CategoryForm } from './form/form.component';
import { ReactiveFormsModule } from '@angular/forms';
import { PipesModule } from 'src/app/pipes/pipes.module';


@NgModule({
  declarations: [
    CategoriesComponent,
    CategoryForm
  ],
  imports: [
    CommonModule,
    CategoriesRoutingModule,
    SharedModule,
    ReactiveFormsModule,
    PipesModule
  ]
})
export class CategoriesModule { }

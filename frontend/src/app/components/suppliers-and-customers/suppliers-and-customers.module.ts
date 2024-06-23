import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SuppliersAndCustomersRoutingModule } from './suppliers-and-customers-routing.module';
import { SuppliersAndCustomersComponent } from './suppliers-and-customers.component';
import { SharedModule } from '../shared/shared.module';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    SuppliersAndCustomersComponent
  ],
  imports: [
    CommonModule,
    SuppliersAndCustomersRoutingModule,
    SharedModule,
    ReactiveFormsModule
  ]
})
export class SuppliersAndCustomersModule { }

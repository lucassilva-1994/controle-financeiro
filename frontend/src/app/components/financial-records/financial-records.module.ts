import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { FinancialRecordsRoutingModule } from './financial-records-routing.module';
import { FinancialRecordsComponent } from './financial-records.component';
import { SharedModule } from '../shared/shared.module';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    FinancialRecordsComponent
  ],
  imports: [
    CommonModule,
    FinancialRecordsRoutingModule,
    SharedModule,
    ReactiveFormsModule
  ],
})
export class FinancialRecordsModule { }

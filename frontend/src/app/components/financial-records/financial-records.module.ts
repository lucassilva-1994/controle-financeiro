import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { FinancialRecordsRoutingModule } from './financial-records-routing.module';
import { FinancialRecordsComponent } from './financial-records.component';
import { SharedModule } from '../shared/shared.module';


@NgModule({
  declarations: [
    FinancialRecordsComponent
  ],
  imports: [
    CommonModule,
    FinancialRecordsRoutingModule,
    SharedModule
  ]
})
export class FinancialRecordsModule { }

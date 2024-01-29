import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PaymentsRoutingModule } from './payments-routing.module';
import { PaymentsComponent } from './payments.component';
import { SharedModule } from '../shared/Shared.module';
import { PaymentForm } from './form/form.component';
import { ReactiveFormsModule } from '@angular/forms';
import { PipesModule } from 'src/app/pipes/pipes.module';


@NgModule({
  declarations: [
    PaymentsComponent,
    PaymentForm
  ],
  imports: [
    CommonModule,
    PaymentsRoutingModule,
    SharedModule,
    ReactiveFormsModule,
    PipesModule
  ]
})
export class PaymentsModule { }

import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ClientscreditorsRoutingModule } from './clientscreditors-routing.module';
import { ClientscreditorsComponent } from './clientscreditors.component';
import { SharedModule } from '../shared/Shared.module';
import { ClientCreditorForm } from './form/form.component';
import { ReactiveFormsModule } from '@angular/forms';
import { PipesModule } from 'src/app/pipes/pipes.module';


@NgModule({
  declarations: [
    ClientscreditorsComponent,
    ClientCreditorForm
  ],
  imports: [
    CommonModule,
    ClientscreditorsRoutingModule,
    SharedModule,
    ReactiveFormsModule,
    PipesModule
  ]
})
export class ClientscreditorsModule { }

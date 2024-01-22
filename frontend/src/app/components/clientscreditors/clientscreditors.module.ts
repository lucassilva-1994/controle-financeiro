import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ClientscreditorsRoutingModule } from './clientscreditors-routing.module';
import { ClientscreditorsComponent } from './clientscreditors.component';


@NgModule({
  declarations: [
    ClientscreditorsComponent
  ],
  imports: [
    CommonModule,
    ClientscreditorsRoutingModule
  ]
})
export class ClientscreditorsModule { }

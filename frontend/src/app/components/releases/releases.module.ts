import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ReleasesRoutingModule } from './releases-routing.module';
import { ReleasesComponent } from './releases.component';
import { SharedModule } from '../shared/Shared.module';


@NgModule({
  declarations: [
    ReleasesComponent
  ],
  imports: [
    CommonModule,
    ReleasesRoutingModule,
    SharedModule
  ]
})
export class ReleasesModule { }

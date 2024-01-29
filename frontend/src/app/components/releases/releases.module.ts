import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ReleasesRoutingModule } from './releases-routing.module';
import { ReleasesComponent } from './releases.component';
import { SharedModule } from '../shared/Shared.module';
import { PipesModule } from 'src/app/pipes/pipes.module';


@NgModule({
  declarations: [
    ReleasesComponent
  ],
  imports: [
    CommonModule,
    ReleasesRoutingModule,
    SharedModule,
    PipesModule
  ]
})
export class ReleasesModule { }

import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ReleasesRoutingModule } from './releases-routing.module';
import { ReleasesComponent } from './releases.component';
import { SharedModule } from '../shared/Shared.module';
import { PipesModule } from 'src/app/pipes/pipes.module';
import { ReleaseForm } from './form/form.component';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    ReleasesComponent,
    ReleaseForm
  ],
  imports: [
    CommonModule,
    ReleasesRoutingModule,
    SharedModule,
    PipesModule,
    ReactiveFormsModule
  ]
})
export class ReleasesModule { }

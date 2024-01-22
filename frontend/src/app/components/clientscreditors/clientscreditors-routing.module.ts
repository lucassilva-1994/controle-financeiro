import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ClientscreditorsComponent } from './clientscreditors.component';

const routes: Routes = [{ path: '', component: ClientscreditorsComponent }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ClientscreditorsRoutingModule { }

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthComponent } from './auth.component';

const routes: Routes = [
  { 
    path: '', 
    component: AuthComponent,
    title: 'Entrar',
    data: {
      authMode: 'signIn'
    }
  },
  { 
    path: 'sign-up', 
    component: AuthComponent,
    title: 'Novo usuário',
    data: {
      authMode: 'signUp'
    }
  },
  { 
    path: 'forgot-password', 
    component: AuthComponent,
    title: 'Recuperar senha',
    data: {
      authMode: 'forgotPassword'
    }
  },
  {
    path:'activate-account/:email/:token',
    component: AuthComponent,
    title:'Ativar conta',
    data:{
      authMode: 'activateAccount'
    }
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthRoutingModule { }

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  { path: 'payments', loadChildren: () => import('./components/payments/payments.module').then(m => m.PaymentsModule) },
  { path: 'categories', loadChildren: () => import('./components/categories/categories.module').then(m => m.CategoriesModule) },
  { path: 'clientscreditors', loadChildren: () => import('./components/clientscreditors/clientscreditors.module').then(m => m.ClientscreditorsModule) },
  { path: 'releases', loadChildren: () => import('./components/releases/releases.module').then(m => m.ReleasesModule) },
  { path: '', loadChildren: () => import('./components/user/signin/signin.module').then(m => m.SigninModule) },
  { path: 'signup', loadChildren: () => import('./components/user/signup/signup.module').then(m => m.SignupModule) }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

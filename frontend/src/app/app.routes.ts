import { Routes } from "@angular/router";

export const APP_ROUTES: Routes = [
    { path: '', loadChildren: () => import('./components/auth/auth.routes').then(r => r.AUTH_ROUTES) },
    { path: 'categories', loadChildren: () => import('./components/categories/categories.routes').then(r => r.CATEGORIES_ROUTES) },
    { path: 'payments', loadChildren: () => import('./components/payments/payments.routes').then(r => r.PAYMENTS_ROUTES) },
    { path: 'suppliers-and-customers', loadChildren: () => import('./components/suppliers-and-customers/suppliers-and-customers.routes').then(r => r.SUPPLIERS_AND_CUSTOMERS_ROUTES) },
    { path: 'financial-records', loadChildren: () => import('./components/financial-records/financial-records.routes').then(r => r.FINANCIAL_RECORDS_ROUTES) },
    { path: 'financial-plans', loadChildren: () => import('./components/financial-plans/financial-plans.routes').then(r => r.FINANCIAL_PLANS_ROUTES) },
    { path: 'financial-plans-items', loadChildren: () => import('./components/financial-plans-items/financial-plans-items.routes').then(r => r.FINANCIAL_PLANS_ITEMS_ROUTES) },
    { path: 'profile', title:'Seu perfil', loadComponent: () => import('./components/profile/profile.component').then(r => r.ProfileComponent) }
];
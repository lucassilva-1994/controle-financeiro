import { Routes } from '@angular/router';
import { FinancialRecordsComponent } from './financial-records.component';
import { PaymentResolver } from '../../resolvers/payment.resolver';
import { CategoryResolver } from 'src/app/resolvers/category.resolver';
import { SupplierAndCustomerResolver } from 'src/app/resolvers/supplier_and_customer.resolver';

export const FINANCIAL_RECORDS_ROUTES: Routes = [
    {
        path: '',
        component: FinancialRecordsComponent,
        title: 'Registros financeiros',
        data: {
            mode: 'view'
        }
    },
    {
        path: 'new',
        component: FinancialRecordsComponent,
        title: 'Novo registro financeiro',
        data: {
            mode: 'new'
        },
        resolve: {
            payments: PaymentResolver,
            categories: CategoryResolver,
            suppliersAndCustomers: SupplierAndCustomerResolver
        }
    },
    {
        path: 'edit/:id',
        component: FinancialRecordsComponent,
        title: 'Editar registro financeiro',
        data: {
            mode: 'edit'
        },
        resolve: {
            payments: PaymentResolver,
            categories: CategoryResolver,
            suppliersAndCustomers: SupplierAndCustomerResolver
        }
    }
];
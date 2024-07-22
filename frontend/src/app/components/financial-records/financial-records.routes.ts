import { Routes } from "@angular/router";
import { FinancialRecordsComponent } from "./financial-records.component";
import { PaymentResolver } from "../../resolvers/payment.resolver";

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
            payments: PaymentResolver
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
            payments: PaymentResolver
        }
    }
];
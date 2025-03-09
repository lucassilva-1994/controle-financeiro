import { Routes } from "@angular/router";
import { FinancialPlansComponent } from "./financial-plans.component";

export const FINANCIAL_PLANS_ROUTES: Routes = [
    {
        path: '',
        component: FinancialPlansComponent,
        title: 'Planejamentos financeiro',
        data: {
            mode: 'view'
        }
    },
    {
        path: 'new',
        component: FinancialPlansComponent,
        title: 'Novo planejamento financeiro',
        data: {
            mode: 'new'
        }
    },
    {
        path: 'edit/:id',
        component: FinancialPlansComponent,
        title: 'Editar planejamento financeiro',
        data: {
            mode: 'edit'
        }
    }
];
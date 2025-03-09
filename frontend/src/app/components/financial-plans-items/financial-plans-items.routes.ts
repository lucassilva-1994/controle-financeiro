import { Routes } from "@angular/router";
import { FinancialPlansItemsComponent } from "./financial-plans-items.component";

export const FINANCIAL_PLANS_ITEMS_ROUTES: Routes = [
    {
        path: ':financial_plan_id',
        component: FinancialPlansItemsComponent,
        title: 'Planejamentos financeiro (Itens)',
        data: {
            mode: 'view'
        }
    }
];
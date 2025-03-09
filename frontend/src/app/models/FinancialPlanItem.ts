import { Model } from "./Model";

export class FinancialPlanItem extends Model{
    financial_plan_id: string;
    plan_type: 'BUDGET' | 'SHOPPING_LIST';
    amount: number | string;
    qtd: number | string;
    unit: string;
    due_date: Date;
    checked: boolean;
    editing?: boolean;
}
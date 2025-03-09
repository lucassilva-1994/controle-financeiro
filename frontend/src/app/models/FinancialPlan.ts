import { Model } from "./Model";

export class FinancialPlan extends Model{
    plan_type:'SHOPPING_LIST' |'BUDGET';
    description: string;
}
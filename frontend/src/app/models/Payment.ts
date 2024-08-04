import { Model } from "./Model";

export class Payment extends Model{
    is_calculable: boolean;
    description: string;
    financial_records_count: number;
    financial_records_sum_amount: number;
}
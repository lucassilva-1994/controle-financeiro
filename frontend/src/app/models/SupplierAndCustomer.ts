import { Model } from "./Model";

export class SupplierAndCustomer extends Model{
    email: string;
    phone: string;
    financial_records_count: number;
    financial_records_sum_amount: number;
    description: string
}
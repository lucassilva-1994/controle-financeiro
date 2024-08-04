import { Model } from "./Model";
import { File } from './File';
import { Category } from "./Category";
import { Payment } from "./Payment";
import { SupplierAndCustomer } from "./SupplierAndCustomer";

export class FinancialRecord extends Model{
    files: File[];
    description: string;
    amount: number;
    category: Category;
    payment: Payment;
    paid: number | boolean;
    financial_record_type: string | undefined;
    supplier_and_customer: SupplierAndCustomer;
    financial_record_date: Date;
    financial_record_due_date: Date;
    installment_number: number;
    installment_total: number;
    details: string;
}
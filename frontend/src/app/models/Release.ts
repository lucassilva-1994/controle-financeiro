import { Model } from "./Model";
import { Payment } from "./Payment";
import { Category } from './Category';
import { ClientCreditor } from "./ClientCreditor";

export class Release extends Model{
    description:string;
    details: string;
    value: number;
    status: 'PENDING'|'PAID';
    date: Date;
    due_date: Date;
    type: 'INCOME' | 'EXPENSE'
    category: Category;
    payment: Payment;
    clientCreditor: ClientCreditor;
}
import { Model } from "./Model";
export class ShoppingListItem extends Model{
    checked?: boolean;
    amount?: number;
    qtd: number;
    unit: string;
    shopping_list_id: string;
    editing?: boolean;
    payment_date: Date;
}
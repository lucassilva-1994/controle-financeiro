import { Model } from "./Model";
import { User } from "./User";

export class Category extends Model{
    type: 'INCOME'| 'INCOME' | 'BOTH';
    user: User;
}
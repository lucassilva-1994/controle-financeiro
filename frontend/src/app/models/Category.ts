import { Model } from "./Model";
import { Release } from "./Release";
import { User } from "./User";

export class Category extends Model{
    type: 'INCOME'| 'INCOME' | 'BOTH';
    user: User;
    releases: Release[]
}
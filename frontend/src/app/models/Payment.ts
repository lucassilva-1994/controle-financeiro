import { Model } from "./Model";
import { User } from "./User";

export class Payment extends Model{
    calculate: 'YES'|'NO'; 
    user: User;
}
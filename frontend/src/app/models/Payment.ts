import { Model } from "./Model";
import { Release } from "./Release";
import { User } from "./User";

export class Payment extends Model{
    calculate: 'YES'|'NO'; 
    user: User;
    releases: Release[]
}
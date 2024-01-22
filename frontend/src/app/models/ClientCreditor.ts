import { Model } from "./Model";
import { User } from "./User";

export class ClientCreditor extends Model{
    type: 'CLIENT'|'CREDITOR'|'BOTH';
    user: User;
}
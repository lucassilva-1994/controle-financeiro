import { Model } from "./Model";
import { Release } from "./Release";
import { User } from "./User";

export class ClientCreditor extends Model{
    type: 'CLIENT'|'CREDITOR'|'BOTH';
    user: User;
    releases: Release[]
}
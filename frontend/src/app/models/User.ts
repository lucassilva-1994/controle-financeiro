import { Model } from "./Model";

export class User extends Model{
    email: string;
    username: string;
    photo: string;
    accesses_count: number;
    categories_count: number;
    payments_count: number;
    financial_records_count: number;
    suppliers_and_custommers_count: number;
    member_since: string;
    last_login_time: string;
    last_login_locale: string;
}

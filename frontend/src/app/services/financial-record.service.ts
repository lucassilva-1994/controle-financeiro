import { Injectable } from "@angular/core";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";
import { FinancialRecord } from "../models/FinancialRecord";
import { Observable} from "rxjs";
import { environment } from "src/environments/environment";

const apiUrl = environment.apiUrl+'/financial_records'
@Injectable({ providedIn: 'root'})
export class FinancialRecordService extends CrudService<FinancialRecord>{
    constructor(httpClient: HttpClient){
        super(httpClient,'financial_records');
    }

    calculateIncomeExpense(): Observable<{total_income: number,total_expense:number, balance: number}>{
        return this.httpClient.get<{total_income: number,total_expense:number, balance: number}>(`${apiUrl}/calculate-income-expense/`);
    }
}
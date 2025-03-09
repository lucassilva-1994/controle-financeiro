import { Injectable } from "@angular/core";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { FinancialPlanItem } from './../models/FinancialPlanItem';
import { environment } from "src/environments/environment";

const apiUrl = environment.apiUrl+'/financial_plans_items'
@Injectable({ providedIn: 'root'})
export class FinancialPlanItemService extends CrudService<FinancialPlanItem>{
    constructor(httpClient: HttpClient){
        super(httpClient,'financial_plans_items');
    }

    showByFinancialPlan(id: string):Observable<{ sum_total: number | string, sum_checked:number | string, itens: FinancialPlanItem[] }>{
        return this.httpClient.get<{ sum_total: number, sum_checked:number, itens: FinancialPlanItem[] }>(`${apiUrl}/show-by-financial-plan/${id}`);
    }

    toggleCheckFinancialPlanItem(checked: boolean, id: string): Observable<{message: string}>{
        return this.httpClient.patch<{message: string}>(`${apiUrl}/toggle-check-financial-plan-item`, {checked, id})
    }
}
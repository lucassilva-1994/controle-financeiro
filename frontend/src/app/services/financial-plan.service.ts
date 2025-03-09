import { Injectable } from "@angular/core";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";
import { FinancialPlan } from "../models/FinancialPlan";

@Injectable({ providedIn: 'root'})
export class FinancialPlanService extends CrudService<FinancialPlan>{
    constructor(httpClient: HttpClient){
        super(httpClient,'financial_plans')
    }
}
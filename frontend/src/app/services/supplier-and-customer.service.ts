import { HttpClient } from "@angular/common/http";
import { SupplierAndCustomer } from "../models/SupplierAndCustomer";
import { CrudService } from "./crud.service";
import { Injectable } from "@angular/core";

@Injectable({ providedIn: 'root'})
export class SupplierAndCustomerService extends CrudService<SupplierAndCustomer>{
    constructor(httpClient: HttpClient){
        super(httpClient,'suppliers_and_customers');
    }
}
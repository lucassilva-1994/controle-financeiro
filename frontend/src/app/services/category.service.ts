import { Injectable } from "@angular/core";
import { Category } from "../models/Category";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";

@Injectable({ providedIn: 'root'})
export class CategoryService extends CrudService<Category>{
    constructor(httpClient: HttpClient){
        super(httpClient,'categories')
    }
}
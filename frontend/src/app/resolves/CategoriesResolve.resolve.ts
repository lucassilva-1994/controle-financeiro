import { Resolve } from "@angular/router";
import { Category } from "../models/Category";
import { Observable } from "rxjs";
import { CategoryService } from "../services/CategoryService";
import { Injectable } from "@angular/core";

@Injectable({ providedIn: 'root'})
export class CategoriesResolve implements Resolve<Category[]>{
    constructor(private categoryService:CategoryService){}
    resolve(): Observable<Category[]> {
        return this.categoryService.show();
    }
}
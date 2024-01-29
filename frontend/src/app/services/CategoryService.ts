import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Category } from "../models/Category";
import { Observable } from "rxjs";
import { environment } from "src/environments/environment";

const apiUrl = environment.apiUrl + 'categories/';
@Injectable({ providedIn: 'root' })
export class CategoryService {
    constructor(private httpClient: HttpClient) { }

    show(): Observable<Category[]> {
        return this.httpClient.get<Category[]>(apiUrl);
    }

    showById(id: string): Observable<Category> {
        return this.httpClient.get<Category>(apiUrl + 'show/' + id);
    }

    create(category: Category): Observable<{ message: string }> {
        return this.httpClient.post<{ message: string }>(apiUrl + 'create', category);
    }

    update(id: string, category: Category): Observable<{ message: string }> {
        return this.httpClient.put<{ message: string }>(apiUrl + 'update/' + id, category);
    }

    delete(category: Category): Observable<{ message: string }> {
        return this.httpClient.delete<{ message: string }>(apiUrl + 'delete/' + category.id);
    }
}
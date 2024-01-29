import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { environment } from "src/environments/environment";
import { Release } from "../models/Release";

const apiUrl = environment.apiUrl + 'releases/';
@Injectable({ providedIn: 'root' })
export class ReleaseService {
    constructor(private httpClient: HttpClient) { }
    show(): Observable<Release[]> {
        return this.httpClient.get<Release[]>(apiUrl);
    }

    showById(id: string): Observable<Release> {
        return this.httpClient.get<Release>(apiUrl + 'show/' + id)
    }

    create(release: Release): Observable<{ message: string }> {
        return this.httpClient.post<{ message: string }>(apiUrl + 'create', release);
    }

    update(id: string, release: Release): Observable<{ message: string }> {
        return this.httpClient.put<{ message: string }>(apiUrl + 'update/' + id, release);
    }

    delete(id: string): Observable<{ message: string }> {
        return this.httpClient.delete<{ message: string }>(apiUrl + 'delete/' + id);
    }
}
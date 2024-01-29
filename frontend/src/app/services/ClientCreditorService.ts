import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { environment } from "src/environments/environment";
import { ClientCreditor } from "../models/ClientCreditor";

const apiUrl = environment.apiUrl + 'clientscreditors/'
@Injectable({ providedIn: 'root' })
export class ClientCreditorService {
    constructor(private httpClient: HttpClient) { }
    show(): Observable<ClientCreditor[]> {
        return this.httpClient.get<ClientCreditor[]>(apiUrl);
    }

    showById(id: string): Observable<ClientCreditor> {
        return this.httpClient.get<ClientCreditor>(apiUrl + 'show/' + id);
    }

    create(clientCreditor: ClientCreditor): Observable<{ message: string }> {
        return this.httpClient.post<{ message: string }>(apiUrl + 'create', clientCreditor);
    }

    update(id: string, clientCreditor: ClientCreditor): Observable<{ message: string }> {
        return this.httpClient.put<{ message: string }>(apiUrl + 'update/' + id, clientCreditor);
    }

    delete(id: string): Observable<{ message: string }> {
        return this.httpClient.delete<{ message: string }>(apiUrl + 'delete/' + id);
    }
}
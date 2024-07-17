import { HttpClient, HttpParams } from "@angular/common/http";
import { Inject, Injectable, InjectionToken } from "@angular/core";
import { BehaviorSubject, Observable, Subject, delay, finalize, of, take, takeUntil, tap } from "rxjs";
import { environment } from "src/environments/environment";
export const RESOURCE_URL = new InjectionToken<string>('RESOURCE_URL');
@Injectable({ providedIn: 'root' })
export class CrudService<Model> {
    private apiUrl: string;
    protected messageSubject = new BehaviorSubject<string>('');
    message$ = this.messageSubject.asObservable();
    protected destroy$ = new Subject<void>();
    private loadingSubject = new BehaviorSubject<boolean>(false);
    loading$ = this.loadingSubject.asObservable();

    constructor(protected httpClient: HttpClient, @Inject(RESOURCE_URL) resourceUrl: string) {
        this.apiUrl = `${environment.apiUrl}/${resourceUrl}`;
    }


    show(perPage: number = 10, page: number = 1, search: string = ''): Observable<{ pages: number, total: number, search: string, itens: Model[] }> {
        this.loadingSubject.next(true);
        const params = new HttpParams()
            .set('perPage', perPage)
            .set('page', page)
            .set('search', this.translate(search));
        return this.httpClient.get<{ pages: number, total: number, search: string, itens: Model[] }>(`${this.apiUrl}/show`, { params })
            .pipe(
                finalize(() => this.loadingSubject.next(false)),
                take(1)
            );
    }

    //Todos os componentes no momento de cadastrar ou atualizar vai trazer apenas os últimos registros ao invésd de todos
    recentRecords(number: number = 10): Observable<{ itens: Model[] }> {
        const params = new HttpParams()
            .set('perPage', number)
        return this.httpClient.get<{ itens: Model[] }>(`${this.apiUrl}/show`, { params });
    }

    showWithoutPagination(fields: string[], type: string = ''): Observable<Model[]> {
        let params = new HttpParams().set('fields', JSON.stringify(fields));
        if (type) {
            params = params.append('type', type);
        }
        return this.httpClient.get<Model[]>(`${this.apiUrl}/show-without-pagination`, { params })
            .pipe(take(1));
    }

    showById(id: string): Observable<Model> {
        this.loadingSubject.next(true);
        return this.httpClient.get<Model>(`${this.apiUrl}/show-by-id/${id}`)
        .pipe(
            finalize(() => this.loadingSubject.next(false)),
            take(1)
        );
    }

    store(model: Model | FormData): Observable<{ message: string }> {
        return this.httpClient.post<{ message: string }>(`${this.apiUrl}/store`, model)
            .pipe(
                take(1),
                tap(response => {
                    this.messageSubject.next(response.message);
                    of(null).pipe(
                        delay(5000),
                        takeUntil(this.destroy$)
                    ).subscribe(() => this.messageSubject.next(''));
                })
            );
    }

    update(model: Model | FormData, id: string): Observable<{ message: string }> {
        return this.httpClient.put<{ message: string }>(`${this.apiUrl}/update/${id}`, model)
            .pipe(
                take(1),
                tap(response => {
                    this.messageSubject.next(response.message);
                    of(null).pipe(
                        delay(5000),
                        takeUntil(this.destroy$)
                    ).subscribe(() => this.messageSubject.next(''));
                })
            );
    }

    delete(id: string): Observable<{ message: string }> {
        return this.httpClient.delete<{ message: string }>(`${this.apiUrl}/delete/${id}`)
            .pipe(
                take(1),
                tap(response => {
                    this.messageSubject.next(response.message);
                    of(null).pipe(
                        delay(5000),
                        takeUntil(this.destroy$)
                    ).subscribe(() => this.messageSubject.next(''));
                })

            );
    }

    translate(value: string): string | number {
        switch (value) {
            case 'ENTRADA':
                return 'INCOME';
            case 'SAÍDA':
                return 'EXPENSE';
            case 'FORNECEDOR':
                return 'SUPPLIER';
            case 'CLIENTE':
                return 'CUSTOMER';
            case 'AMBOS':
                return 'BOTH';
            case 'SIM':
                return 1;
            case 'NÃO':
                return 0;
            default:
                return String(value);
        }
    }
    ngOnDestroy(): void {
        this.destroy$.next();
        this.destroy$.complete();
    }
}

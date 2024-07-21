import { Component, EventEmitter, Input, OnDestroy, OnInit, Output } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CurrencyPipe, DatePipe, NgIf, NgFor, NgClass } from '@angular/common';
import { GenericPipe } from 'src/app/pipes/generic-pipe.pipe';
import { Subject, Subscription, debounceTime, distinctUntilChanged } from 'rxjs';
import { jsPDF } from 'jspdf';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import 'jspdf-autotable';

@Component({
    selector: 'app-table',
    templateUrl: './table.component.html',
    styleUrls: ['./table.component.css'],
    providers: [GenericPipe, DatePipe, CurrencyPipe],
    standalone: true,
    imports: [NgIf, RouterLink, ReactiveFormsModule, FormsModule, NgFor, NgClass]
})
export class TableComponent implements OnInit, OnDestroy {
  @Input() cols: { key: string, label: string, icon?: string }[] = [];
  @Input() itens: any[] = [];
  @Input() path: string = '';
  id: string = '';
  mode: string;
  @Output() deleteEvent = new EventEmitter<{ id: string }>();
  @Output() showEvent = new EventEmitter<{ perPage: number, page: number, search: string }>();
  perPage: number = 10;
  page: number = 1;
  search: string;
  private searchSubject: Subject<string> = new Subject();
  private searchSubscription: Subscription;
  @Input() pages: number;
  total: number;
  options: Number[] = [5, 10, 25, 50, 100];

  constructor(
    private router: ActivatedRoute,
    private genericPipe: GenericPipe,
    private datePipe: DatePipe,
    private currencyPipe: CurrencyPipe) {
    this.id = this.router.snapshot.params['id'];
    this.mode = this.router.snapshot.data['mode'];
  }

  ngOnInit(): void {
    this.searchSubscription = this.searchSubject.pipe(
      debounceTime(3000), // 3 segundos
      distinctUntilChanged()
    ).subscribe(search => {
      this.search = search;
      this.show();
    });
  }

  ngOnDestroy(): void {
    if (this.searchSubscription) {
      this.searchSubscription.unsubscribe();
    }
  }

  filter(): void {
    this.searchSubject.next(this.search);
  }

  show(): void {
    this.showEvent.emit({ perPage: this.perPage, page: this.page, search: this.search });
  }

  delete(id: string) {
    if (confirm('Tem certeza que deseja excluir esse item?')) {
      this.deleteEvent.emit({ id });
    }
  }

  itemValue(item: any, key: string): any {
    switch (key) {
      case 'description':
        const description = item[key] ?? '-';
        return description.length > 20 ? description.slice(0, 20) + '...' : description;
      case 'payment':
      case 'supplier_and_customer':
      case 'category':
        return item[key] ? item[key].name : 'Não informado';
      case 'is_calculable':
      case 'type':
      case 'financial_record_type':
      case 'paid':
        return this.genericPipe.transform(item[key]);
        case 'financial_record_date':
        case 'financial_record_due_date':
          return this.datePipe.transform(item[key], 'dd/MM/yyyy');
      case 'created_at':
        return this.datePipe.transform(item[key], 'dd/MM/yyyy HH:mm:ss');
      case 'updated_at':
        return item[key] ? this.datePipe.transform(item[key], 'dd/MM/yyyy HH:mm:ss') : 'Sem alteração';
      case 'email':
      case 'phone':
        return item[key] ?? '-';
      case 'financial_records_sum_amount':
      case 'amount':
        return this.currencyPipe.transform(item[key] ?? 0, 'BRL')
      default:
        return item[key];
    }
  }

  onChangePerPage(event: Event) {
    const target = event.target as HTMLSelectElement;
    this.perPage = parseInt(target.value, 10);
    this.show();
  }

  changePage(page: number) {
    if (page >= 1 && page <= this.pages) {
      this.page = page;
      this.show();
    }
  }

  //Pegando a quantidade de páginas que vem do backend e transformando em um array iniciando em 5 e finalizando na quantidade informada pelo backend
  pageNumbers(): number[] {
    const pageNumbers: number[] = [];
    const numLinksToShow = 5;
    let startPage = Math.max(1, this.page - numLinksToShow);
    let endPage = Math.min(this.pages, this.page + numLinksToShow);
    if (this.page <= numLinksToShow) {
      endPage = Math.min(numLinksToShow * 2 + 1, this.pages);
    } else if (this.page >= this.pages - numLinksToShow) {
      startPage = Math.max(this.pages - numLinksToShow * 2, 1);
    }
    for (let i = startPage; i <= endPage; i++) {
      pageNumbers.push(i);
    }
    return pageNumbers;
  }

  // exportToPDF(): void {
  //   const doc = new jsPDF({
  //     orientation: 'landscape',
  //   });
  //   const title = 'Relatório de Registros';
  //   doc.setFontSize(18);
  //   doc.text(title, 14, 22);
  //   const displayedCols = this.cols.filter(col => ['description', 'amount', 'payment','supplier_and_customer','financial_record_type'].includes(col.key));
  //   const colHeaders = displayedCols.map(col => col.label);
  //   const rowData = this.itens.map(item => 
  //     displayedCols.map(col => this.itemValue(item, col.key))
  //   );

  //   (doc as any).autoTable({
  //     head: [colHeaders],
  //     body: rowData,
  //   });

  //   doc.save('table-data.pdf');
  // }
}

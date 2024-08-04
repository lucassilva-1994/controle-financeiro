import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { catchError, of, tap } from 'rxjs';
import { HttpErrorResponse } from '@angular/common/http';
import { Category } from 'src/app/models/Category';
import { CategoryService } from 'src/app/services/category.service';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { TableComponent } from '../shared/table/table.component';
import { MessageComponent } from '../shared/message/message.component';
import { SpinnerComponent } from '../shared/spinner/spinner.component';
import { LayoutComponent } from '../shared/layout/layout.component';
import { GenericPipe } from 'src/app/pipes/generic-pipe.pipe';
import { CurrencyPipe, DatePipe } from '@angular/common';

declare var window: any;
@Component({
    selector: 'app-categories',
    templateUrl: './categories.component.html',
    styleUrls: ['./categories.component.css'],
    standalone: true,
    imports: [
      LayoutComponent, SpinnerComponent, MessageComponent, TableComponent, 
      CardFormComponent, MessagesValidatorsComponent, ReactiveFormsModule, ButtonSubmitComponent,
      GenericPipe, CurrencyPipe, DatePipe
    ]
})
export class CategoriesComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-tag' },
    { key: 'type', label: 'Tipo', icon: 'fas fa-list-alt' },
    { key: 'financial_records_count', label: 'Registros', icon: 'fas fa-database' },
    { key: 'financial_records_sum_amount', label: 'Movimentações', icon: 'fas fa-money-bill-wave' }
  ];
  actions = [
    {
      icon: 'fa fa-eye',
      class: 'btn btn-info',
      title: 'Ver detalhes',
      callback: (item: Category) => this.openModalCategoryDetails(item)
    },
  ];
  mode: string;
  form: FormGroup;
  id: string;
  message: string;
  loading: boolean;
  categories: Category[] = [];
  category: Category;
  backendErrors: string[] = [];
  pages: number;
  total: number;
  modalCategory: any;
  constructor(
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private categoryService: CategoryService) { }
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.modalCategory = this.initializeModal('categoryModal');
    this.initializeForm();
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.categoryService.message$.subscribe( message => {
      this.message = message
    })
    this.categoryService.loading$.subscribe( loading => {
      this.loading = loading
    })
    this.mode === 'view' ? this.show({ perPage: 10, page:1 , search:''}) : this.recentRecords();
  }

  initializeModal(modalId: string): any {
    return new window.bootstrap.Modal(document.getElementById(modalId));
  }

  show(event: { perPage: number, page: number, search: string }) {
    this.categoryService.show(event.perPage, event.page, event.search)
      .pipe(tap(response => {
        this.categories = response.itens;
        this.pages = response.pages;
        this.total = response.total;
      }))
      .subscribe();
  }

  showById(id: string) {
    this.categoryService.showById(id)
      .pipe(
        tap(response => {
          this.form.patchValue(response);
        })
      )
      .subscribe();
  }

  recentRecords() {
    this.categoryService.recentRecords()
      .pipe(tap(response => this.categories = response.itens))
      .subscribe();
  }

  initializeForm() {
    this.form = this.formBuilder.group({
      name: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(40)]],
      description: ['', [Validators.maxLength(100)]],
      type: ['BOTH', [Validators.required]],
    })
  }

  onSubmit() {
    const form = this.form.getRawValue() as Category;
    const handleSuccess = () => { this.mode === 'new' ? this.form.reset() : null; this.show({ perPage: 10, page:1, search:'' }); this.backendErrors = []; };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' ? this.categoryService.store(form) : this.categoryService.update(form, this.id))
          .pipe(tap(handleSuccess),catchError(handleErrors)).subscribe();
  }

  delete(event: { id: string }) {
    this.categoryService.delete(event.id)
      .pipe(
        tap(() => {
          this.show({ perPage: 10, page:1, search:''});
        })
      ).subscribe();
  }

  openModalCategoryDetails(category: Category){
    this.category = category;
    this.modalCategory.show();
  }
}

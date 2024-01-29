import { Component, OnInit } from '@angular/core';
import { Observable, take } from 'rxjs';
import { Category } from 'src/app/models/Category';
import { CategoryService } from 'src/app/services/CategoryService';

@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.css']
})
export class CategoriesComponent implements OnInit {
  title: string = 'Categorias';
  categories$: Observable<Category[]>;
  message: string;
  class: string;
  constructor(private categoryService: CategoryService) { }
  ngOnInit(): void {
    this.show();
  }

  show() {
    this.categories$ = this.categoryService.show();
  }

  delete(category: Category) {
    this.categoryService.delete(category)
      .pipe(take(1))
      .subscribe({
        next: (response) => {
          this.message = response.message;
          this.class = 'success';
          this.show();
        },
        error: (error) => {
          this.message = error.message;
          this.class = 'danger';
        }
      }
      );
  }
}

import { ActivatedRouteSnapshot, Resolve, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';
import { Category } from '../models/Category';
import { CategoryService } from './../services/category.service';

@Injectable({ providedIn: 'root' })
export class CategoryResolver implements Resolve<Category[]> {
  constructor(private categoryService: CategoryService) { }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<Category[]> {
      return this.categoryService.showWithoutPagination(['id', 'name']);
  }
}

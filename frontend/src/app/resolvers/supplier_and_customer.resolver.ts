import { ActivatedRouteSnapshot, Resolve, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';
import { SupplierAndCustomerService } from '../services/supplier-and-customer.service';
import { SupplierAndCustomer } from '../models/SupplierAndCustomer';

@Injectable({ providedIn: 'root' })
export class SupplierAndCustomerResolver implements Resolve<SupplierAndCustomer[]> {
  constructor(private supplierAndCustomerService: SupplierAndCustomerService) { }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<SupplierAndCustomer[]> {
      return this.supplierAndCustomerService.showWithoutPagination(['id', 'name']);
  }
}

import { Routes } from "@angular/router";
import { SuppliersAndCustomersComponent } from "./suppliers-and-customers.component";

export const SUPPLIERS_AND_CUSTOMERS_ROUTES: Routes = [
    {
        path: '',
        component: SuppliersAndCustomersComponent,
        title: 'Fornecedores/clientes',
        data: {
            mode: 'view'
        }
    },
    {
        path: 'new',
        component: SuppliersAndCustomersComponent,
        title: 'Novo Fornecedor/Cliente',
        data: {
            mode: 'new'
        }
    },
    {
        path: 'edit/:id',
        component: SuppliersAndCustomersComponent,
        title: 'Editar Fornecedor/Cliente',
        data: {
            mode: 'edit'
        }
    }
];
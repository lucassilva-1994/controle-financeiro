import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup } from "@angular/forms";
import { ActivatedRoute } from "@angular/router";
import { take } from "rxjs";
import { Category } from "src/app/models/Category";
import { ClientCreditor } from "src/app/models/ClientCreditor";
import { Payment } from "src/app/models/Payment";
import { Release } from "src/app/models/Release";
import { ReleaseService } from "src/app/services/ReleaseService";
import { CategoryService } from './../../../services/CategoryService';
import { PaymentService } from "src/app/services/PaymentService";
import { ClientCreditorService } from "src/app/services/ClientCreditorService";

@Component({
    templateUrl:'./form.component.html'
})
export class ReleaseForm implements OnInit{
    title: string;
    message: string;
    class: string;
    id: string;
    form: FormGroup;
    categories: Category[];
    payments: Payment[];
    clientsCreditors:ClientCreditor[];
    constructor(
        private formBuilder: FormBuilder,
        private releaseService:ReleaseService,
        private categoryService: CategoryService,
        private paymentService:PaymentService,
        private clientCreditor: ClientCreditorService,
        private route: ActivatedRoute){}
    ngOnInit(): void {
        this.categories = this.route.snapshot.data['categories'];
        this.payments = this.route.snapshot.data['payments'];
        this.clientsCreditors = this.route.snapshot.data['clientsCreditors'];
        this.form = this.formBuilder.group({
            description:[null],
            value:[null],
            category_id:[this.getcategories()],
            payment_id:[this.getPayments()],
            client_creditor_id:[this.getClientsCreditors()],
            date:[null],
            due_date:[null],
            status:['PAID'],
            type:['INCOME']
        });
        this.id = this.route.snapshot.params['id'];
        if(this.id){
            this.releaseService.showById(this.id).pipe(take(1))
            .subscribe({
                next: response => {
                    this.form.patchValue(response);
                }
            });
        }
    }

    getcategories(){
        this.categoryService.show()
        .pipe(take(1))
        .subscribe(categories => {
            this.categories = categories
        });
    }

    getPayments(){
        this.paymentService.show()
        .pipe(take(1))
        .subscribe(payments => {
            this.payments = payments
        })
    }

    getClientsCreditors(){
        this.clientCreditor.show()
        .pipe(take(1))
        .subscribe(clientsCeditors => {
            this.clientsCreditors = clientsCeditors;
        });
    }

    create(){
        this.releaseService.create(this.form.getRawValue() as Release)
        .pipe(take(1))
        .subscribe({
            next: (response) => {
                this.message = response.message;
                this.form.reset();
            },
            error: (error) => {
                console.log(error)
            }
        });
    }
    update(id: string){
        this.releaseService.update(id, this.form.getRawValue() as Release)
        .pipe(take(1))
        .subscribe({
            next: (response) => {
                this.message = response.message;
            },
            error: (error) => {
                console.log(error);
            }
        })
    }
}
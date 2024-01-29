import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup } from "@angular/forms";
import { ActivatedRoute } from "@angular/router";
import { take } from "rxjs";
import { Payment } from "src/app/models/Payment";
import { PaymentService } from "src/app/services/PaymentService";

@Component({
    templateUrl: './form.component.html'
})
export class PaymentForm implements OnInit {
    form: FormGroup;
    title: string = 'Novo/atualizar forma de pagamento';
    message: string;
    class: string;
    id: string;
    constructor(
        private paymentService: PaymentService,
        private formBuilder: FormBuilder,
        private router: ActivatedRoute) { }
    ngOnInit(): void {
        this.form = this.formBuilder.group({
            name: [''],
            calculate: ['YES']
        })
        this.id = this.router.snapshot.params['id'];
        if (this.id) {
            this.paymentService.showById(this.id).pipe(take(1))
                .subscribe({
                    next: (response) => {
                        this.form.patchValue(response);
                    }
                })
        }
    }

    create() {
        this.paymentService.create(this.form.getRawValue() as Payment)
            .pipe(take(1))
            .subscribe({
                next: (response) => {
                    this.message = response.message;
                    this.class = 'success';
                    this.form.reset();
                },
                error: (error) => {
                    this.message = error.message;
                    this.class = 'danger';
                }
            });
    }

    update(id: string) {
        this.paymentService.update(this.form.getRawValue() as Payment, id)
            .pipe(take(1))
            .subscribe({
                next: (response) => {
                    this.message = response.message,
                        this.class = 'success';
                },
                error: (error) => {
                    this.message = error.message;
                    this.class = 'danger';
                }
            });
    }

}
import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup } from "@angular/forms";
import { ActivatedRoute } from "@angular/router";
import { take } from "rxjs";
import { ClientCreditor } from "src/app/models/ClientCreditor";
import { ClientCreditorService } from "src/app/services/ClientCreditorService";

@Component({
    templateUrl: './form.component.html'
})
export class ClientCreditorForm implements OnInit {
    form: FormGroup;
    title: string = 'Cadastrar/atualizar registro';
    message: string;
    class: string;
    id: string;
    constructor(
        private clientCreditorService: ClientCreditorService,
        private formBuilder: FormBuilder,
        private router: ActivatedRoute) { }
    ngOnInit(): void {
        this.form = this.formBuilder.group({
            name: [],
            type: ['CLIENT']
        })
        this.id = this.router.snapshot.params['id'];
        if (this.id) {
            this.clientCreditorService.showById(this.id)
                .pipe(take(1))
                .subscribe({
                    next: (response) => {
                        this.form.patchValue(response);
                    }
                })
        }
    }

    create() {
        this.clientCreditorService.create(this.form.getRawValue() as ClientCreditor)
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
            })
    }

    update(id: string) {
        this.clientCreditorService.update(id, this.form.getRawValue() as ClientCreditor)
            .pipe(take(1))
            .subscribe({
                next: (response) => {
                    this.message = response.message;
                    this.class = 'success';
                },
                error: (error) => {
                    this.message = error.message;
                    this.class = 'danger';
                }
            })
    }
}
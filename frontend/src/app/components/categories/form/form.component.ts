import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup } from "@angular/forms";
import { ActivatedRoute } from "@angular/router";
import { Category } from "src/app/models/Category";
import { CategoryService } from "src/app/services/CategoryService";

@Component({
    selector: 'app-form-category',
    templateUrl: './form.component.html'
})
export class CategoryForm implements OnInit {
    form: FormGroup;
    message: string;
    class: string;
    id: string;
    title: string = 'Novo/atualizar categoria';
    constructor(
        private formBuilder: FormBuilder,
        private categoryService: CategoryService,
        private router: ActivatedRoute) { }
    ngOnInit(): void {
        this.form = this.formBuilder.group({
            name: [],
            type: ['INCOME']
        });
        this.id = this.router.snapshot.params['id'];
        if (this.id) {
            this.categoryService.showById(this.id).subscribe({
                next: (response) => {
                    this.form.patchValue(response);
                }
            });
        }
    }

    create() {
        this.categoryService.create(this.form.getRawValue() as Category).subscribe({
            next: (response) => {
                this.message = response.message;
                this.class = 'success';
                this.form.reset();
            },
            error: (error) => {
                this.message = error;
            }
        });
    }

    update(id: string) {
        this.categoryService.update(id, this.form.getRawValue() as Category)
            .subscribe({
                next: (response) => {
                    this.message = response.message;
                    this.class = 'success';
                },
                error: (error) => {
                    this.message = error.message;
                },
            })
    }

}
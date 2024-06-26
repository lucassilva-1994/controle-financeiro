import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { RouterLink } from "@angular/router";
import { TableComponent } from './table/table.component';
import { SpinnerComponent } from './spinner/spinner.component';
import { MessageComponent } from "./message/message.component";
import { MessagesValidatorsComponent } from './messages-validators/messages-validators.component';
import { LayoutComponent } from './layout/layout.component';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { CardFormComponent } from './card-form/card-form.component';
import { ButtonSubmitComponent } from './button-submit/button-submit.component';


@NgModule({
    declarations: [
        TableComponent,
        SpinnerComponent,
        MessageComponent,
        MessagesValidatorsComponent,
        LayoutComponent,
        CardFormComponent,
        ButtonSubmitComponent
    ], 
    imports: [
        CommonModule,
        RouterLink,
        ReactiveFormsModule,
        FormsModule
    ],
    exports: [
        TableComponent,
        SpinnerComponent,
        MessageComponent,
        MessagesValidatorsComponent,
        LayoutComponent,
        CardFormComponent,
        ButtonSubmitComponent
    ]
})
export class SharedModule{}
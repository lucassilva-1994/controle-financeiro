import { NgModule } from "@angular/core";
import { HeaderComponent } from "./header/header.component";
import { CommonModule } from "@angular/common";
import { LayoutComponent } from './layout/layout.component';
import { RouterModule } from "@angular/router";
import { MessageComponent } from "./message/message.component";

@NgModule({
    declarations: [
        HeaderComponent,
        LayoutComponent,
        MessageComponent
    ],
    imports: [
        CommonModule,
        RouterModule
    ],
    exports: [
        HeaderComponent,
        LayoutComponent,
        MessageComponent
    ]
})
export class SharedModule { }
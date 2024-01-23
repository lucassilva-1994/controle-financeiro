import { NgModule } from "@angular/core";
import { HeaderComponent } from "./header/header.component";
import { CommonModule } from "@angular/common";
import { LayoutComponent } from './layout/layout.component';
import { RouterModule } from "@angular/router";

@NgModule({
    declarations:[
        HeaderComponent,
        LayoutComponent
    ],
    imports:[
        CommonModule,
        RouterModule
    ],
    exports:[
        HeaderComponent,
        LayoutComponent
    ]
})  
export class SharedModule{}
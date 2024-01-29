import { Component, Input, OnInit } from "@angular/core";

@Component({
    selector: 'app-message',
    templateUrl: './message.component.html'
})
export class MessageComponent implements OnInit {
    @Input() message: string | null;
    @Input() class: string;

    ngOnInit(): void {
        setTimeout(() => {
            this.message = null;
        }, 5000);
    }
}
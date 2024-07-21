import { Component, Input, OnInit } from '@angular/core';
import { NgIf, NgClass } from '@angular/common';

@Component({
    selector: 'app-message',
    templateUrl: './message.component.html',
    standalone: true,
    imports: [NgIf, NgClass]
})
export class MessageComponent implements OnInit{
    @Input() message: string | undefined;
    @Input() errorOccurred: boolean = false;

    ngOnInit(): void {}
}

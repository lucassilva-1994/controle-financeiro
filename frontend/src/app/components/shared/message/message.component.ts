import { Component, Input, OnInit } from '@angular/core';
import { NgClass } from '@angular/common';

@Component({
    selector: 'app-message',
    templateUrl: './message.component.html',
    standalone: true,
    imports: [NgClass]
})
export class MessageComponent implements OnInit{
    @Input() message: string | undefined;
    @Input() errorOccurred: boolean = false;

    ngOnInit(): void {}
}

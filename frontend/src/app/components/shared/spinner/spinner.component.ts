import { Component, Input } from '@angular/core';
import { NgIf } from '@angular/common';

@Component({
    selector: 'app-spinner',
    templateUrl: './spinner.component.html',
    styleUrls: ['./spinner.component.css'],
    standalone: true,
    imports: [NgIf]
})
export class SpinnerComponent {
  @Input() loading: Boolean = false;
}

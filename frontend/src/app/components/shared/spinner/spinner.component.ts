import { Component, Input } from '@angular/core';


@Component({
    selector: 'app-spinner',
    templateUrl: './spinner.component.html',
    styleUrls: ['./spinner.component.css'],
    standalone: true,
    imports: []
})
export class SpinnerComponent {
  @Input() loading: Boolean = false;
}

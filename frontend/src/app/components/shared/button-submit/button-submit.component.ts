import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-button-submit',
  templateUrl: './button-submit.component.html',
  styleUrls: ['./button-submit.component.css']
})
export class ButtonSubmitComponent {
    mode: string;
    constructor(private route: ActivatedRoute){
      this.mode = this.route.snapshot.data['mode'];
    }
}

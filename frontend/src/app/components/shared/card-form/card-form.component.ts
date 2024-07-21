import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
    selector: 'app-card-form',
    templateUrl: './card-form.component.html',
    styleUrls: ['./card-form.component.css'],
    standalone: true
})
export class CardFormComponent{
  mode: string;
  constructor(private route:ActivatedRoute){
      this.mode = this.route.snapshot.data['mode'];
  }
}

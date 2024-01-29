import { Component, OnInit } from '@angular/core';
import { Observable, take } from 'rxjs';
import { Release } from 'src/app/models/Release';
import { ReleaseService } from './../../services/ReleaseService';

@Component({
  selector: 'app-releases',
  templateUrl: './releases.component.html',
  styleUrls: ['./releases.component.css']
})
export class ReleasesComponent implements OnInit {
  title: string = 'Lançamentos';
  message: string;
  class: string;
  releases$: Observable<Release[]>;
  constructor(private releaseService: ReleaseService) { }
  ngOnInit(): void {
    this.show();
  }

  show() {
    this.releases$ = this.releaseService.show();
  }

  delete(id: string) {
    this.releaseService.delete(id)
    .pipe(take(1))
    .subscribe({
      next:(response) => {
        this.message = response.message;
        this.class = 'success';
        this.show();
      },
      error:(error) => {
        this.message = error.message;
        this.class = 'danger';
      }
    })
  }
}

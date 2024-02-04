import { Component, OnInit } from '@angular/core';
import { Observable, take, tap } from 'rxjs';
import { Release } from 'src/app/models/Release';
import { ReleaseService } from './../../services/ReleaseService';

@Component({
  templateUrl: './releases.component.html'
})
export class ReleasesComponent implements OnInit {
  title: string = 'Lançamentos';
  message: string;
  class: string;
  releases$: Observable<Release[]>;
  loading:boolean = true;
  constructor(private releaseService: ReleaseService) { }
  ngOnInit(): void {
    this.show();
  }

  show() {
    this.releases$ = this.releaseService.show()
    .pipe((tap({
      complete:() => {
        this.loading = false;
      }
    })));
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
    });
  }
}

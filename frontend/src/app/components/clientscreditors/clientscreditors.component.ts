import { Component, OnInit } from '@angular/core';
import { Observable, take } from 'rxjs';
import { ClientCreditor } from 'src/app/models/ClientCreditor';
import { ClientCreditorService } from './../../services/ClientCreditorService';

@Component({
  selector: 'app-clientscreditors',
  templateUrl: './clientscreditors.component.html',
  styleUrls: ['./clientscreditors.component.css']
})
export class ClientscreditorsComponent implements OnInit {
  title: string = 'Fornecedor/cliente';
  message: string;
  class: string;
  clientscreditors$: Observable<ClientCreditor[]>;
  constructor(
    private clientCreditorService: ClientCreditorService,
  ) { }
  ngOnInit(): void {
    this.show();
  }
  show() {
    this.clientscreditors$ = this.clientCreditorService.show();
  }

  delete(id: string) {
    this.clientCreditorService.delete(id).pipe(take(1))
      .subscribe({
        next: (response) => {
          this.message = response.message;
          this.class = 'success';
          this.show();
        },
        error: (error) => {
          this.message = error.message;
          this.class = 'danger';
        }
      })
  }
}

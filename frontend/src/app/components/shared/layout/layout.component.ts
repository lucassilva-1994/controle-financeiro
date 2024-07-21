import { Component, Input } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from 'src/app/models/User';
import { UserService } from 'src/app/services/user.service';
import { NgIf, AsyncPipe } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
    selector: 'app-layout',
    templateUrl: './layout.component.html',
    styleUrls: ['./layout.component.css'],
    standalone: true,
    imports: [RouterLink, NgIf, AsyncPipe]
})
export class LayoutComponent{
    user$: Observable<User | null>;
    @Input() title: string = 'Registros financeiro';
    constructor(private userService: UserService){
      this.user$ = this.userService.getUser();
    }

    signOut(){
      this.userService.signOut();
    }
}

import { Component, Input } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from 'src/app/models/User';
import { TokenService } from 'src/app/services/token.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.css']
})
export class LayoutComponent{
    user$: Observable<User | null>;
    @Input() title: string = 'Money Manager';
    constructor(private userService: UserService, private tokenService: TokenService){
      this.user$ = this.userService.getUser();
    }

    logout(){
      this.userService.logout();
    }
}

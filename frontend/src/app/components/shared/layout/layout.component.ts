import { Component, Input } from '@angular/core';
import { User } from 'src/app/models/User';
import { UserService } from 'src/app/services/user.service';

import { RouterLink } from '@angular/router';

@Component({
    selector: 'app-layout',
    templateUrl: './layout.component.html',
    styleUrls: ['./layout.component.css'],
    standalone: true,
    imports: [RouterLink]
})
export class LayoutComponent{
    user: User| null = null;
    @Input() title: string = 'Registros financeiro';
    constructor(private userService: UserService){
      this.user = this.userService.getUser()();
    }
    
    signOut(){
      this.userService.signOut();
    }
}

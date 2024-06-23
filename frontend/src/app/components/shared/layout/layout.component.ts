import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { User } from 'src/app/models/User';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.css']
})
export class LayoutComponent implements OnInit{
    user$: Observable<User | null>;
    @Input() title: string = 'Money Manager';
    constructor(private userService: UserService, private router: Router){}
    ngOnInit(): void {
      this.user$ = this.userService.getUser();
    }

    logout(){
      this.userService.logout();
      this.router.navigate(['/']);
    }
}

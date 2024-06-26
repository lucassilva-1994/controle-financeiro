import { DatePipe } from '@angular/common';
import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { User } from 'src/app/models/User';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.css'],
  providers: [DatePipe]
})
export class LayoutComponent implements OnInit{
    currentDate: string | null;
    user$: Observable<User | null>;
    @Input() title: string = 'Money Manager';
    constructor(private userService: UserService, private router: Router, private datePipe: DatePipe){
    }
    ngOnInit(): void {
      this.user$ = this.userService.getUser();
      this.currentDate = this.datePipe.transform(new Date(),'dd/MM/yyyy');
    }

    logout(){
      this.userService.logout();
      this.router.navigate(['/']);
    }
}

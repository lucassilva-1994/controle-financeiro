import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { take } from 'rxjs';
import { UserService } from 'src/app/services/UserService';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
  form: FormGroup;
  message:string;
  constructor(private formBuilder: FormBuilder, private userService: UserService) { }
  ngOnInit(): void {
    this.form = this.formBuilder.group({
      email: [''],
      password: ['']
    });
  }

  auth() {
    this.userService.auth(this.form.getRawValue())
      .pipe(take(1))
      .subscribe((response) => {
        this.form.reset();
      }, (error) => {
        this.message = 'Falha no processo de autenticação.'; 
      });
  }
}

import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { take } from 'rxjs';
import { UserService } from 'src/app/services/UserService';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
  form: FormGroup;
  message: string;
  errors=[];
  constructor(private formbuilder:FormBuilder, private userService:UserService){}
  ngOnInit(): void {
      this.form = this.formbuilder.group({
        name:[''],
        email:[''],
        username:[''],
        password:['']
      });
  }

  create(){
      this.userService.create(this.form.getRawValue())
      .pipe(take(1))
      .subscribe((response)=> {
        const res = JSON.parse(JSON.stringify(response));
        this.message = res.message;
        this.errors = [];
        this.form.reset();
      },(error)=>{
        this.errors = Object.values(error.error.errors)
      });
  }
}

import { Component, OnInit } from '@angular/core';
import { FinancialRecordService } from 'src/app/services/financial-record.service';
import { Payment } from 'src/app/models/Payment';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-financial-records',
  templateUrl: './financial-records.component.html',
  styleUrls: ['./financial-records.component.css']
})
export class FinancialRecordsComponent implements OnInit{
  total_income: number;
  total_expense: number;
  balance: number;
  message: string;
  payments: Payment[] = [];
  constructor(private financialRecordService: FinancialRecordService, private route: ActivatedRoute){
  }
  ngOnInit(): void {
    this.route.data.subscribe(data => {
      console.log(data['payments'])
    });
    this.financialRecordService.message$.subscribe( message => {
      this.message = message
    })
    this.financialRecordService.calculateIncomeExpense().subscribe(response => {
      this.total_income = response.total_income 
      this.total_expense = response.total_expense
      this.balance = response.balance
    });
  }
}

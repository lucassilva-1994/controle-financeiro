import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { AppComponent } from './app.component';
import { TokenInterceptorInterceptor } from './core/Token-interceptor.interceptor';
import { ReactiveFormsModule } from '@angular/forms';
import { CategoriesModule } from './components/categories/categories.module';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  exports: [
    HttpClientModule
  ],
  providers: [{
    provide: HTTP_INTERCEPTORS,
    useClass: TokenInterceptorInterceptor,
    multi: true
  }],
  bootstrap: [AppComponent]
})
export class AppModule { }

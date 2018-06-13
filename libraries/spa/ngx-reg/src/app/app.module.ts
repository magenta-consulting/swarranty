import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { RegistrationComponent } from './registration/registration.component';
import { AppRoutingModule } from './app-routing.module';

import { NgSelectModule } from '@ng-select/ng-select';
import {FormsModule} from "@angular/forms";
import { AngularFontAwesomeModule } from 'angular-font-awesome';

import { BsDatepickerModule } from 'ngx-bootstrap/datepicker';
import { ModalModule } from 'ngx-bootstrap/modal';

import {HttpClientModule} from "@angular/common/http";

@NgModule({
  declarations: [
    AppComponent,
    RegistrationComponent
  ],
  imports: [
    BrowserModule,
    NgSelectModule,
    FormsModule,
    HttpClientModule,
    AngularFontAwesomeModule,

    BsDatepickerModule.forRoot(),
    ModalModule.forRoot(),

    AppRoutingModule

  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }

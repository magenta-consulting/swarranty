import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';

import { NgSelectModule } from '@ng-select/ng-select';
import {FormsModule} from "@angular/forms";
import { AngularFontAwesomeModule } from 'angular-font-awesome';

import { BsDatepickerModule } from 'ngx-bootstrap/datepicker';
import { ModalModule } from 'ngx-bootstrap/modal';

import {HttpClientModule} from "@angular/common/http";
import { FocusDirective } from './directive/focus.directive';

// import components
import {TechniciansComponent} from './components/technicians/technicians.component';
import {TechnicianComponent} from './components/technician/technician.component';
import { LoginComponent } from './components/login/login.component';

// import libs
import { ImageUploadModule } from "./extensions/angular2-image-upload";


@NgModule({
  declarations: [
    AppComponent,
    FocusDirective,
    TechniciansComponent,
    TechnicianComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    NgSelectModule,
    FormsModule,
    HttpClientModule,
    AngularFontAwesomeModule,

    BsDatepickerModule.forRoot(),
    ModalModule.forRoot(),

    AppRoutingModule,

    // import libs
    ImageUploadModule.forRoot(),

  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }

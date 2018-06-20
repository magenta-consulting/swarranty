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
import { FocusDirective } from './directive/focus.directive';

// import components
import {UploadsComponent} from "./components/uploads/uploads.component";
import {SendEmailComponent} from "./components/send-email/send-email.component";
import {SuccessComponent} from "./components/success/success.component";

// import services
import { AuthGuard } from './service/auth-guard.service';

@NgModule({
  declarations: [
    AppComponent,
    RegistrationComponent,
    FocusDirective,
    UploadsComponent,
    SendEmailComponent,
    SuccessComponent
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
  providers: [AuthGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }

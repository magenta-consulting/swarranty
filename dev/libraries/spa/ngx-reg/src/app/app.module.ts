import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';

import { NgSelectModule } from '@ng-select/ng-select';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import { AngularFontAwesomeModule } from 'angular-font-awesome';

import { BsDatepickerModule } from 'ngx-bootstrap/datepicker';
import { ModalModule } from 'ngx-bootstrap/modal';

import {HttpClientModule} from "@angular/common/http";
import { FocusDirective } from './directive/focus.directive';

// import components
import {RegistrationComponent} from './components/registration/registration.component';
import {UploadsComponent} from "./components/uploads/uploads.component";
import {SendEmailComponent} from "./components/send-email/send-email.component";
import {SuccessComponent} from "./components/success/success.component";

// import services
import { AuthGuard } from './service/auth-guard.service';
import { Ng2CompleterModule } from "ng2-completer";

// import libs
import { ImageUploadModule } from "./extensions/angular2-image-upload";
import {Helper} from "./helper/helper";
import { AgmCoreModule } from '@agm/core';
import { SurveyComponent } from './components/survey/survey.component';

@NgModule({
  declarations: [
    AppComponent,
    RegistrationComponent,
    FocusDirective,
    UploadsComponent,
    SendEmailComponent,
    SuccessComponent,
    SurveyComponent
  ],
  imports: [
    BrowserModule,
    NgSelectModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    AngularFontAwesomeModule,

    BsDatepickerModule.forRoot(),
    ModalModule.forRoot(),

    // import libs
    ImageUploadModule.forRoot(),
    AgmCoreModule.forRoot({
      apiKey: "AIzaSyAN6XsSJRAUI4Iuj0Q3OdziE1D0Sou_b_c",
      libraries: ["places"]
    }),
    Ng2CompleterModule,

    AppRoutingModule

  ],
  providers: [AuthGuard, Helper],
  bootstrap: [AppComponent]
})
export class AppModule { }

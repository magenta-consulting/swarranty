import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';

// import component
import {RegistrationComponent} from "./components/registration/registration.component";
import {UploadsComponent} from "./components/uploads/uploads.component";
import {SendEmailComponent} from "./components/send-email/send-email.component";
import {SuccessComponent} from "./components/success/success.component";
import {AppComponent} from './app.component';

// import services
import { AuthGuard } from './service/auth-guard.service';
import { SurveyComponent } from './components/survey/survey.component';

const routes: Routes = [
    { path: '', component: RegistrationComponent, canActivate: [ AuthGuard ] },
    { path: 'survey', component: SurveyComponent },
    { path: 'upload-receipt-image/:id', component: UploadsComponent },
    { path: 'send-email/:id', component: SendEmailComponent },
    { path: 'success/:id', component: SuccessComponent },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
    declarations: []
})
export class AppRoutingModule {

}

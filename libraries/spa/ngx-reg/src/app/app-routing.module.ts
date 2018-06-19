import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {RegistrationComponent} from "./registration/registration.component";
import {UploadsComponent} from "./components/uploads/uploads.component";
import {SendEmailComponent} from "./components/send-email/send-email.component";
import {SuccessComponent} from "./components/success/success.component";

const routes: Routes = [
    { path: '', redirectTo: '/registration', pathMatch: 'full' },
    { path: 'registration', component: RegistrationComponent },
    { path: 'upload-receipt-image/:id', component: UploadsComponent },
    { path: 'send-email/:id', component: SendEmailComponent },
    { path: 'success', component: SuccessComponent },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
    declarations: []
})
export class AppRoutingModule {

}

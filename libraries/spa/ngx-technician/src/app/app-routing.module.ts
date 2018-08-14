import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';

// import component
import {AppComponent} from './app.component';
import {TechniciansComponent} from './components/technicians/technicians.component';
import {TechnicianComponent} from './components/technician/technician.component';
import {LoginComponent} from './components/login/login.component';

// import guard
import {AuthenticationGuard} from './authentication.guard';

const routes: Routes = [
    { path: '', component:  TechniciansComponent, canActivate: [AuthenticationGuard]},
    { path: ':id', component:  TechnicianComponent, canActivate: [AuthenticationGuard]},
    { path: 'login', component:  LoginComponent},
    { path: '**', redirectTo: '' },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
    declarations: []
})
export class AppRoutingModule {

}

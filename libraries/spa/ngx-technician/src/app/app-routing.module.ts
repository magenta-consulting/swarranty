import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';

// import component
import {AppComponent} from './app.component';
import {TechniciansComponent} from './components/technicians/technicians.component';
import {TechnicianComponent} from './components/technician/technician.component';

const routes: Routes = [
    { path: '', redirectTo: 'technicians', pathMatch: 'full' },
    { path: 'technicians', component:  TechniciansComponent},
    { path: 'technician/:id', component:  TechnicianComponent},
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
    declarations: []
})
export class AppRoutingModule {

}

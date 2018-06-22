import {Component, ElementRef} from '@angular/core';
import {OrganisationService} from "./service/organisation.service";
import { Router }    from '@angular/router';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent {
    title = 'app';
    data = ['item 1', 'item 2', 'item 3'];
    logoSrc = null;

    constructor(private eRef: ElementRef, 
        private organisationService: OrganisationService,
        public router: Router) {
        const native = eRef.nativeElement;
        const orgId = native.getAttribute('organisation');
        localStorage.setItem('orgId', orgId);
        organisationService.getLogo().subscribe(logoSrc => this.logoSrc = logoSrc);
    }

    addData(): void {
        this.data.push('new data');
    }
}

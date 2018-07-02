import {Component, ElementRef} from '@angular/core';
import { Router }    from '@angular/router';
import { OrganisationService } from './service/organisation.service';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent {
    logoSrc = null;

    constructor(
        private eRef: ElementRef,
        private organisationService: OrganisationService,
        public router: Router
    ) {
        const native = eRef.nativeElement;
        const orgId = native.getAttribute('organisation');
        localStorage.setItem('orgId', orgId);
        organisationService.getLogo().subscribe(logoSrc => this.logoSrc = logoSrc);
    }
}

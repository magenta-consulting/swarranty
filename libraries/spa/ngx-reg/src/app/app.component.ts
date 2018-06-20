import {Component, ElementRef} from '@angular/core';
import {OrganisationService} from "./service/organisation.service";
import { Router }    from '@angular/router';

import {ProductService} from "./service/product.service";

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
        private productService: ProductService,
        public router: Router) {
        const native = eRef.nativeElement;
        const orgId = native.getAttribute('organisation');
        localStorage.setItem('orgId', orgId);
        organisationService.getLogo().subscribe(logoSrc => this.logoSrc = logoSrc);
        // create regId sample
        localStorage.setItem('regId', '1');

        // 1.
        // this.getDataRegistration();
    }

    addData(): void {
        this.data.push('new data');
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Registration
    getDataRegistration() {
        // let regId = this.router.snapshot.params['id'];
        if(localStorage.getItem('regId')) {
            let regId = parseInt(localStorage.getItem('regId'));
    
            this.productService.getApiRegistration(regId).subscribe(res => {
                // this.dataRegistration = res;
                if(res.submitted == false) {
                    this.router.navigate(['upload-receipt-image/', parseInt(localStorage.getItem('regId'))]);
                } else {
                    if(res && res.customer.email) {
                        this.router.navigate(['send-email/', parseInt(localStorage.getItem('regId'))]);
                    } else {
                        this.router.navigate(['success']);
                    }
                }
            });
        } 
    }

}

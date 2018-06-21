import {Injectable} from '@angular/core';
import {Router, CanActivate} from '@angular/router';

import {ProductService} from "./product.service";
import {RegistrationService} from "./registration.service";
import {Registration} from "../model/registration";
import {Customer} from "../model/customer";

@Injectable()
export class AuthGuard implements CanActivate {

    dataRegistration: any = "";

    constructor(public router: Router,
                private productService: ProductService,
                private registrationService: RegistrationService
    ) {

    }


    canActivate() {
        // 1.
        this.getDataRegistration();

        return true;
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Registration
    getDataRegistration() {
        // let regId = this.router.snapshot.params['id'];
        if (localStorage.getItem('regId')) {
            let regId = localStorage.getItem('regId');

            this.registrationService.getRegistration(regId).subscribe((res: Registration) => {
                if (res.submitted == false) {
                    this.router.navigate(['upload-receipt-image/', parseInt(localStorage.getItem('regId'))]);
                } else {
                    // check email exists
                    if (res.customer !== undefined && res && (<Customer>res.customer).email) {
                        this.router.navigate(['send-email/', parseInt(localStorage.getItem('regId'))]);
                    } else {
                        this.router.navigate(['success']);
                    }
                }
            });
        }
    }
}
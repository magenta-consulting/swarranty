import {Injectable} from '@angular/core';
import {Router, CanActivate} from '@angular/router';

import {ProductService} from "./product.service";
import {RegistrationService} from "./registration.service";
import {Registration} from "../model/registration";
import {Customer} from "../model/customer";
import {apiEndPoint, apiEndPointBase} from "../../environments/environment";

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
        if (localStorage.getItem('regId')) {
            this.getDataRegistration();
        }
        return true;
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Registration
    getDataRegistration() {
        // let regId = this.router.snapshot.params['id'];
        if (localStorage.getItem('regId')) {
            let regId = localStorage.getItem('regId');
            if (Number.isNaN(parseInt(regId))) {
                let cutstr = '/api/registrations/';
                console.log('regId', regId, cutstr.length);
                regId = regId.substring(cutstr.length);
            }

            this.registrationService.getRegistration(regId).subscribe((res: Registration) => {
                if (res.submitted == false) {
                    this.router.navigate(['upload-receipt-image/', parseInt(regId)]);
                } else {
                    // check email exists
                    if (res.customer !== undefined && res && (<Customer>res.customer).email) {
                        this.router.navigate(['send-email/', parseInt(regId)]);
                    } else {
                        this.router.navigate(['success']);
                    }
                }
            });
        }
    }
}
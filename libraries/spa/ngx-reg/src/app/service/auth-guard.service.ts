import { Injectable }     from '@angular/core';
import { Router, CanActivate }    from '@angular/router';

import {ProductService} from "./product.service";

@Injectable()
export class AuthGuard implements CanActivate {

    dataRegistration : any = "";

    constructor(public router: Router,
                private productService: ProductService) {
        
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
        if(localStorage.getItem('regId')) {
            let regId = parseInt(localStorage.getItem('regId'));
            
            this.productService.getApiRegistration(regId).subscribe(res => {
                if(res.submitted == false) {
                    this.router.navigate(['upload-receipt-image/', parseInt(localStorage.getItem('regId'))]);
                } else {
                    // check email exists
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
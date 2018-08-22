import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router} from "@angular/router";
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';

import {ProductService} from "../../service/product.service";
import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";

@Component({
    selector: 'send-email',
    templateUrl: './send-email.component.html',
    styleUrls: ['./send-email.component.scss']
})
export class SendEmailComponent implements OnInit, AfterViewInit {

    isLoading: boolean = false;
    dataCustomer : any = [];
    dataVerify: any = '';
    verifyFail : boolean = false;
    isClick : boolean = false;

    modalRef: BsModalRef;

    constructor(private productService: ProductService,
        private router: Router,
        private modalService: BsModalService) {
    }

    ngOnInit() {
        // 1.
        this.getDataCustomer();
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Customer
    getDataCustomer() {
        // let regId = this.router.snapshot.params['id'];
        this.isLoading = true;
        if(localStorage.getItem('regId')) {
            let regId = parseInt(localStorage.getItem('regId'));
    
            this.productService.getApiCustomer(regId).subscribe(res => {
                this.isLoading = false;
                this.dataCustomer = res;
            });
        } else {
            this.dataCustomer = [];
            this.isLoading = false;
        }
    }

    // 2. Resend Email
    resendEmail(event: any) {
        if(localStorage.getItem('regId')) {
            let regId = parseInt(localStorage.getItem('regId'));
            let params = {
                "registrationId": regId,
                "type": "verification"
            }
    
            this.productService.postVerifyEmail(params)
            .subscribe(
                res => {
                    if(res) {
                        let resVerify : any = res;
                        this.dataVerify = resVerify.message;

                        // hide button click
                        this.isClick = true;
                    }
                },
                error => {
                    // var details = error.json();
                    // console.log(error);
                    this.verifyFail = true;
                    
                    // hide button click
                    this.isClick = true;
                },
                ()  =>  {
                    // console.log("Finished")
                }
            );
        } else {
            // this.dataCustomer = [];
            // this.isLoading = false;
        }
    }

    // clear localStorage and then redirect to page registration
    clearRegistration() {
        this.modalRef.hide();
        localStorage.removeItem('regId');
        this.router.navigate(['/']);
    }

    openModal(template: TemplateRef<any>) {
        this.modalRef = this.modalService.show(template);
    }
}

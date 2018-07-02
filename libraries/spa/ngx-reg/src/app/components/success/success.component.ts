import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';

import {ProductService} from "../../service/product.service";
import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";

@Component({
    selector: 'success',
    templateUrl: './success.component.html',
    styleUrls: ['./success.component.scss']
})
export class SuccessComponent implements OnInit, AfterViewInit {

    prodList: any = [];
    isLoading: boolean = false;

    modalRef: BsModalRef;

    constructor(private productService: ProductService, 
        private router: Router,
        private modalService: BsModalService) {
    }

    ngOnInit() {
        // 1.
        this.getDataWarranties();
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Warranties
    getDataWarranties() {
        // let regId = this.router.snapshot.params['id'];
        this.isLoading = true;
        if (localStorage.getItem('regId')) {
            let regId:any = localStorage.getItem('regId');
            if (Number.isNaN(parseInt(regId))) {
                let cutstr = '/api/registrations/';
                console.log('regId', regId, cutstr.length);
                regId = parseInt(regId.substring(cutstr.length));
            } else {
                regId = parseInt(regId);
            }

            this.productService.getApiWarranties(regId).subscribe(prods => {
                this.isLoading = false;
                this.prodList = prods;
            });
        } else {
            this.prodList = [];
            this.isLoading = false;
        }
    }
    // clear localStorage and then redirect to page registration
    clearRegistration() {
        this.modalRef.hide();
        localStorage.removeItem('regId');
        this.router.navigate(['/registration']);
    }

    openModal(template: TemplateRef<any>) {
        this.modalRef = this.modalService.show(template);
    }
}

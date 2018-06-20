import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";

import {ProductService} from "../../service/product.service";
import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";

@Component({
    selector: 'success',
    templateUrl: './success.component.html',
    styleUrls: ['./success.component.scss']
})
export class SuccessComponent implements OnInit, AfterViewInit {

    prodList : any = [];
    isLoading: boolean = false;

    constructor(private productService: ProductService) {
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
        if(localStorage.getItem('regId')) {
            let regId = parseInt(localStorage.getItem('regId'));
    
            this.productService.getApiWarranties(regId).subscribe(prods => {
                this.isLoading = false;
                this.prodList = prods;
            });
        } else {
            this.prodList = [];
            this.isLoading = false;
        }
    }

}

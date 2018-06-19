import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";

import {ProductService} from "../../service/product.service";
import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";

@Component({
    selector: 'uploads',
    templateUrl: './uploads.component.html',
    styleUrls: ['./uploads.component.scss']
})
export class UploadsComponent implements OnInit, AfterViewInit {

    prodList : any = [];
    isLoading: boolean = false;
    qrCodeImg : string = '';

    constructor(private router: ActivatedRoute,
        private productService: ProductService) {
    }

    ngOnInit() {
        // 1.
        this.getDataRegistrations();
        
        this.qrCodeImg = apiEndPoint + apiEndPointBase +'/qr-code/'+ apiEndPoint +'/registrations/'+ this.router.snapshot.params['id'] +'/upload-image.png';
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Registration
    getDataRegistrations() {
        let regId = this.router.snapshot.params['id'];
        this.isLoading = true;

        this.productService.getApiRegistrations(regId).subscribe(prods => {
            this.isLoading = false;
            this.prodList = prods;
        });
    }
}

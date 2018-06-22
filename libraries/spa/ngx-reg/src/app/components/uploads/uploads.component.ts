import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";

import {ProductService} from "../../service/product.service";
import {apiEndPoint, apiEndPointBase, apiUploadWarranty, organisationPath} from "../../../environments/environment";

import {ImageUploadModule, FileHolder, UploadMetadata} from "angular2-image-upload";

@Component({
    selector: 'uploads',
    templateUrl: './uploads.component.html',
    styleUrls: ['./uploads.component.scss']
})
export class UploadsComponent implements OnInit, AfterViewInit {

    prodList: any = [];
    isLoading: boolean = false;
    qrCodeImg: string = '';

    constructor(private router: ActivatedRoute,
                private productService: ProductService) {
    }

    ngOnInit() {
        // 1.
        this.getDataWarranties();

        this.qrCodeImg = apiEndPoint + apiEndPointBase + '/qr-code/http://' + window.location.hostname + '/registrations/' + this.router.snapshot.params['id'] + '/upload-image.png';
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Warranties
    getDataWarranties() {
        let regId = this.router.snapshot.params['id'];
        this.isLoading = true;
        localStorage.setItem('regId', apiEndPointBase + '/registrations/' + regId);
        if (localStorage.getItem('regId')) {
            // let regId = parseInt(localStorage.getItem('regId'));

            this.productService.getApiWarranties(regId).subscribe(res => {
                this.isLoading = false;
                this.prodList = res;
                for (let prod of this.prodList) {
                    prod.uploadUrl = apiUploadWarranty + '/' + prod.id;
                }
            });
        } else {
            this.prodList = [];
            this.isLoading = false;
        }
    }

    // 2. Event uploads
    onBeforeUpload = (metadata: UploadMetadata) => {
        // mutate the file or replace it entirely - metadata.file
        let warId = metadata.url.substring(apiUploadWarranty.length);
        metadata.formData = {receiptImageWarranty: warId};
        console.log('warid is',warId);        metadata.url = apiUploadWarranty;

        return metadata;
    };

    onUploadFinished(file: FileHolder, warId: any) {
        console.log('finished', file);

        let params = {
            'binaryContent': file.src,
            'context': 'receipt_image',
            'enabled': 1,
            'receiptImageWarranty': warId
        };

        this.uploadsImg(params);

    }

    onRemoved(file: FileHolder) {
        console.log('removed', file);
    }

    onUploadStateChanged(state: boolean) {
        console.log('state', state);
    }

    // 3. Upload images
    uploadsImg(params: any) {

        this.productService.uploadWarrantyImg(params).subscribe(res => {
            console.log(res);
            // this.isLoading = false;
            // this.dataCustomer = res;
        });
    }
}

import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";

import {ProductService} from "../../service/product.service";
import {apiEndPoint, 
        apiEndPointBase, 
        apiEndPointMedia, 
        apiMediaUploadPath, 
        organisationPath,
        binariesMedia} from "../../../environments/environment";

import {ImageUploadModule, FileHolder, UploadMetadata} from "../../extensions/angular2-image-upload";

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

        this.qrCodeImg = apiEndPoint + apiEndPointBase + '/qr-code/'+ location.protocol + '//' + window.location.hostname + '/upload-receipt-image/' + this.router.snapshot.params['id'] + '.png';
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */

    // 1. Get Data Warranties
    getDataWarranties() {
        let regId = this.router.snapshot.params['id'];

        if(!localStorage.getItem('regId')) {
            localStorage.setItem('regId', regId);
        } 
        
        this.isLoading = true;
        // localStorage.setItem('regId', apiEndPointBase + '/registrations/' + regId);
        // let regId = parseInt(localStorage.getItem('regId'));
        let apiUploadWarranty = apiEndPointMedia + apiMediaUploadPath;
        this.productService.getApiWarranties(regId).subscribe(
            res => {
                this.isLoading = false;
                this.prodList = res;
                for (let prod of this.prodList) {
                    prod.uploadUrl = apiUploadWarranty + '/' + prod.id;

                    // create array images
                    prod.imageUrl = [];
                    for (let prodImg of prod.receiptImages) {
                        prod.imageUrl.push(apiEndPointMedia + '/media/' + prodImg.id + binariesMedia);
                    }
                }
            },
            error => {
                console.log('Error', error);
                this.prodList = [];
                this.isLoading = false;
            },
            () => {
                console.log('Complete Request');
            }
        );
    }

    // 2. Event uploads
    onBeforeUpload = (metadata: UploadMetadata) => {
        // mutate the file or replace it entirely - metadata.file
        // console.log('metadata.url', metadata.url);
        let apiUploadWarranty = apiEndPointMedia + apiMediaUploadPath;
        let warId = metadata.url.substring(apiUploadWarranty.length+1);
        metadata.formData = { 
            "receiptImageWarranty" : warId,
            "context" : "receipt_image"
        };
        
        // console.log('warid is',warId);        
        metadata.url = apiUploadWarranty;
        return metadata;
    };

    onUploadFinished(file: FileHolder, warId: any) {
        console.log('finished', file);
    }

    onRemoved(file: FileHolder) {
        console.log('removed', file);
    }

    onUploadStateChanged(state: boolean) {
        console.log('state', state);
    }
}

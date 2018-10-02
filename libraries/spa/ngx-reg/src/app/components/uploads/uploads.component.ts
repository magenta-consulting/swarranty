import { AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { NgSelectModule, NgOption } from '@ng-select/ng-select';
import { Router, ActivatedRoute } from "@angular/router";
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';

import { ProductService } from "../../service/product.service";
import {
  apiEndPoint,
  apiEndPointBase,
  apiEndPointMedia,
  apiMediaUploadPath,
  organisationPath,
  binariesMedia
} from "../../../environments/environment";

import { ImageUploadModule, FileHolder, UploadMetadata } from "../../extensions/angular2-image-upload";

import { Helper } from "../../helper/helper";
import { RegistrationService } from "../../service/registration.service";
import { Customer } from "../../model/customer";
import { baseUrl } from '../../../environments/environment';

@Component({
  selector: 'uploads',
  templateUrl: './uploads.component.html',
  styleUrls: ['./uploads.component.scss']
})
export class UploadsComponent implements OnInit, AfterViewInit {

  prodList: any = [];
  isLoading: boolean = false;
  qrCodeImg: string = '';

  modalRef: BsModalRef;

  constructor(private route: ActivatedRoute,
    private router: Router,
    private productService: ProductService,
    private helper: Helper,
    private regService: RegistrationService,
    private modalService: BsModalService
  ) {
  }

  ngOnInit() {
    // 1.
    this.getDataWarranties();

    this.qrCodeImg = apiEndPoint + apiEndPointBase + '/qr-code/' + location.protocol + '//' + window.location.hostname + baseUrl + '/upload-receipt-image/' + this.route.snapshot.params['id'] + '.png';
  }

  ngAfterViewInit() {
  }

  /* =========================================== */
  /** Actions in this Comp */

  submitRegistration() {
    // console.log('submitting');
    let regId = this.route.snapshot.params['id'];
    this.regService.submitRegistration(regId).subscribe(
      res => {
        this.isLoading = false;
        let c = <Customer>res.customer;

        let email = c.email;
        if (typeof email !== 'undefined' && email !== null && email !== '') {
          if (!res.verified) {
            this.router.navigate(['/send-email/' + regId]);
          }
        }
        this.router.navigate(['/success/' + regId]);
      },
      error => {
        // console.log('Error', error);
      },
      () => {
      }
    );
  }

  // 1. Get Data Warranties
  getDataWarranties() {
    let regId = this.route.snapshot.params['id'];

    if (!localStorage.getItem('regId')) {
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
        // console.log('Error', error);
        this.prodList = [];
        this.isLoading = false;
      }
    );
  }

  // 2. Event uploads
  onBeforeUpload = (metadata: UploadMetadata) => {
    // mutate the file or replace it entirely - metadata.file
    // console.log('metadata.url', metadata.url);
    let apiUploadWarranty = apiEndPointMedia + apiMediaUploadPath;
    let warId = metadata.url.substring(apiUploadWarranty.length + 1);
    metadata.formData = {
      "receiptImageWarranty": warId,
      "context": "receipt_image"
    };

    // console.log('warid is',warId);
    metadata.url = apiUploadWarranty;
    return metadata;
  };

  onUploadFinished(file: FileHolder) {
    // console.log('finished', file);

    // 1.
    // this.getDataWarranties();
  }

  onRemoved(file: FileHolder) {
    let v_confirm = false;
    // check android or ios
    if (navigator.userAgent.toLowerCase().indexOf("android") > -1
      || navigator.userAgent.toLowerCase().indexOf("ios") > -1) {
      v_confirm = true;
    } else {
      // not android
      v_confirm = confirm('Do you really want to remove this image ?');
      // console.log('removed', file);
    }
    if(file.serverResponse && file.serverResponse.response) {
      let imgId = JSON.parse(file.serverResponse.response._body).id;
      // After Asking.
      if (v_confirm == true) {
        this.productService.deleteWarrantyImg(parseInt(imgId)).subscribe(
          res => {
            // console.log('res', res);
          },
          error => {
            // console.log('Error', error);
          },
          () => {
            // console.log('Complete Request');
          }
        );
      }
    } else {
      let splitUrlMedia = this.helper.explode('/media/', file.src, undefined);
      let imgId = this.helper.explode(binariesMedia, splitUrlMedia[1], undefined);
      
      // After Asking.
      if (v_confirm == true) {
        this.productService.deleteWarrantyImg(parseInt(imgId[0])).subscribe(
          res => {
            // console.log('res', res);
          },
          error => {
            // console.log('Error', error);
          },
          () => {
            // console.log('Complete Request');
          }
        );
      }
    }

  }

  onUploadStateChanged(state: boolean) {
    // console.log('state', state);
  }

  // clear localStorage and then redirect to page registration
  clearRegistration() {
    this.modalRef.hide();
    // localStorage.removeItem('regId');
      localStorage.clear();
    this.router.navigate(['/']);
  }

  openModal(template: TemplateRef<any>) {
    this.modalRef = this.modalService.show(template);
  }
}

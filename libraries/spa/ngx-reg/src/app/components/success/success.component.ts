import { AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { NgSelectModule, NgOption } from '@ng-select/ng-select';
import { Router, ActivatedRoute } from "@angular/router";
import { BsModalService } from 'ngx-bootstrap/modal';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';

import { ProductService } from "../../service/product.service";
import { apiEndPoint, apiEndPointBase, organisationPath } from "../../../environments/environment";

@Component({
  selector: 'success',
  templateUrl: './success.component.html',
  styleUrls: ['./success.component.scss']
})
export class SuccessComponent implements OnInit, AfterViewInit {

  prodList: any = [];
  isLoading: boolean = false;

  modalRef: BsModalRef;

  dataVerify: any = '';
  verifyFail : boolean = false;
  isClick : boolean = false;

  constructor(private route: ActivatedRoute, private productService: ProductService,
    private router: Router,
    private modalService: BsModalService) {
  }

  ngOnInit() {
    let regId = this.route.snapshot.params['id'];
    localStorage.setItem('regId', regId);
    // 1.
    this.getDataWarranties();
  }

  ngAfterViewInit() {
    this.sendEmail();
  }

  /* =========================================== */
  /** Actions in this Comp */

  // 1. Get Data Warranties
  getDataWarranties() {
    this.isLoading = true;
    if (localStorage.getItem('regId')) {
      let regId: any = localStorage.getItem('regId');
      if (Number.isNaN(parseInt(regId))) {
        let cutstr = apiEndPointBase + '/registrations/';
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

  // 2. send Email
  sendEmail() {
    if (localStorage.getItem('regId')) {
      let regId = parseInt(localStorage.getItem('regId'));
      let params = {
        "registrationId": regId,
        "type": "confirmation"
      }

      this.productService.postVerifyEmail(params)
        .subscribe(
          res => {
            if (res) {
              let resVerify: any = res;
              this.dataVerify = resVerify.message;

              // hide button click
              this.isClick = true;
            }
          },
          error => {
            // var details = error.json();
            console.log(error);
            this.verifyFail = true;

            // hide button click
            this.isClick = true;
          },
          () => console.log("Finished")
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

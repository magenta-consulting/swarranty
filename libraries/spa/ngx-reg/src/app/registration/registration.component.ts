import { AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { NgSelectModule, NgOption } from '@ng-select/ng-select';
import { Brand } from "../model/brand";
import { ProductService } from "../service/product.service";
import { BrandCategory } from "../model/brand-category";
import { Product } from "../model/product";
import { BrandSubCategory } from "../model/brand-sub-category";
import { Dealer } from "../model/dealer";
import { BsModalRef, BsModalService } from "ngx-bootstrap";
import { Customer } from "../model/customer";
import { Warranty } from "../model/warranty";
import { Router } from "@angular/router";
import { OrganisationService } from "../service/organisation.service";
import { Organisation } from "../model/organisation";
import { CustomerService } from '../service/customer.service';
import { Registration } from '../model/registration';
import { RegistrationService } from '../service/registration.service';

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent implements OnInit, AfterViewInit {
  focusDialingCodeEM = new EventEmitter<boolean>();

  customer: Customer = { id: null, name: null, dialingCode: 64 } as Customer;
  emailConfirm: string;
  typingEmail: false;
  typingConfirm: false;
  isAgreedToTermsAndPolicy: false;

  warranties: Warranty[] = [];

  isDialingCodeEditing = false;

  previewStates: any = {};
  isFormPreview = false;
  checkingError = false;
  organisation: Organisation = { id: null, name: null, tos: null, dataPolicy: null } as Organisation;

  modalTitle: string;
  modalContent: string;

  constructor(private productService: ProductService, private organisationService: OrganisationService, private customerService: CustomerService, private registrationSerice: RegistrationService, private router: Router) {
    let warranty: Warranty = new Warranty();
    warranty.id = null;

    this.warranties.push(warranty);
    productService.getBrands().subscribe(brands => warranty.brands = brands);
    productService.getDealers().subscribe(d => warranty.dealers = d);
    organisationService.getOrganisation().subscribe(organisation => this.organisation = organisation);
  }

  ngOnInit() {
  }

  ngAfterViewInit() {
  }

  isPreview(field: string): boolean {
    if (!this.previewStates.hasOwnProperty(field)) {
      this.previewStates[field] = true;
    }
    return this.previewStates[field] && this.isFormPreview;
  }

  editPreview(field: string): void {
    this.previewStates[field] = false;
  }

  updateField(field: string): void {
    this.previewStates[field] = true;
  }

  isEmailValid() {
    if (this.customer.email == null || this.customer.email.trim() === '') { return true; }
    return (/^.+\@.+\..+$/.test(this.customer.email));
  }

  isOk() {
    if (this.customer.name == null || this.customer.name.trim() === '') {
      return false;
    }
    if (this.customer.telephone == null) {
      return false;
    }
    if (!this.isEmailValid()) {
      return false;
    }
    if (this.emailConfirm.trim() !== this.customer.email.trim()) {
      return false;
    }
    for (let i = 0; i < this.warranties.length; i++) {
      const warranty = this.warranties[i];
      if (warranty.selectedBrand == null || warranty.selectedCategory == null || warranty.selectedProduct == null) {
        return false;
      }
      if (warranty.purchaseDate == null) {
        return false;
      }
    }
    return this.isAgreedToTermsAndPolicy;
  }

  submit() {
    if (this.isFormPreview) {
      // Confirmed
      this.customerService.postCustomer(this.customer).subscribe(customer => {
        let reg = new Registration();
        reg.customer = customer['@id'];
        reg.submitted = false;
        reg.warranties = [];
        for (let w of this.warranties) {
          let rw = { customer: reg.customer } as Warranty;
          rw.product = w.selectedProduct.id;
          rw.purchaseDate = w.purchaseDate;
          rw.productSerialNumber = w.productSerialNumber;
          reg.warranties.push(rw);
        }
        this.registrationSerice.postRegistration(reg).subscribe(reg => {
          localStorage.setItem('regId', reg['@id']);
          this.router.navigate(['/upload-receipt-image/', { id: reg['@id'] }]);
        });

      });
    } else {
      if (this.isOk()) {
        this.isFormPreview = true;
      }
      this.checkingError = true;
    }
    // this.router.navigate(['/preview', {customer: this.customer, warranties: this.warranties}]);
  }

  editDialingCode() {
    this.isDialingCodeEditing = true;
    this.focusDialingCodeEM.emit(true);
  }

  updateDialingCode(value: number) {
    this.customer.dialingCode = value;
    this.isDialingCodeEditing = false;
  }

  removeWarranty(w: Warranty) {
    let index = this.warranties.indexOf(w);
    if (index > -1) {
      this.warranties.splice(index, 1);
      this.warranties = this.warranties;
    }
  }

  addWarranty() {
    let warranty: Warranty = new Warranty();
    warranty.id = null;

    this.warranties.push(warranty);
    this.productService.getBrands().subscribe(brands => warranty.brands = brands);
    this.productService.getDealers().subscribe(d => warranty.dealers = d);
  }

  selectBrand(e, warranty: Warranty): void {
    if (warranty.selectedBrand.id !== null) {
      warranty.categories = [{ id: null, name: 'Loading' } as BrandCategory];
      warranty.isProductHidden = true;
      warranty.isCategoryHidden = true;

      this.productService.getCategories(warranty.selectedBrand.id).subscribe(cats => {
        warranty.categories = cats;
        warranty.isCategoryHidden = false;
        warranty.selectedCategory = null;
      });
    }
  }

  selectCategory(e, warranty: Warranty): void {
    if (warranty.selectedCategory.id !== null) {
      warranty.products = [{ id: null, name: 'Loading' } as Product]
      warranty.isProductHidden = true;

      this.productService.getProductsByCategory(warranty.selectedCategory.id).subscribe(prods => {
        warranty.products = prods;
        warranty.isProductHidden = false;
        warranty.selectedProduct = null;
      });
    }
  }

  getInforModal(type) {
    if (type == 1) {
      this.modalTitle = 'Terms and Conditions';
      this.modalContent = this.organisation.tos;
    } else {
      this.modalTitle = 'Data Protection Policy';
      this.modalContent = this.organisation.dataPolicy;
    }
  }

}

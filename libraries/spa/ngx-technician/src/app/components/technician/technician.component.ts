import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";

import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";

import {ImageUploadModule, FileHolder, UploadMetadata} from "../../extensions/angular2-image-upload";
import { MemberService } from '../../service/member.service';
import { Member } from '../../model/member';
import { Case } from '../../model/case';
import { Brand } from '../../model/brand';
import { Product } from '../../model/product';
import { BrandCategory } from '../../model/brand-category';
import { Warranty } from '../../model/warranty';
import { ProductService } from '../../service/product.service';

@Component({
    selector: 'technician',
    templateUrl: './technician.component.html',
    styleUrls: ['../technicians/technicians.component.scss']
})
export class TechnicianComponent implements OnInit, AfterViewInit {
    id: number;
    sub: any;
    isLoading: boolean = false;
    cases: Case[];
    case: Case = null;

    // brands: Brand[];
    // categories: BrandCategory;
    // products: Product[];

    constructor(
        private memberService: MemberService, 
        private productService: ProductService,
        private route: ActivatedRoute,
    ) {
        memberService.getMembers(1).subscribe(members => {
            this.cases = members[0].assignedCases;
            this.cases.forEach(element => {
                if (element.id == this.id) {
                    this.case = element;
                    this.case.warranty.selectedBrand = (this.case.warranty.product as Product).brand;
                }
            });
            console.log(this.case);
            productService.getBrands().subscribe(brands => this.case.warranty.brands = brands);
        });
    }

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            this.id = params['id'];
        });
    }

    ngOnDestroy() {
        this.sub.unsubscribe();
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */
    // 1. Event uploads
    onBeforeUpload = (metadata: UploadMetadata) => {
        // mutate the file or replace it entirely - metadata.file
        // console.log('metadata.url', metadata.url);
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

    selectBrand(e, warranty: Warranty): void {
        let brand = warranty.selectedBrand;
        if (brand == null) {
            warranty.selectedCategory = null;
            warranty.product = null;
            return;
        }
        if (brand.id !== null) {
            warranty.categories = [{id: null, name: 'Loading'} as BrandCategory];
            warranty.isProductHidden = true;
            warranty.isCategoryHidden = true;

            this.productService.getCategories(brand.id).subscribe(cats => {
                warranty.categories = cats;
                warranty.isCategoryHidden = false;
                warranty.selectedCategory = null;
            });
        }
    }

    selectCategory(e, warranty: Warranty): void {
        if (warranty.selectedCategory == null) {
            warranty.product = null;
            return;
        }
        if (warranty.selectedCategory.id !== null) {
            warranty.products = [{id: null, name: 'Loading'} as Product]
            warranty.isProductHidden = true;

            this.productService.getProductsByCategory(warranty.selectedCategory.id).subscribe(prods => {
                warranty.products = prods;
                warranty.isProductHidden = false;
                warranty.selectedProduct = null;
            });
        }
    }
}

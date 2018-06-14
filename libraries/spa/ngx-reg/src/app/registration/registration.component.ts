import {Component, OnInit, TemplateRef} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Brand} from "../model/brand";
import {ProductService} from "../model/product.service";
import {BrandCategory} from "../model/brand-category";
import {Product} from "../model/product";
import {BrandSubCategory} from "../model/brand-sub-category";
import {Dealer} from "../model/dealer";
import {BsModalRef, BsModalService} from "ngx-bootstrap";
import {Customer} from "../model/customer";
import {Warranty} from "../model/warranty";

@Component({
    selector: 'app-registration',
    templateUrl: './registration.component.html',
    styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent implements OnInit {

    customer: Customer = {id: null, name: null};

    warranties: Warranty[] = [];

    constructor(private productService: ProductService) {
        let warranty: Warranty = new Warranty();
        warranty.id = null;

        this.warranties.push(warranty);
        productService.getBrands().subscribe(brands => warranty.brands = brands);
        productService.getDealers().subscribe(d => warranty.dealers = d);
    }

    ngOnInit() {
    }

    removeWarranty(w:Warranty){
        var index = this.warranties.indexOf(w);
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
            warranty.categories = [{id: null, name: "Loading"} as BrandCategory]
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
            warranty.products = [{id: null, name: "Loading"} as Product]
            warranty.isProductHidden = true;

            this.productService.getProductsByCategory(warranty.selectedCategory.id).subscribe(prods => {
                warranty.products = prods;
                warranty.isProductHidden = false;
                warranty.selectedProduct = null;
            });
        }
    }

}

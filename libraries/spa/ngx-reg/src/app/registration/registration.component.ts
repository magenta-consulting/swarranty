import {Component, OnInit, TemplateRef} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Brand} from "../model/brand";
import {ProductService} from "../model/product.service";
import {BrandCategory} from "../model/brand-category";
import {Product} from "../model/product";
import {BrandSubCategory} from "../model/brand-sub-category";
import {Dealer} from "../model/dealer";
import {BsModalRef, BsModalService} from "ngx-bootstrap";

@Component({
    selector: 'app-registration',
    templateUrl: './registration.component.html',
    styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent implements OnInit {
    brands: Brand[] = [
        {id: null, name: "Loading"} as Brand
    ];

    categories: BrandCategory[] = [
        {id: null, name: "Loading"} as BrandCategory
    ];

    subCategories: BrandSubCategory[] = [
        {id: null, name: "Loading"} as BrandSubCategory
    ];

    products: Product[] = [
        {id: null, name: "Loading"} as Product
    ];

    dealers: Dealer[] = [
        {id: null, name: "Loading"} as Dealer
    ];

    selectedBrand: Brand = null;
    selectedCategory: BrandCategory = null;
    selectedProduct: Product = null;
    selectedDealer: Dealer = null;

    isCategoryHidden = true;
    isProductHidden = true;

    purchaseDate: Date;

    constructor(private productService: ProductService) {
        productService.getBrands().subscribe(brands => this.brands = brands);
        productService.getDealers().subscribe(d => this.dealers = d);
    }

    ngOnInit() {
    }

    selectBrand(e): void {
        if (this.selectedBrand.id !== null) {
            this.categories = [{id: null, name: "Loading"} as BrandCategory]
            this.isProductHidden = true;
            this.isCategoryHidden = true;

            this.productService.getCategories(this.selectedBrand.id).subscribe(cats => {
                this.categories = cats;
                this.isCategoryHidden = false;
                this.selectedCategory = null;

            });
        }
    }

    selectCategory(e): void {
        if (this.selectedCategory.id !== null) {
            this.products = [{id: null, name: "Loading"} as Product]
            this.isProductHidden = true;

            this.productService.getProductsByCategory(this.selectedCategory.id).subscribe(prods => {
                this.products = prods;
                this.isProductHidden = false;
                this.selectedProduct = null;

            });
        }
    }

    test(): void {
        this.categories = [...this.categories, {id: '3', name: "hello 3"} as BrandCategory];
    }
}

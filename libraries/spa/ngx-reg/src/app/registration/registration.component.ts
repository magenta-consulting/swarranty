import {Component, OnInit} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Brand} from "../model/brand";
import {ProductService} from "../model/product.service";

@Component({
    selector: 'app-registration',
    templateUrl: './registration.component.html',
    styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent implements OnInit {
    brands: Brand[] = [
        {id: 0, name: "Loading"} as Brand
    ];

    categories = [
        {id: 0, name: "Loading"}
    ];

    subCategories = [];

    products = []

    selectedBrand: Brand;
    selectedCategory: any;
    purchaseDate;

    constructor(private productService: ProductService) {
        productService.getBrands().subscribe(brands => this.brands = brands)
        ;
    }

    ngOnInit() {
    }

    selectCategory(e): void {
        console.log('selected e  ', e);
    }

    test(): void {
        this.categories = [...this.categories, {id: 3, name: "hello 3"}];
    }
}

import {BrandCategory} from "./brand-category";
import {BrandSubCategory} from "./brand-sub-category";
import {Brand} from "./brand";
import {Warranty} from "./warranty";
import {Customer} from "./customer";

export class Product {
    id: string;
    name: string;
    brand: Brand;
    categories: BrandCategory;
    subCategories: BrandSubCategory;
    customer: Customer;
    warranties: Warranty[];

    constructor() {
        this.brand = null;
        this.categories = null;
        this.subCategories = null;
    }

}

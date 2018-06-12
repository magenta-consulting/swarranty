import {BrandCategory} from "./brand-category";
import {BrandSubCategory} from "./brand-sub-category";
import {Brand} from "./brand";

export class Product {
    id: number;
    name: string;
    brand: Brand;
    categories: BrandCategory;
    subCategories: BrandSubCategory;

    constructor() {
        this.brand = null;
        this.categories = null;
        this.subCategories = null;
    }

}

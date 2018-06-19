import {BrandCategory} from "./brand-category";
import {BrandSubCategory} from "./brand-sub-category";
import {Product} from "./product";
import {Dealer} from "./dealer";
import {Brand} from "./brand";
import {Customer} from "./customer";

export class Warranty {
    id: string;
    name: string;
    product: Product;
    customer: Customer;
    productSerialNumber: string;
    purchaseDate: Date;


    isCategoryHidden = true;
    isProductHidden = true;

    selectedBrand: Brand = null;
    selectedCategory: BrandCategory = null;
    selectedProduct: Product = null;
    selectedDealer: Dealer = null;

    constructor() {
        this.brands = [
            {id: null, name: "Loading"} as Brand
        ];
        this.categories = [
            {id: null, name: "Loading"} as BrandCategory
        ];
        this.subCategories = [
            {id: null, name: "Loading"} as BrandSubCategory
        ];
        this.products = [
            {id: null, name: "Loading"} as Product
        ];
        this.dealers = [
            {id: null, name: "Loading"} as Dealer
        ];
    }

    brands: Brand[];

    categories: BrandCategory[];

    subCategories: BrandSubCategory[];

    products: Product[];

    dealers: Dealer[];
}

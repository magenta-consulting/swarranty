import {BrandCategory} from "./brand-category";
import {BrandSubCategory} from "./brand-sub-category";

export class Brand {
    id: string;
    name: string;
    categories: BrandCategory[];
    subCategories: BrandSubCategory[];
}

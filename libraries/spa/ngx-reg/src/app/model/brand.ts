import {BrandCategory} from "./brand-category";
import {BrandSubCategory} from "./brand-sub-category";

export class Brand {
    id: number;
    name: string;
    categories: BrandCategory[];
    subCategories: BrandSubCategory[];
}

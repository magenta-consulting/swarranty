import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';

import {Observable, of} from 'rxjs';
import {catchError, map, tap} from 'rxjs/operators';
import {Brand} from "./brand";
import {apiEndPoint, apiEndPointBase, organisationPath} from "../../environments/environment";
import {BrandCategory} from "./brand-category";
import {Product} from "./product";
import {Dealer} from "./dealer";
import {Customer} from "./customer";

const httpOptions = {
    headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
};

@Injectable({
    providedIn: 'root'
})
export class ProductService {

    brandsUrl = '/brands';
    categoriesUrl = '/brand-categories';
    productsUrl = '/products';
    dealersUrl = '/dealers';

    customer: Customer;

    constructor(private http: HttpClient) {
    }

    getDealers(): Observable<Dealer[]> {
        const orgId = localStorage.getItem('orgId');
        let url = `${apiEndPoint}${apiEndPointBase}${organisationPath}/${orgId}${this.dealersUrl}`;
        return this.http.get<Dealer[]>(url).pipe(
            map((res) => {

                let collection = res["hydra:member"];
                let dealers: Dealer[] = [];
                for (let item of collection) {
                    dealers.push({id: item['@id'], name: item['name']} as Dealer);
                }

                return dealers;
            }),
            catchError(this.handleError('getBrands', []))
        );
    }

    getBrands(): Observable<Brand[]> {
        const orgId = localStorage.getItem('orgId');
        let url = `${apiEndPoint}${apiEndPointBase}${organisationPath}/${orgId}${this.brandsUrl}`;
        return this.http.get<Brand[]>(url).pipe(
            map((res) => {

                let collection = res["hydra:member"];
                let brands: Brand[] = [];
                for (let item of collection) {
                    brands.push({id: item['@id'], name: item['name']} as Brand);
                }

                return brands;
            }),
            catchError(this.handleError('getBrands', []))
        );
    }

    getCategories(brandId: string) {
        let url = `${apiEndPoint}${brandId}${this.categoriesUrl}`;
        return this.http.get<BrandCategory[]>(url).pipe(
            map((res) => {

                let collection = res["hydra:member"];
                let cats: BrandCategory[] = [];
                for (let item of collection) {
                    cats.push({id: item['@id'], name: item['name']} as BrandCategory);
                }

                return cats;
            }),
            catchError(this.handleError('getBrands', []))
        );
    }

    getProductsByCategory(categoryId: string) {
        let url = `${apiEndPoint}${categoryId}${this.productsUrl}`;
        return this.http.get<Product[]>(url).pipe(
            map((res) => {

                let collection = res["hydra:member"];
                let prods: Product[] = [];
                for (let item of collection) {
                    prods.push({id: item['@id'], name: item['name']} as Product);
                }

                return prods;
            }),
            catchError(this.handleError('getProducts', []))
        );
    }

    /**
     * Handle Http operation that failed.
     * Let the app continue.
     * @param operation - name of the operation that failed
     * @param result - optional value to return as the observable result
     */
    private handleError<T>(operation = 'operation', result?: T) {
        return (error: any): Observable<T> => {

            // TODO: send the error to remote logging infrastructure
            console.error(error); // log to console instead

            // TODO: better job of transforming error for user consumption
            console.log(`${operation} failed: ${error.message}`);

            // Let the app keep running by returning an empty result.
            return of(result as T);
        };
    }
}

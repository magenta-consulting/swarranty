import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, } from '@angular/common/http';

import {Observable, of} from 'rxjs';
import {catchError, map, tap} from 'rxjs/operators';
import {Brand} from "../model/brand";
import {apiEndPoint, apiEndPointBase, organisationPath, apiEndPointMedia} from "../../environments/environment";
import {BrandCategory} from "../model/brand-category";
import {Product} from "../model/product";
import {Dealer} from "../model/dealer";
import {Customer} from "../model/customer";
import {Warranty} from "../model/warranty";

import * as moment from 'moment';

const httpOptions = {
    headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
};

const httpUploadsOptions = {
    headers: new HttpHeaders({'Content-Type': 'multipart/form-data'})
};

@Injectable({
    providedIn: 'root'
})
export class ProductService {

    brandsUrl = '/brands';
    categoriesUrl = '/brand-categories';
    productsUrl = '/products';
    dealersUrl = '/dealers';
    registrationsUrl = '/registrations';
    verifyEmailUrl = '/email';

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

                let collection = res['hydra:member'];
                let prods: Product[] = [];
                for (let item of collection) {
                    prods.push({id: item['@id'], name: item['name']} as Product);
                }

                return prods;
            }),
            catchError(this.handleError('getProducts', []))
        );
    }

    // get warranties
    getApiWarranties(regId: number) {
        let url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}/${regId}`;

        return this.http.get<any>(url).pipe(
            map((res) => {

                let collection = res['warranties'];
                // console.log('collection', collection);
                let prods: any = [];
                for (let item of collection) {
                    prods.push(item);
                }

                return prods;
            }),
            catchError(this.handleError('getWarranties', []))
        );
    }

    // get data customer
    getApiCustomer(regId: number) {
        let url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}/${regId}`;

        return this.http.get<any>(url).pipe(
            map((res) => {

                let dataCutomer: any = res["customer"];

                return dataCutomer;
            }),
            catchError(this.handleError('getCustomer', []))
        );
    }

    // get data Registration
    getApiRegistration(regId: number) {
        let url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}/${regId}`;

        return this.http.get<any>(url).pipe(
            map((res) => {

                let dataRegistration: any = res;
                console.log('dataRegistration', dataRegistration);
                return dataRegistration;
            }),
            catchError(this.handleError('getRegistration', []))
        );
    }

    // verification email
    postVerifyEmail(params: any) {
        let url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}${this.verifyEmailUrl}`;

        return this.http.post(url, params, httpOptions).pipe(
            catchError(this.handleError('postVerify', []))
        );
    }

    // delete image
    deleteWarrantyImg(warId: any) {
        let url = `${apiEndPointMedia}/media/${warId}.json`;
        // console.log('warId', warId);
        return this.http.delete(url, warId).pipe(
            catchError(this.handleError('deleteImage', []))
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
            console.error('error', error); // log to console instead

            // TODO: better job of transforming error for user consumption
            console.log(`${operation} failed: ${error.message}`);

            // Let the app keep running by returning an empty result.
            return of(result as T);
        };
    }
}

import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';

import {Observable, of} from 'rxjs';
import {catchError, map, tap} from 'rxjs/operators';
import {Brand} from "./brand";
import {apiEndPoint, apiEndPointBase} from "../../environments/environment";

const httpOptions = {
    headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
};

@Injectable({
    providedIn: 'root'
})
export class ProductService {

    brandsUrl = '/brands'

    constructor(private http: HttpClient) {
        this.brandsUrl = apiEndPoint + apiEndPointBase + this.brandsUrl;
    }

    getBrands(): Observable<Brand[]> {
        return this.http.get<Brand[]>(this.brandsUrl).pipe(
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

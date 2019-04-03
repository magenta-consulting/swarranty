import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {catchError, map, tap} from 'rxjs/operators';

import {Observable, of, BehaviorSubject} from 'rxjs';
import {Brand} from '../model/brand';
import {apiEndPoint, apiEndPointBase, organisationPath} from '../../environments/environment';
import {BrandCategory} from '../model/brand-category';
import {Product} from '../model/product';
import {Dealer} from '../model/dealer';
import {Customer} from '../model/customer';
import {Warranty} from '../model/warranty';
import {Registration} from '../model/registration';

const httpOptions = {
    headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
};

@Injectable({
    providedIn: 'root'
})
export class RegistrationService {
    currentRegistration: Registration;

    registrationsUrl = '/registrations';

    constructor(private http: HttpClient) {
    }

    saveRegistration(reg: Registration) {
        this.currentRegistration = reg;
    }

    submitRegistration(regId): Observable<Registration> {
        let url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}/${regId}`;
        return this.http.put<Registration>(url, {'submitted': true} as Registration, httpOptions).pipe(
            catchError(this.handleError<Registration>('submitRegistration'))
        );
    }

    postRegistration(reg: Registration): Observable<Registration> {
        reg['ageGroup'] = "18-20";
        let url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}`;
        return this.http.post<Registration>(url, reg, httpOptions).pipe(
            catchError(this.handleError<Registration>('postRegistration'))
        );
    }

    // get data Registration
    getRegistration(id: string) {
        let url = null;
        if (Number.isNaN(parseInt(id))) {
            url = `${apiEndPoint}${id}`;
        } else {
            url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}/${id}`;
        }

        return this.http.get<Registration>(url).pipe(
            map((res) => {

                let dataRegistration: Registration = res;
                // console.log('dataRegistration', dataRegistration);
                return dataRegistration;
            }),
            catchError(this.handleError('getRegistration', []))
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

            if (operation === 'getRegistration') {
                // localStorage.removeItem('regId');
                localStorage.clear();
            }

            // TODO: send the error to remote logging infrastructure
            // console.error('error', error); // log to console instead
            // TODO: better job of transforming error for user consumption
            // console.log(`${operation} failed: ${error.message}`);

            // Let the app keep running by returning an empty result.
            return of(result as T);
        };
    }

}

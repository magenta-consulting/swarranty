import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

import { Observable, of } from 'rxjs';
import { apiEndPoint, apiEndPointBase, organisationPath } from '../../environments/environment';
import { Customer } from '../model/customer';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/ld+json' })
};

@Injectable({
  providedIn: 'root'
})
export class CustomerService {
  customersUrl = '/customers';
  customer: Customer;

  constructor(private http: HttpClient) {
  }

  postCustomer(customer: Customer): Observable<Customer> {
    delete customer.id;
    customer.homePostalCode = String(customer.homePostalCode);
    customer.telephone = String(customer.telephone);

    customer.organisation = `${apiEndPointBase}${organisationPath}/` + localStorage.getItem('orgId');
    let url = `${apiEndPoint}${apiEndPointBase}${this.customersUrl}`;

    return this.http.post<Customer>(url, customer, httpOptions).pipe(
      catchError(this.handleError<Customer>('postCustomer'))
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
      // console.error('error', error); // log to console instead
      // TODO: better job of transforming error for user consumption
      // console.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

}

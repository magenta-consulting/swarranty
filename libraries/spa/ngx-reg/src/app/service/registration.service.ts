import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {catchError, map, tap} from 'rxjs/operators';

import {Observable, of} from 'rxjs';
import {Brand} from '../model/brand';
import {apiEndPoint, apiEndPointBase, organisationPath} from '../../environments/environment';
import {BrandCategory} from '../model/brand-category';
import {Product} from '../model/product';
import {Dealer} from '../model/dealer';
import {Customer} from '../model/customer';
import {Warranty} from '../model/warranty';
import { Registration } from '../model/registration';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/ld+json' })
};

@Injectable({
  providedIn: 'root'
})
export class RegistrationService {
  registrationsUrl = '/registrations';
  registration: Registration;

  constructor(private http: HttpClient) {
  }

  postRegistration(reg: Registration): Observable<Registration> {
    let url = `${apiEndPoint}${apiEndPointBase}${this.registrationsUrl}`;
    return this.http.post<Registration>(url, reg, httpOptions).pipe(
      catchError(this.handleError<Registration>('postRegistration'))
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

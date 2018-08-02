import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '../../../node_modules/@angular/common/http';
import { Observable, of } from '../../../node_modules/rxjs';
import { apiEndPoint, apiEndPointBase } from '../../environments/environment';
import { catchError } from '../../../node_modules/rxjs/operators';

const httpOptions = {
  headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
};

@Injectable({
  providedIn: 'root'
})
export class NewsletterSubscriptionService {
  
  constructor(
    private http: HttpClient
  ) { }
  
  postNewsletterSubscription(name: string, email: string): Observable<any> {
    let url = `${apiEndPoint}${apiEndPointBase}/newsletter-subscriptions`;
    return this.http.post(url, {
      name: name,
      email: email
    }, httpOptions).pipe(
      catchError(this.handleError<any>('postNewsletterSubscription'))
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
        localStorage.removeItem('regId');
      }
      
      // TODO: send the error to remote logging infrastructure
      console.error('error', error); // log to console instead
      // TODO: better job of transforming error for user consumption
      console.log(`${operation} failed: ${error.message}`);
      
      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }
  
}

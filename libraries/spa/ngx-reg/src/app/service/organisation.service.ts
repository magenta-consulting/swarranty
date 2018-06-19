import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {catchError, map, tap} from 'rxjs/operators';
import {apiEndPoint, apiEndPointBase, apiEndPointMedia, organisationPath} from "../../environments/environment";

import {Organisation} from "../model/organisation";

const httpOptions = {
    headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
};

@Injectable({
    providedIn: 'root'
})
export class OrganisationService {


    constructor(private http: HttpClient) {
    }

    getOrganisation(): Observable<Organisation> {
        const orgId = localStorage.getItem('orgId');
        let url = `${apiEndPoint}${apiEndPointBase}${organisationPath}/${orgId}`;
        return this.http.get<any>(url).pipe(
            map((res) => {
                return res;
            }),
            catchError(this.handleError('getOrganisation', []))
        );
    }

    getLogo() {
        const orgId = localStorage.getItem('orgId');
        let url = `${apiEndPoint}${apiEndPointBase}${organisationPath}/${orgId}`;
        return this.http.get<Organisation>(url).pipe(
            map((res) => {
                //http://dev-swarranty.magentapulse.com/media-api/media/4/binaries/reference/view.json
                let logoId = res.logo.id;
                let logoSrc = `${apiEndPoint}${apiEndPointMedia}/media/${logoId}/binaries/reference/view.json`;
                //http://dev-swarranty.magentapulse.com/media-api/media/4/binaries/reference/view.json
                return logoSrc;
            }),
            catchError(this.handleError('getLogo' +
                '', []))
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

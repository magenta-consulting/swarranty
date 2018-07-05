import { Injectable } from '@angular/core';
import { Case } from "../model/case";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { apiEndPoint, apiEndPointBase } from '../../environments/environment'
import { map, catchError } from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class CaseService {
  warrantyCaseApiUrl = "/warranty-cases";
  url = `${apiEndPoint}${apiEndPointBase}${this.warrantyCaseApiUrl}`;
  token = localStorage.getItem('token');

  constructor(
    private http: HttpClient
  ) { }

  markCompleted(aCase: Case) {
    return this.http.put(`${this.url}/${aCase.id}`, {
      completed: true,
      status: "COMPLETED"
    }, {
      headers: new HttpHeaders({
        'Content-Type': 'application/ld+json',
        'Authorization': `Bearer ${this.token}`
      })
    }).pipe(
      map(res => res as Case),
      catchError((error, caught) => {
        console.log(error);
        return caught;
      })
    )
  }
}

import { Injectable } from '@angular/core';
import { Warranty } from '../model/warranty';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { apiEndPoint, apiEndPointBase } from '../../environments/environment'
import { map, catchError } from "rxjs/operators";
import { Product } from '../model/product';
import { Observable } from 'rxjs';
import { BsModalService } from 'ngx-bootstrap/modal';

@Injectable({
  providedIn: 'root'
})
export class WarrantyService {
  warrantyUrl = "/warranties";
  url = `${apiEndPoint}${apiEndPointBase}${this.warrantyUrl}`;
  token = localStorage.getItem('token');


  constructor(
    private http: HttpClient,
    private modal: BsModalService
  ) { }

  updateWarrantyProduct(warranty: Warranty): Observable<Warranty> {
    return this.http.put(`${this.url}/${warranty.id}`, {
      product: (warranty.product as Product).id
    }, {
      headers: new HttpHeaders({
        'Content-Type': 'application/ld+json',
        'Authorization': `Bearer ${this.token}`
      })
    }).pipe(
      map(res => res as any)
    )
  }

  updateWarrantyProductSerialNumber(warranty: Warranty): Observable<Warranty> {
    return this.http.put(`${this.url}/${warranty.id}`, {
      productSerialNumber: warranty.productSerialNumber
    }, {
      headers: new HttpHeaders({
        'Content-Type': 'application/ld+json',
        'Authorization': `Bearer ${this.token}`
      })
    }).pipe(
      map(res => res as any)
    )
  }
}

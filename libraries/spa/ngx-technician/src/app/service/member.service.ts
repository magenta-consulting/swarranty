import { Injectable, Input } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { apiEndPoint, apiEndPointBase } from '../../environments/environment'
import {catchError, map, tap} from 'rxjs/operators';
import { Observable } from 'rxjs';
import { Member } from '../model/member';
import { Case } from '../model/case';
import { BsModalService } from 'ngx-bootstrap/modal';
import { LoginModalComponent } from '../components/login-modal/login-modal.component';

@Injectable({
  providedIn: 'root'
})
export class MemberService {
  token: string;

  membersUrl = '/organisation-members';

  constructor(
    private http: HttpClient,
    private modal: BsModalService
  ) { }

  getMembers(organisation: number): Observable<Member[]> {
    this.token = localStorage.getItem('token');
    return this.http.get(`${apiEndPoint}${apiEndPointBase}${this.membersUrl}?organization=${organisation}`, {
      headers: new HttpHeaders({
        'Authorization': `Bearer ${this.token}`
      })
    })
    .pipe(
      map(res => {
        let members = res['hydra:member'];
        return members;
      }),
      catchError((error, caught) : Observable<void> => {
        let modal = this.modal.show(LoginModalComponent);
        return;
      })
    );
  }
}

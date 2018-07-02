import { Injectable, Input } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { apiEndPoint, apiEndPointBase } from '../../environments/environment'
import {catchError, map, tap} from 'rxjs/operators';
import { Observable } from 'rxjs';
import { Member } from '../model/member';
import { Case } from '../model/case';

@Injectable({
  providedIn: 'root'
})
export class MemberService {
  membersUrl = '/organisation-members';

  members: Observable<Member[]> = null;

  constructor(private http: HttpClient) { }


  getMembers(organisation: number): Observable<Member[]> {
    if (this.members == null) {
      this.members = this.http.get(`${apiEndPoint}${apiEndPointBase}${this.membersUrl}?organization=${organisation}`)
      .pipe(
        map(res => {
          let members = res['hydra:member'];
          return members;
        }),
        catchError((error, caught) : Observable<void> => {
          console.log(error);
          return caught;
        })
      )
    }
    return this.members;
  }
}

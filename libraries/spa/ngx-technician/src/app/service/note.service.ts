import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { apiEndPoint, apiEndPointBase } from '../../environments/environment'
import { ServiceNote } from '../model/service-note';

@Injectable({
  providedIn: 'root'
})
export class NoteService {
  noteApiUrl = '/service-notes';

  constructor(
    private http: HttpClient
  ) { }

  add(note: any) {
    return this.http.post(`${apiEndPoint}${apiEndPointBase}${this.noteApiUrl}`, note, {
      headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
    })
    .pipe(res => res);
  }

  update(note: any) {
    return this.http.put(`${apiEndPoint}${apiEndPointBase}${this.noteApiUrl}/${note.id}`, note, {
      headers: new HttpHeaders({'Content-Type': 'application/ld+json'})
    })
    .pipe(res => res);
  }

  delete(id: number) {
    return this.http.delete(`${apiEndPoint}${apiEndPointBase}${this.noteApiUrl}/${id}`)
    .pipe(res => res);
  }
}

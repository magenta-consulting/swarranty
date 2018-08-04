import { Observable, of } from "rxjs";
import { LoginModalComponent } from '../components/login-modal/login-modal.component';
import { HttpClient } from "@angular/common/http";
import { apiEndPoint, apiEndPointBase } from "../../environments/environment";
import { catchError } from "rxjs/operators";
import { BsModalService } from "ngx-bootstrap/modal";

export function decode(base64url: string) {
    try {
        //Convert base 64 url to base 64
        var base64 = base64url.replace('-', '+').replace('_', '/');
        //atob() is a built in JS function that decodes a base-64 encoded string
        var utf8 = atob(base64);
        //Then parse that into JSON
        var json = JSON.parse(utf8);
        //Then make that JSON look pretty
        var json_string = JSON.stringify(json, null, 4);
    } catch (err) {
        console.log(err);
    }
    return json;
}

export function exp(token: string) {
    var payload = token.split('\.')[1];
    return decode(payload).exp;
}

export function isExpired(token: string) {
    return exp(token)*1000 <= + new Date();
    // return true;
}

export function requireToken(service, callback) {
    var token = window.localStorage.getItem('token');
    var refresh = window.localStorage.getItem('refresh_token');
    if (isExpired(token)) {
        var http = service.http as HttpClient;
        http.post(`${apiEndPoint}${apiEndPointBase}/token/refresh`, {
            refresh_token: refresh
        })
        .pipe(
            catchError((error, caught): Observable<void> => {
                let modal = service.modal.show(LoginModalComponent);
                modal.content.callback = callback;
                return;
            })
        )
        .subscribe(res => {
            window.localStorage.setItem('token', res['token']);
            window.localStorage.setItem('refresh_token', res['refresh_token']);
            // console.log("Token refreshed");
            callback();
        });
    } else {
        // console.log("No need to refresh token");
        callback();
    }
}
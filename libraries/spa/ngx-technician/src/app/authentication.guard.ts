import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationGuard implements CanActivate {
  constructor(private router: Router) { }
  
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
    return this.checkToken();
  }

  getToken(): string {
    return localStorage.getItem('token');
  }

  checkToken(): boolean {
    var token = this.getToken();
    if (token === null || token.trim() === '') {
      this.router.navigate(['/login'])
      return false;
    }
    return true;
  }
}

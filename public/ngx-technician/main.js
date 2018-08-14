(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["main"],{

/***/ "./src/$$_lazy_route_resource lazy recursive":
/*!**********************************************************!*\
  !*** ./src/$$_lazy_route_resource lazy namespace object ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function webpackEmptyAsyncContext(req) {
	// Here Promise.resolve().then() is used instead of new Promise() to prevent
	// uncaught exception popping up in devtools
	return Promise.resolve().then(function() {
		var e = new Error('Cannot find module "' + req + '".');
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	});
}
webpackEmptyAsyncContext.keys = function() { return []; };
webpackEmptyAsyncContext.resolve = webpackEmptyAsyncContext;
module.exports = webpackEmptyAsyncContext;
webpackEmptyAsyncContext.id = "./src/$$_lazy_route_resource lazy recursive";

/***/ }),

/***/ "./src/app/app-routing.module.ts":
/*!***************************************!*\
  !*** ./src/app/app-routing.module.ts ***!
  \***************************************/
/*! exports provided: AppRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AppRoutingModule", function() { return AppRoutingModule; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _components_technicians_technicians_component__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/technicians/technicians.component */ "./src/app/components/technicians/technicians.component.ts");
/* harmony import */ var _components_technician_technician_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/technician/technician.component */ "./src/app/components/technician/technician.component.ts");
/* harmony import */ var _components_login_login_component__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/login/login.component */ "./src/app/components/login/login.component.ts");
/* harmony import */ var _authentication_guard__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./authentication.guard */ "./src/app/authentication.guard.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};





// import guard

var routes = [
    { path: '', component: _components_technicians_technicians_component__WEBPACK_IMPORTED_MODULE_2__["TechniciansComponent"], canActivate: [_authentication_guard__WEBPACK_IMPORTED_MODULE_5__["AuthenticationGuard"]] },
    { path: 'technician/:id', component: _components_technician_technician_component__WEBPACK_IMPORTED_MODULE_3__["TechnicianComponent"], canActivate: [_authentication_guard__WEBPACK_IMPORTED_MODULE_5__["AuthenticationGuard"]] },
    { path: 'login', component: _components_login_login_component__WEBPACK_IMPORTED_MODULE_4__["LoginComponent"] },
    { path: '**', redirectTo: '' },
];
var AppRoutingModule = /** @class */ (function () {
    function AppRoutingModule() {
    }
    AppRoutingModule = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["NgModule"])({
            imports: [_angular_router__WEBPACK_IMPORTED_MODULE_1__["RouterModule"].forRoot(routes)],
            exports: [_angular_router__WEBPACK_IMPORTED_MODULE_1__["RouterModule"]],
            declarations: []
        })
    ], AppRoutingModule);
    return AppRoutingModule;
}());



/***/ }),

/***/ "./src/app/app.component.html":
/*!************************************!*\
  !*** ./src/app/app.component.html ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"container\">\n  <div class=\"text-left\">\n    <a routerLink=\"/\"><img class=\"logo\" src=\"{{logoSrc}}\"></a>\n  </div>\n  <router-outlet></router-outlet>\n</div>\n\n<!--<h2 *ngFor=\"let item of data; index as i; first as isFirst\">-->\n  <!--{{item}} - <span *ngIf=\"isFirst\">default</span>-->\n<!--</h2>-->\n<!--<button class=\"btn btn-primary\" type=\"button\" (click)=\"addData()\">Add Item</button>-->\n"

/***/ }),

/***/ "./src/app/app.component.scss":
/*!************************************!*\
  !*** ./src/app/app.component.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".logo {\n  max-height: 120px;\n  width: auto;\n  margin-left: auto;\n  margin-right: auto;\n  margin-bottom: 30px;\n  display: block; }\n"

/***/ }),

/***/ "./src/app/app.component.ts":
/*!**********************************!*\
  !*** ./src/app/app.component.ts ***!
  \**********************************/
/*! exports provided: AppComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AppComponent", function() { return AppComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _service_organisation_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./service/organisation.service */ "./src/app/service/organisation.service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};



var AppComponent = /** @class */ (function () {
    function AppComponent(eRef, organisationService, router) {
        var _this = this;
        this.eRef = eRef;
        this.organisationService = organisationService;
        this.router = router;
        this.logoSrc = null;
        var native = eRef.nativeElement;
        var orgId = native.getAttribute('organisation');
        localStorage.setItem('orgId', orgId);
        organisationService.getLogo().subscribe(function (logoSrc) { return _this.logoSrc = logoSrc; });
    }
    AppComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'app-root',
            template: __webpack_require__(/*! ./app.component.html */ "./src/app/app.component.html"),
            styles: [__webpack_require__(/*! ./app.component.scss */ "./src/app/app.component.scss")]
        }),
        __metadata("design:paramtypes", [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"],
            _service_organisation_service__WEBPACK_IMPORTED_MODULE_2__["OrganisationService"],
            _angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"]])
    ], AppComponent);
    return AppComponent;
}());



/***/ }),

/***/ "./src/app/app.module.ts":
/*!*******************************!*\
  !*** ./src/app/app.module.ts ***!
  \*******************************/
/*! exports provided: AppModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AppModule", function() { return AppModule; });
/* harmony import */ var _angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/platform-browser */ "./node_modules/@angular/platform-browser/fesm5/platform-browser.js");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _app_component__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./app.component */ "./src/app/app.component.ts");
/* harmony import */ var _app_routing_module__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./app-routing.module */ "./src/app/app-routing.module.ts");
/* harmony import */ var _ng_select_ng_select__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ng-select/ng-select */ "./node_modules/@ng-select/ng-select/esm5/ng-select.js");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
/* harmony import */ var angular_font_awesome__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! angular-font-awesome */ "./node_modules/angular-font-awesome/dist/angular-font-awesome.es5.js");
/* harmony import */ var ngx_bootstrap_datepicker__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ngx-bootstrap/datepicker */ "./node_modules/ngx-bootstrap/datepicker/index.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _directive_focus_directive__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./directive/focus.directive */ "./src/app/directive/focus.directive.ts");
/* harmony import */ var _components_technicians_technicians_component__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./components/technicians/technicians.component */ "./src/app/components/technicians/technicians.component.ts");
/* harmony import */ var _components_technician_technician_component__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./components/technician/technician.component */ "./src/app/components/technician/technician.component.ts");
/* harmony import */ var _components_login_login_component__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./components/login/login.component */ "./src/app/components/login/login.component.ts");
/* harmony import */ var _extensions_angular2_image_upload__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./extensions/angular2-image-upload */ "./src/app/extensions/angular2-image-upload/index.js");
/* harmony import */ var _helper_helper__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ./helper/helper */ "./src/app/helper/helper.ts");
/* harmony import */ var _components_login_modal_login_modal_component__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! ./components/login-modal/login-modal.component */ "./src/app/components/login-modal/login-modal.component.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};











// import components



// import libs



var AppModule = /** @class */ (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
            declarations: [
                _app_component__WEBPACK_IMPORTED_MODULE_2__["AppComponent"],
                _directive_focus_directive__WEBPACK_IMPORTED_MODULE_10__["FocusDirective"],
                _components_technicians_technicians_component__WEBPACK_IMPORTED_MODULE_11__["TechniciansComponent"],
                _components_technician_technician_component__WEBPACK_IMPORTED_MODULE_12__["TechnicianComponent"],
                _components_login_login_component__WEBPACK_IMPORTED_MODULE_13__["LoginComponent"],
                _components_login_modal_login_modal_component__WEBPACK_IMPORTED_MODULE_16__["LoginModalComponent"]
            ],
            entryComponents: [
                _components_login_modal_login_modal_component__WEBPACK_IMPORTED_MODULE_16__["LoginModalComponent"]
            ],
            imports: [
                _angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__["BrowserModule"],
                _ng_select_ng_select__WEBPACK_IMPORTED_MODULE_4__["NgSelectModule"],
                _angular_forms__WEBPACK_IMPORTED_MODULE_5__["FormsModule"],
                _angular_common_http__WEBPACK_IMPORTED_MODULE_9__["HttpClientModule"],
                angular_font_awesome__WEBPACK_IMPORTED_MODULE_6__["AngularFontAwesomeModule"],
                ngx_bootstrap_datepicker__WEBPACK_IMPORTED_MODULE_7__["BsDatepickerModule"].forRoot(),
                ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_8__["ModalModule"].forRoot(),
                _app_routing_module__WEBPACK_IMPORTED_MODULE_3__["AppRoutingModule"],
                // import libs
                _extensions_angular2_image_upload__WEBPACK_IMPORTED_MODULE_14__["ImageUploadModule"].forRoot(),
            ],
            providers: [_helper_helper__WEBPACK_IMPORTED_MODULE_15__["Helper"]],
            bootstrap: [_app_component__WEBPACK_IMPORTED_MODULE_2__["AppComponent"]]
        })
    ], AppModule);
    return AppModule;
}());



/***/ }),

/***/ "./src/app/authentication.guard.ts":
/*!*****************************************!*\
  !*** ./src/app/authentication.guard.ts ***!
  \*****************************************/
/*! exports provided: AuthenticationGuard */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AuthenticationGuard", function() { return AuthenticationGuard; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};


var AuthenticationGuard = /** @class */ (function () {
    function AuthenticationGuard(router) {
        this.router = router;
    }
    AuthenticationGuard.prototype.canActivate = function (next, state) {
        return this.checkToken();
    };
    AuthenticationGuard.prototype.getToken = function () {
        return localStorage.getItem('token');
    };
    AuthenticationGuard.prototype.checkToken = function () {
        var token = this.getToken();
        if (token === null || token.trim() === '') {
            this.router.navigate(['/login']);
            return false;
        }
        return true;
    };
    AuthenticationGuard = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"]])
    ], AuthenticationGuard);
    return AuthenticationGuard;
}());



/***/ }),

/***/ "./src/app/components/login-modal/login-modal.component.html":
/*!*******************************************************************!*\
  !*** ./src/app/components/login-modal/login-modal.component.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"container\">\n    <form class=\"form-signin\" action=\"#\">\n        <h2 class=\"form-signin-heading\">Login</h2>\n        <label for=\"inputEmail\" class=\"sr-only\">Email address</label>\n        <input name=\"email\" [(ngModel)]=\"email\" type=\"email\" id=\"inputEmail\" class=\"form-control\" placeholder=\"Email address\" required autofocus>\n        <label for=\"inputPassword\" class=\"sr-only\">Password</label>\n        <input name=\"password\" [(ngModel)]=\"password\" type=\"password\" id=\"inputPassword\" class=\"form-control\" placeholder=\"Password\" required>\n        <p *ngIf=\"!loading\" class=\"text-danger\">{{message}}</p>\n        <button *ngIf=\"!loading\" class=\"btn btn-primary btn-block\" type=\"submit\" (click)=\"login()\">Log in</button>\n        <button *ngIf=\"loading\" class=\"btn btn-primary btn-block\" type=\"submit\" (click)=\"login()\" disabled>Loading...</button>\n    </form>\n</div>"

/***/ }),

/***/ "./src/app/components/login-modal/login-modal.component.scss":
/*!*******************************************************************!*\
  !*** ./src/app/components/login-modal/login-modal.component.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "input {\n  margin-bottom: 5px; }\n\nform {\n  margin: 15px; }\n"

/***/ }),

/***/ "./src/app/components/login-modal/login-modal.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/components/login-modal/login-modal.component.ts ***!
  \*****************************************************************/
/*! exports provided: LoginModalComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoginModalComponent", function() { return LoginModalComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var LoginModalComponent = /** @class */ (function () {
    function LoginModalComponent(http, router, _bsModalRef) {
        this.http = http;
        this.router = router;
        this._bsModalRef = _bsModalRef;
        this.loading = false;
    }
    LoginModalComponent.prototype.ngOnInit = function () {
    };
    LoginModalComponent.prototype.login = function () {
        var _this = this;
        this.loading = true;
        this.http.post(_environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + '/login_check', {
            email: this.email,
            password: this.password
        })
            .subscribe(function (res) {
            localStorage.setItem('token', res.token);
            localStorage.setItem('refresh_token', res.refresh_token);
            _this._bsModalRef.hide();
            _this.callback();
        }, function (error) {
            _this.message = 'Invalid email or password!';
            _this.loading = false;
        });
    };
    LoginModalComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'app-login-modal',
            template: __webpack_require__(/*! ./login-modal.component.html */ "./src/app/components/login-modal/login-modal.component.html"),
            styles: [__webpack_require__(/*! ./login-modal.component.scss */ "./src/app/components/login-modal/login-modal.component.scss")]
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"],
            _angular_router__WEBPACK_IMPORTED_MODULE_3__["Router"],
            ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__["BsModalRef"]])
    ], LoginModalComponent);
    return LoginModalComponent;
}());



/***/ }),

/***/ "./src/app/components/login/login.component.html":
/*!*******************************************************!*\
  !*** ./src/app/components/login/login.component.html ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"container\">\n    <form class=\"form-signin\" action=\"#\">\n        <h2 class=\"form-signin-heading\">Log In</h2>\n        <label for=\"inputEmail\" class=\"sr-only\">Email address</label>\n        <input name=\"email\" [(ngModel)]=\"email\" type=\"email\" id=\"inputEmail\" class=\"form-control\" placeholder=\"Email address\" required autofocus>\n        <label for=\"inputPassword\" class=\"sr-only\">Password</label>\n        <input name=\"password\" [(ngModel)]=\"password\" type=\"password\" id=\"inputPassword\" class=\"form-control\" placeholder=\"Password\" required>\n        <!-- <div class=\"checkbox\">\n            <label>\n                <input type=\"checkbox\" value=\"remember-me\"> Remember me\n            </label>\n        </div> -->\n        <p *ngIf=\"!loading\" class=\"text-danger\">{{message}}</p>\n        <button *ngIf=\"!loading\" class=\"btn btn-primary btn-block\" type=\"submit\" (click)=\"login()\">Log in</button>\n        <button *ngIf=\"loading\" class=\"btn btn-primary btn-block\" type=\"submit\" (click)=\"login()\" disabled>Loading...</button>\n    </form>\n</div>"

/***/ }),

/***/ "./src/app/components/login/login.component.scss":
/*!*******************************************************!*\
  !*** ./src/app/components/login/login.component.scss ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "input {\n  margin-bottom: 5px; }\n"

/***/ }),

/***/ "./src/app/components/login/login.component.ts":
/*!*****************************************************!*\
  !*** ./src/app/components/login/login.component.ts ***!
  \*****************************************************/
/*! exports provided: LoginComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoginComponent", function() { return LoginComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var LoginComponent = /** @class */ (function () {
    function LoginComponent(http, router) {
        this.http = http;
        this.router = router;
        this.loading = false;
    }
    LoginComponent.prototype.ngOnInit = function () {
    };
    LoginComponent.prototype.login = function () {
        var _this = this;
        this.loading = true;
        this.http.post(_environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + '/login_check', {
            email: this.email,
            password: this.password
        })
            .subscribe(function (res) {
            localStorage.setItem('token', res.token);
            localStorage.setItem('refresh_token', res.refresh_token);
            _this.router.navigateByUrl('/');
        }, function (error) {
            _this.message = 'Invalid email or password!';
            _this.loading = false;
        });
    };
    LoginComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'app-login',
            template: __webpack_require__(/*! ./login.component.html */ "./src/app/components/login/login.component.html"),
            styles: [__webpack_require__(/*! ./login.component.scss */ "./src/app/components/login/login.component.scss")]
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"],
            _angular_router__WEBPACK_IMPORTED_MODULE_3__["Router"]])
    ], LoginComponent);
    return LoginComponent;
}());



/***/ }),

/***/ "./src/app/components/technician/technician.component.html":
/*!*****************************************************************!*\
  !*** ./src/app/components/technician/technician.component.html ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div *ngIf=\"case != null\" class=\"tech-wrap tech-detail\">\n    <div class=\"tech-blk\">\n        <h4 class=\"tech-sub-ttl\">Customer Details</h4>\n        <table>\n            <tr>\n                <td class=\"td-name\">Full name</td>\n                <td> : {{case.warranty.customer.name}}</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Contact no</td>\n                <td> : +{{case.warranty.customer.dialingCode}}-{{case.warranty.customer.telephone}}</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Email</td>\n                <td> : {{case.warranty.customer.email}}</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Address</td>\n                <td>: {{case.warranty.customer.homeAddress}}</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Postal Code</td>\n                <td>: {{case.warranty.customer.homePostalCode}} <a href=\"https://www.google.com/maps/place/{{case.warranty.customer.homeAddress}}\" target=\"_blank\">(Get Directions)</a></td>\n            </tr>\n        </table>\n    </div>\n    <div class=\"tech-blk\">\n        <h4 class=\"tech-sub-ttl\">Case Details</h4>\n        <table>\n            <tr>\n                <td class=\"td-name\">Case no</td>\n                <td> : {{case.number}}</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Date Created</td>\n                <td> : {{case.createdAt | date: 'dd - MM - y'}} by {{case.warranty.customer.name}}</td>\n            </tr>\n            <ng-container *ngIf=\"!case.completed\">\n                <tr>\n                    <td colspan=\"2\">\n                        <div *ngIf=\"isEditing['product']\" style=\"display: inline-block\">\n                            <div class=\"input-group\">\n                                <ng-select class=\"ipt-select\" (change)=\"selectBrand($event,case.warranty)\" [items]=\"case.warranty.brands\"\n                                    bindLabel=\"name\" placeholder=\"(*) Product Brand\" [(ngModel)]=\"case.warranty.selectedBrand\">\n                                </ng-select>\n                            </div>\n                        </div>\n                        <div *ngIf=\"!isEditing['product']\" (click)=\"isEditing['product'] = true\" style=\"display: inline-block;\">\n                            <div class=\"input-group preview-container\" style=\"width: 300px\">\n                                <div class=\"input-group-prepend preview-label\">\n                                    <span class=\"input-group-text\">Product Brand </span>\n                                </div>\n                                <div class=\"form-control preview-text\">\n                                    <span>{{case.warranty.selectedBrand?.name}}</span>\n                                </div>\n                                <div class=\"input-group-append\">\n                                    <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                                </div>\n                            </div>\n                        </div>\n                    </td>\n                </tr>\n                <tr>\n                  <td colspan=\"2\">\n                        <div *ngIf=\"isEditing['product']\" style=\"display: inline-block\">\n                            <div class=\"input-group\">\n                                <ng-select class=\"ipt-select\" (change)=\"selectCategory($event,case.warranty)\" [items]=\"case.warranty.categories\"\n                                    bindLabel=\"name\" placeholder=\"(*) Product Category\"\n                                    [(ngModel)]=\"case.warranty.selectedCategory\">\n                                </ng-select>\n                            </div>\n                        </div>\n                        <div *ngIf=\"!isEditing['product']\" (click)=\"isEditing['product'] = true\" style=\"display: inline-block;\">\n                            <div class=\"input-group preview-container\" style=\"width: 300px\">\n                                <div class=\"input-group-prepend preview-label\">\n                                    <span class=\"input-group-text\">Product Category </span>\n                                </div>\n                                <div class=\"form-control preview-text\">\n                                    <span>{{case.warranty.selectedCategory?.name}}</span>\n                                </div>\n                                <div class=\"input-group-append\">\n                                    <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                                </div>\n                            </div>\n                        </div>\n                    </td>\n                </tr>\n                <tr>\n                  <td colspan=\"2\">\n                        <div *ngIf=\"isEditing['product']\" style=\"display: inline-block\">\n                            <div class=\"input-group\">\n                                <ng-select class=\"ipt-select\" placeholder=\"(*) Model Name\"\n                                    [items]=\"case.warranty.products\" bindLabel=\"name\" [(ngModel)]=\"case.warranty.product\"\n                                    (change)=\"selectProduct($event,case.warranty)\" (blur)=\"isEditing['product']=false\">\n                                </ng-select>\n                                <div *ngIf=\"isSaving['product']\">Saving...</div>\n                            </div>\n                        </div>\n                        <div *ngIf=\"!isEditing['product']\" (click)=\"isEditing['product'] = true\" style=\"display: inline-block;\">\n                            <div class=\"input-group preview-container\" style=\"width: 300px\">\n                                <div class=\"input-group-prepend preview-label\">\n                                    <span class=\"input-group-text\">Model Name </span>\n                                </div>\n                                <div class=\"form-control preview-text\">\n                                    <span>{{case.warranty.product?.name}}</span>\n                                </div>\n                                <div class=\"input-group-append\">\n                                    <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                                </div>\n                            </div>\n                        </div>\n                    </td>\n                </tr>\n                <tr>\n                    <td class=\"td-name\">Model Number</td>\n                    <td>: {{ case.warranty.product?.modelNumber ? case.warranty.product?.modelNumber : '' }}</td>\n                </tr>\n                <tr>\n                    <td colspan=\"2\">\n                        <div *ngIf=\"isEditing['serial']\" style=\"display: inline-block\">\n                            <div class=\"input-group\">\n                                <input type=\"text\" class=\"ipt\" [(ngModel)]=\"case.warranty.productSerialNumber\"\n                                    (keyup.enter)=\"updateSerialNumber()\" (blur)=\"updateSerialNumber()\"/>\n                                <div *ngIf=\"isSaving['serial']\">Saving...</div>\n                            </div>\n                        </div>\n                        <div *ngIf=\"!isEditing['serial']\" (click)=\"isEditing['serial'] = true\" style=\"display: inline-block;\">\n                            <div class=\"input-group preview-container\" style=\"width: 300px\">\n                                <div class=\"input-group-prepend preview-label\">\n                                    <span class=\"input-group-text\">Serial Number </span>\n                                </div>\n                                <div class=\"form-control preview-text\">\n                                    <span>{{case.warranty.productSerialNumber}}</span>\n                                </div>\n                                <div class=\"input-group-append\">\n                                    <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                                </div>\n                            </div>\n                        </div>\n                    </td>\n                </tr>\n            </ng-container>\n            <ng-container *ngIf=\"case.completed\">\n                <tr>\n                    <td class=\"td-name\">Product Brand</td>\n                    <td>: {{case.warranty.selectedBrand?.name}}</td>\n                </tr>\n                <tr>\n                    <td class=\"td-name\">Product Category</td>\n                    <td>: {{case.warranty.selectedCategory?.name}}</td>\n                </tr>\n                <tr>\n                    <td class=\"td-name\">Model Name</td>\n                    <td>: {{case.warranty.product?.name}}</td>\n                </tr>\n                <tr>\n                    <td class=\"td-name\">Model Number</td>\n                    <td>: {{ case.warranty.product?.modelNumber ? case.warranty.product?.modelNumber : '' }}</td>\n                </tr>\n                <tr>\n                    <td class=\"td-name\">Serial Number</td>\n                    <td>: {{case.warranty.productSerialNumber}}</td>\n                </tr>\n            </ng-container>\n            <tr>\n                <td class=\"td-name\">Date Closed</td>\n                <td>: N.A</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Technician</td>\n                <td>: {{currentServiceSheet.appointment.assigneeName}}</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Service Zone</td>\n                <td>: {{case.serviceZone.name}}</td>\n            </tr>\n            <tr>\n                <td class=\"td-name\">Appointment</td>\n                <td>: {{case.appointmentAt | date: 'dd - MM - y, HH:mm'}}</td>\n            </tr>\n        </table>\n    </div>\n    <div class=\"tech-blk\">\n        <h4 class=\"tech-sub-ttl\">Case Details</h4>\n        <!-- <p>What ever they want to write about the case when the customer called in.</p> -->\n        <!-- <input type=\"text\" class=\"ipt full\" placeholder=\"Add Case Detail\" [value]=\"case.description\"/> -->\n        <div [innerHTML]=\"case.description\"></div>\n    </div>\n    <div class=\"tech-blk\">\n        <h4 class=\"tech-sub-ttl\">Service/Case Notes</h4>\n        <div class=\"note-list\">\n            <ng-container *ngIf=\"!case.completed\">\n                <div *ngFor=\"let note of case.serviceNotes\" class=\"note-item\">\n                    <div *ngIf=\"note == currentAppointmentNote\">\n                        <div *ngIf=\"isEditing['description']\">\n                            <div class=\"input-group mb-2\">\n                                <input [(ngModel)]=\"note.description\" type=\"text\" class=\"form-control\" placeholder=\"Description\"\n                                    aria-label=\"Description\"\n                                    (keyup.enter)=\"updateNote()\"\n                                    (blur)=\"isEditing['description'] = false\">\n                                    <div *ngIf=\"isSaving['note']\">Saving...</div>\n                                </div>\n                        </div>\n                        <div *ngIf=\"!isEditing['description']\" (click)=\"isEditing['description'] = true\">\n                            <div class=\"input-group mb-2 preview-container\">\n                                <div class=\"input-group-prepend preview-label\">\n                                    <span class=\"input-group-text\">Description </span>\n                                </div>\n                                <div class=\"form-control preview-text\">\n                                    <span [innerHTML]=\"note.description\"></span>\n                                </div>\n                                <div class=\"input-group-append\">\n                                    <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                    <div *ngIf=\"note != currentAppointmentNote\">\n                        <p>{{note.description}}</p>\n                    </div>\n                    <p>\n                        {{note.appointment.assigneeName}} | {{note.appointment.appointmentAt | date: \"d MMMM y\"}} | <span (click)=\"deleteNote(note)\">Delete</span>\n                    </p>\n                </div>\n            </ng-container>\n            <ng-container *ngIf=\"case.completed\">\n                <div *ngFor=\"let note of case.serviceNotes\" class=\"note-item\">\n                    <div>\n                        <p style=\"color: black\">{{note.description}}</p>\n                    </div>\n                    <p>\n                        {{note.appointment.assigneeName}} | {{note.appointment.appointmentAt | date: \"d MMMM y\"}}\n                    </p>\n                </div>\n            </ng-container>\n        </div>\n        <div *ngIf=\"currentAppointmentNote == null\">\n            <input type=\"text\" class=\"ipt full\" placeholder=\"Add New Case Notes/Service Rendered\" [(ngModel)]=\"noteDescription\" (keyup.enter)=\"addNote()\"/>\n            <div *ngIf=\"isSaving['note']\">Saving...</div>\n        </div>\n    </div>\n    <div class=\"tech-blk\">\n        <ng-container *ngIf=\"!case.completed\">\n            <image-upload\n                class=\"custome-upload\"\n                partName=\"binaryContent\"\n                [url]=\"uploadUrl\"\n                [uploadedFiles]=\"imageUrls\"\n                [beforeUpload]=\"onBeforeUpload\"\n                (removed)=\"onRemoved($event)\"\n                (uploadFinished)=\"onUploadFinished($event, 1)\"\n                (uploadStateChanged)=\"onUploadStateChanged($event)\"\n                buttonCaption=\"UPLOAD SERVICE INVOICE IMAGE\">\n            </image-upload>\n        </ng-container>\n        <ng-container *ngIf=\"case.completed\">\n            <div class=\"case-images\">\n                <img *ngFor=\"let url of imageUrls\" src=\"{{url}}\" alt=\"\" width=\"56px\" height=\"56px\" style=\"object-fit: cover; margin: 5px\">\n            </div>\n        </ng-container>\n        <div class=\"text-center\">\n            <button class=\"btn btn-primary btn-mark\" routerLink=\"/\">Back</button>\n            <button *ngIf=\"!case.completed\" class=\"btn btn-green btn-mark\" (click)=\"markCompleted()\">Mark Completed</button>\n            <span *ngIf=\"isSaving['status']\">Saving...</span>\n            <!-- <button *ngIf=\"case.completed\" class=\"btn btn-green btn-mark\" (click)=\"markCompleted()\" disabled>Completed</button> -->\n            <button class=\"btn btn-danger\" (click)=\"logout()\">Log out</button>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/components/technician/technician.component.ts":
/*!***************************************************************!*\
  !*** ./src/app/components/technician/technician.component.ts ***!
  \***************************************************************/
/*! exports provided: TechnicianComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TechnicianComponent", function() { return TechnicianComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var _service_member_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../service/member.service */ "./src/app/service/member.service.ts");
/* harmony import */ var _service_product_service__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../service/product.service */ "./src/app/service/product.service.ts");
/* harmony import */ var _helper_helper__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../helper/helper */ "./src/app/helper/helper.ts");
/* harmony import */ var _model_service_note__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../model/service-note */ "./src/app/model/service-note.ts");
/* harmony import */ var _service_note_service__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../../service/note.service */ "./src/app/service/note.service.ts");
/* harmony import */ var _service_case_service__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../../service/case.service */ "./src/app/service/case.service.ts");
/* harmony import */ var _service_warranty_service__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../../service/warranty.service */ "./src/app/service/warranty.service.ts");
/* harmony import */ var _helper_token__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../../helper/token */ "./src/app/helper/token.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};











var TechnicianComponent = /** @class */ (function () {
    function TechnicianComponent(memberService, productService, noteService, caseService, warrantyService, route, router, helper) {
        var _this = this;
        this.memberService = memberService;
        this.productService = productService;
        this.noteService = noteService;
        this.caseService = caseService;
        this.warrantyService = warrantyService;
        this.route = route;
        this.router = router;
        this.helper = helper;
        this.isLoading = false;
        this.case = null;
        this.uploadUrl = _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointMedia"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiMediaUploadPath"];
        this.imageUrls = [];
        this.isEditing = [];
        this.isSaving = [];
        /* =========================================== */
        /** Actions in this Comp */
        // 1. Event uploads
        this.onBeforeUpload = function (metadata) {
            var apiUploadWarranty = _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointMedia"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiMediaUploadPath"];
            var warId = metadata.url.substring(apiUploadWarranty.length + 1);
            metadata.formData = {
                "imageServiceSheet": _this.currentServiceSheet.id,
                "context": "receipt_image"
            };
            metadata.url = apiUploadWarranty;
            return metadata;
        };
        Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(memberService, function () { return memberService.getMembers(1).subscribe(function (members) {
            _this.cases = members[0].assignedCases;
            _this.cases.forEach(function (element) {
                if (element.id == _this.id) {
                    _this.case = element;
                    console.log(element);
                }
            });
            _this.findCurrentAppointment();
            _this.loadProductList();
            console.log(_this.case);
        }); });
    }
    TechnicianComponent.prototype.loadProductList = function () {
        var _this = this;
        this.case.warranty.selectedBrand = this.case.warranty.product['brand'];
        this.case.warranty.selectedBrand.id = this.case.warranty.selectedBrand["@id"];
        this.case.warranty.selectedCategory = this.case.warranty.product['category'];
        this.case.warranty.selectedCategory.id = this.case.warranty.selectedCategory["@id"];
        Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(this.productService, function () { return _this.productService.getBrands().subscribe(function (brands) { return _this.case.warranty.brands = brands; }); });
        this.selectBrand(null, this.case.warranty);
        this.selectCategory(null, this.case.warranty);
    };
    TechnicianComponent.prototype.findCurrentAppointment = function () {
        var _this = this;
        this.case.appointments.forEach(function (appointment) {
            if (appointment.appointmentAt == _this.case.appointmentAt) {
                _this.case.currentAppointment = appointment;
            }
        });
        this.case.serviceNotes.forEach(function (note) {
            if (note.appointment.appointmentAt == _this.case.appointmentAt) {
                _this.currentAppointmentNote = note;
            }
        });
        this.case.serviceSheets.forEach(function (sheet) {
            if (sheet.appointment.appointmentAt == _this.case.appointmentAt) {
                _this.currentServiceSheet = sheet;
            }
        });
        this.currentServiceSheet.images.forEach(function (img) {
            _this.imageUrls.push(_environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointMedia"] + '/media/' + img.id + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["binariesMedia"]);
        });
    };
    TechnicianComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.sub = this.route.params.subscribe(function (params) {
            _this.id = params['id'];
        });
    };
    TechnicianComponent.prototype.ngOnDestroy = function () {
        this.sub.unsubscribe();
    };
    TechnicianComponent.prototype.ngAfterViewInit = function () {
    };
    TechnicianComponent.prototype.onUploadFinished = function (file, warId) {
        console.log('finished', file);
    };
    TechnicianComponent.prototype.onRemoved = function (file) {
        var _this = this;
        var splitUrlMedia = this.helper.explode('/media/', file.src, undefined);
        var imgId = this.helper.explode(_environments_environment__WEBPACK_IMPORTED_MODULE_2__["binariesMedia"], splitUrlMedia[1], undefined);
        if (imgId == null) {
            return;
        }
        Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(this.productService, function () { return _this.productService.deleteWarrantyImg(parseInt(imgId[0])).subscribe(function (res) {
            console.log('res', res);
        }, function (error) {
            console.log('Error', error);
        }, function () {
            console.log('Complete Request');
        }); });
    };
    TechnicianComponent.prototype.onUploadStateChanged = function (state) {
        console.log('state', state);
    };
    TechnicianComponent.prototype.selectBrand = function (e, warranty) {
        var _this = this;
        var brand = warranty.selectedBrand;
        if (brand == null) {
            warranty.selectedCategory = null;
            warranty.product = null;
            return;
        }
        if (brand.id !== null) {
            warranty.categories = [{ id: null, name: 'Loading' }];
            warranty.isProductHidden = true;
            warranty.isCategoryHidden = true;
            Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(this.productService, function () { return _this.productService.getCategories(brand.id).subscribe(function (cats) {
                warranty.categories = cats;
                warranty.isCategoryHidden = false;
            }); });
        }
    };
    TechnicianComponent.prototype.selectCategory = function (e, warranty) {
        var _this = this;
        if (warranty.selectedCategory == null) {
            warranty.product = null;
            return;
        }
        if (warranty.selectedCategory.id !== null) {
            warranty.products = [{ id: null, name: 'Loading' }];
            warranty.isProductHidden = true;
            Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(this.productService, function () { return _this.productService.getProductsByCategory(warranty.selectedCategory.id).subscribe(function (prods) {
                warranty.products = prods;
                warranty.isProductHidden = false;
                warranty.selectedProduct = null;
            }); });
        }
    };
    TechnicianComponent.prototype.selectProduct = function (e, warranty) {
        var _this = this;
        this.isSaving['product'] = true;
        Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(this.warrantyService, function () { return _this.warrantyService.updateWarrantyProduct(warranty).subscribe(function (res) {
            _this.isSaving['product'] = false;
            _this.case.warranty.product = res.product;
        }); });
    };
    TechnicianComponent.prototype.deleteNote = function (note) {
        this.noteService.delete(note.id).subscribe(function (res) { });
        if (note == this.currentAppointmentNote) {
            this.currentAppointmentNote = null;
        }
        this.case.serviceNotes.splice(this.case.serviceNotes.indexOf(note), 1);
    };
    TechnicianComponent.prototype.updateNote = function () {
        var _this = this;
        this.isSaving['note'] = true;
        var note = {
            appointment: "/api/case-appointments/" + this.case.currentAppointment.id,
            case: "/api/warranty-cases/" + this.case.id,
            description: this.currentAppointmentNote.description,
            id: this.currentAppointmentNote.id
        };
        this.noteService.update(note).subscribe(function (res) {
            _this.isEditing['description'] = false;
            _this.isSaving['note'] = false;
        });
    };
    TechnicianComponent.prototype.addNote = function () {
        var _this = this;
        this.isSaving['note'] = true;
        var note = {
            appointment: "/api/case-appointments/" + this.case.currentAppointment.id,
            case: "/api/warranty-cases/" + this.case.id,
            description: this.noteDescription
        };
        this.noteService.add(note).subscribe(function (res) {
            _this.currentAppointmentNote = new _model_service_note__WEBPACK_IMPORTED_MODULE_6__["ServiceNote"]();
            _this.currentAppointmentNote.appointment = _this.case.currentAppointment;
            _this.currentAppointmentNote.description = _this.noteDescription;
            _this.currentAppointmentNote.id = res['id'];
            _this.case.serviceNotes.push(_this.currentAppointmentNote);
            _this.isSaving['note'] = false;
        });
    };
    TechnicianComponent.prototype.updateSerialNumber = function () {
        var _this = this;
        this.isSaving['serial'] = true;
        Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(this.warrantyService, function () { return _this.warrantyService.updateWarrantyProductSerialNumber(_this.case.warranty).subscribe(function (res) {
            _this.case.warranty.productSerialNumber = res.productSerialNumber;
            _this.isSaving['serial'] = false;
            _this.isEditing['serial'] = false;
        }); });
    };
    TechnicianComponent.prototype.markCompleted = function () {
        var _this = this;
        this.isSaving['status'] = true;
        Object(_helper_token__WEBPACK_IMPORTED_MODULE_10__["requireToken"])(this.caseService, function () { return _this.caseService.markCompleted(_this.case).subscribe(function (res) {
            _this.case.completed = res.completed;
            _this.case.status = res.status;
            _this.isSaving['status'] = false;
        }); });
    };
    TechnicianComponent.prototype.logout = function () {
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_token');
        this.router.navigateByUrl('/login');
    };
    TechnicianComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'technician',
            template: __webpack_require__(/*! ./technician.component.html */ "./src/app/components/technician/technician.component.html"),
            styles: [__webpack_require__(/*! ../technicians/technicians.component.scss */ "./src/app/components/technicians/technicians.component.scss")]
        }),
        __metadata("design:paramtypes", [_service_member_service__WEBPACK_IMPORTED_MODULE_3__["MemberService"],
            _service_product_service__WEBPACK_IMPORTED_MODULE_4__["ProductService"],
            _service_note_service__WEBPACK_IMPORTED_MODULE_7__["NoteService"],
            _service_case_service__WEBPACK_IMPORTED_MODULE_8__["CaseService"],
            _service_warranty_service__WEBPACK_IMPORTED_MODULE_9__["WarrantyService"],
            _angular_router__WEBPACK_IMPORTED_MODULE_1__["ActivatedRoute"],
            _angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"],
            _helper_helper__WEBPACK_IMPORTED_MODULE_5__["Helper"]])
    ], TechnicianComponent);
    return TechnicianComponent;
}());



/***/ }),

/***/ "./src/app/components/technicians/technicians.component.html":
/*!*******************************************************************!*\
  !*** ./src/app/components/technicians/technicians.component.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"tech-wrap\">\n    <ul class=\"nav nav-tabs\">\n        <li class=\"nav-item\">\n            <a class=\"nav-link active\" href=\"javascript:;\" (click)=\"switchTab($event, '#tab-assign')\">Assigned/Responded Jobs</a>\n        </li>\n        <li class=\"nav-item\">\n            <a class=\"nav-link\" href=\"javascript:;\" (click)=\"switchTab($event, '#tab-complete')\">Completed Jobs</a>\n        </li>\n    </ul>\n    <div class=\"tab-content\" id=\"myTabContent\">\n        <div class=\"tab-pane fade in show active\" id=\"tab-assign\">\n            <div class=\"tech-list\">\n                <div *ngIf=\"!cases\">\n                    Loading...\n                </div>\n                <div *ngIf=\"cases && uncompletedCount == 0\">\n                    You have no Assigned/Responded Jobs\n                </div>\n                <ng-container *ngFor=\"let case of cases\">\n                    <div *ngIf=\"!case.completed\" class=\"tech-item\">\n                        <div class=\"tech-blk\">\n                            <h3 class=\"tech-ttl\">{{case.warranty.customer.name}}</h3>\n                            <div class=\"tech-info\">\n                                <div class=\"row\">\n                                    <div class=\"info-left col-md-8 col-sm-8 col-xs-12\">\n                                        <table>\n                                            <tr>\n                                                <td class=\"td-name\">Address</td>\n                                                <td>: {{case.warranty.customer.homeAddress}}</td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Contact</td>\n                                                <td>: {{case.warranty.customer.telephone}}</td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Case Date</td>\n                                                <td>: {{case.appointmentAt | date: \"d MMMM y\"}}</td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Case no</td>\n                                                <td>: {{case.number}} | Status: <span class=\"status\">{{case.status}}</span></td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Service Zone</td>\n                                                <td>: {{case.serviceZone.name}}</td>\n                                            </tr>\n                                        </table>\n                                    </div>\n                                    <div class=\"info-right col-md-4 col-sm-4 col-xs-12 text-right\">\n                                        <a routerLink=\"/technician/{{case.id}}\" class=\"more btn btn-green\">View Job</a>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                        <div class=\"tech-blk\">\n                            <h4 class=\"tech-sub-ttl\">Product</h4>\n                            <p>\n                                Brand: {{case.warranty.product.brand.name}} | \n                                Model Number: {{case.warranty.product.modelNumber}} | \n                                Model Name: {{case.warranty.product.name}} | \n                                Serial Number: {{case.warranty.productSerialNumber}}\n                            </p>\n                        </div>\n                        <div class=\"tech-blk\">\n                            <h4 class=\"tech-sub-ttl\">Case Details:</h4>\n                            <div [innerHTML]=\"case.description\"></div>\n                        </div>\n                        <div class=\"tech-blk tech-more\">\n                            <a routerLink=\"/technician/{{case.id}}\" class=\"more btn btn-green\">View Job</a>\n                        </div>\n                    </div>\n                </ng-container>\n            </div>\n        </div>\n        <div class=\"tab-pane\" id=\"tab-complete\">\n            <div class=\"tech-list\">\n                <div *ngIf=\"!cases\">\n                    Loading...\n                </div>\n                <div *ngIf=\"cases && completedCount == 0\">\n                    You have no Completed Jobs\n                </div>\n                <ng-container *ngFor=\"let case of cases\">\n                    <div *ngIf=\"case.completed\" class=\"tech-item\">\n                        <div class=\"tech-blk\">\n                            <h3 class=\"tech-ttl\">{{case.warranty.customer.name}}</h3>\n                            <div class=\"tech-info\">\n                                <div class=\"row\">\n                                    <div class=\"info-left col-md-8 col-sm-8 col-xs-12\">\n                                        <table>\n                                            <tr>\n                                                <td class=\"td-name\">Address</td>\n                                                <td>: {{case.warranty.customer.homeAddress}}</td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Contact</td>\n                                                <td>: {{case.warranty.customer.telephone}}</td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Case Date</td>\n                                                <td>: {{case.appointmentAt | date: \"d MMMM y\"}}</td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Case no</td>\n                                                <td>: {{case.number}} | Status: <span class=\"status {{case.status | lowercase}}\">{{case.status}}</span></td>\n                                            </tr>\n                                            <tr>\n                                                <td class=\"td-name\">Service Zone</td>\n                                                <td>: {{case.serviceZone.name}}</td>\n                                            </tr>\n                                        </table>\n                                    </div>\n                                    <div class=\"info-right col-md-4 col-sm-4 col-xs-12 text-right\">\n                                        <a routerLink=\"/technician/{{case.id}}\" class=\"more btn btn-green\">View Job</a>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                        <div class=\"tech-blk\">\n                            <h4 class=\"tech-sub-ttl\">Product</h4>\n                            <p>\n                                Brand: {{case.warranty.product.brand.name}} | \n                                Model Number: {{case.warranty.product.modelNumber}} | \n                                Model Name: {{case.warranty.product.name}} | \n                                Serial Number: {{case.warranty.productSerialNumber}}\n                            </p>\n                        </div>\n                        <div class=\"tech-blk\">\n                            <h4 class=\"tech-sub-ttl\">Case Details:</h4>\n                            <div [innerHTML]=\"case.description\"></div>\n                        </div>\n                        <div class=\"tech-blk tech-more\">\n                            <a routerLink=\"/technician/{{case.id}}\" class=\"more btn btn-green\">View Job</a>\n                        </div>\n                    </div>\n                </ng-container>\n            </div>\n        </div>\n    </div>\n    <div class=\"navbar navbar-expand-md navbar-dark fixed-bottom bg-light\">\n        <div class=\"text-center\">\n            <button class=\"btn btn-danger\" (click)=\"logout()\">Log out</button>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/components/technicians/technicians.component.scss":
/*!*******************************************************************!*\
  !*** ./src/app/components/technicians/technicians.component.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".tech-list {\n  padding-bottom: 40px; }\n\n.preview-label span {\n  white-space: normal; }\n\n.preview-label {\n  flex: 0 0 91px; }\n\n.preview-text {\n  display: flex;\n  align-items: center; }\n\n.tech-wrap .nav-tabs {\n  border-bottom: 1px solid #ddd;\n  margin-bottom: 20px; }\n\n.tech-wrap .nav-tabs li {\n    width: 50%;\n    text-align: center; }\n\n.tech-wrap .nav-tabs li a {\n      color: #000;\n      border-radius: 0;\n      border: none; }\n\n.tech-wrap .nav-tabs li a.active {\n        font-weight: bold;\n        border-bottom: 1px solid #000; }\n\n.tech-wrap .nav-tabs li a:hover {\n        font-weight: bold; }\n\n.tech-wrap .tech-item {\n  border-bottom: 1px dashed #ddd;\n  padding-bottom: 5px;\n  margin-bottom: 20px; }\n\n.tech-wrap .tech-item:last-child {\n    border-bottom: none;\n    padding-bottom: 0px; }\n\n.tech-wrap .tech-ttl {\n  font-size: 24px; }\n\n.tech-wrap .tech-sub-ttl {\n  font-size: 16px;\n  font-weight: bold; }\n\n.tech-wrap .tech-blk {\n  margin-bottom: 15px; }\n\n.tech-wrap .tech-blk:last-child {\n    margin-bottom: 0; }\n\n.tech-wrap .tech-blk p {\n    margin-bottom: 0; }\n\n.tech-wrap .td-name {\n  width: 120px; }\n\n.tech-wrap table {\n  width: 100%; }\n\n.tech-wrap table td {\n    padding: 3px 5px; }\n\n.tech-wrap .ipt, .tech-wrap .ipt-select {\n  width: 300px;\n  display: inline-block;\n  vertical-align: middle; }\n\n.tech-wrap.tech-detail .tech-blk {\n  border-bottom: 1px dashed #ddd;\n  padding-bottom: 15px; }\n\n.tech-wrap.tech-detail .tech-blk:last-child {\n    border-bottom: none; }\n\n.tech-wrap.tech-detail .tech-blk p {\n    margin-bottom: 10px; }\n\n.tech-wrap.tech-detail .note-item {\n  background-color: #f9f9f9;\n  margin-bottom: 10px;\n  padding: 5px 10px; }\n\n.tech-wrap.tech-detail .note-item p {\n    margin-bottom: 0; }\n\n.tech-wrap.tech-detail .note-item p:last-child {\n      color: #db0000; }\n\n.tech-wrap.tech-detail .note-item p:last-child span {\n        font-weight: bold;\n        cursor: pointer; }\n\n.tech-wrap.tech-detail .note-item p:last-child span:hover {\n          text-decoration: underline; }\n\n.tech-wrap.tech-detail .btn-upload {\n  margin-bottom: 10px;\n  width: 100%; }\n\n.tech-wrap.tech-detail .btn-mark {\n  margin-right: 15px; }\n\n.tech-wrap .status.new {\n  color: #007bff; }\n\n.tech-wrap .status.resolved {\n  color: #db0000; }\n\n.tech-wrap .status.closed, .tech-wrap .status.completed, .tech-wrap .status.complete {\n  color: #28a745; }\n\n.foot-nav {\n  width: 100%;\n  position: absolute;\n  bottom: 20px;\n  left: 0px; }\n"

/***/ }),

/***/ "./src/app/components/technicians/technicians.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/components/technicians/technicians.component.ts ***!
  \*****************************************************************/
/*! exports provided: TechniciansComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TechniciansComponent", function() { return TechniciansComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _service_member_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../service/member.service */ "./src/app/service/member.service.ts");
/* harmony import */ var _helper_token__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../helper/token */ "./src/app/helper/token.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var TechniciansComponent = /** @class */ (function () {
    function TechniciansComponent(memberService, router) {
        this.memberService = memberService;
        this.router = router;
        this.isLoading = false;
        this.completedCount = 0;
        this.uncompletedCount = 0;
        this.fetchMembers();
    }
    TechniciansComponent.prototype.fetchMembers = function () {
        var _this = this;
        Object(_helper_token__WEBPACK_IMPORTED_MODULE_4__["requireToken"])(this.memberService, function () {
            _this.memberService.getMembers(1).subscribe(function (members) {
                _this.cases = members[0].assignedCases;
                _this.completedCount = _this.cases.filter(function (c) { return c.completed; }).length;
                _this.uncompletedCount = _this.cases.filter(function (c) { return !c.completed; }).length;
            });
        });
    };
    TechniciansComponent.prototype.ngOnInit = function () {
    };
    TechniciansComponent.prototype.ngAfterViewInit = function () {
    };
    /* =========================================== */
    /** Actions in this Comp */
    // 1. switchTab
    TechniciansComponent.prototype.switchTab = function (event, tabId) {
        // addclass tab
        jquery__WEBPACK_IMPORTED_MODULE_2__('.nav-link').removeClass('active');
        jquery__WEBPACK_IMPORTED_MODULE_2__(event.target).addClass('active');
        // show content
        jquery__WEBPACK_IMPORTED_MODULE_2__('.tab-pane').removeClass('fade show in active');
        jquery__WEBPACK_IMPORTED_MODULE_2__(tabId).addClass('fade show in active');
    };
    TechniciansComponent.prototype.logout = function () {
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_token');
        this.router.navigateByUrl('/login');
    };
    TechniciansComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'technicians',
            template: __webpack_require__(/*! ./technicians.component.html */ "./src/app/components/technicians/technicians.component.html"),
            styles: [__webpack_require__(/*! ./technicians.component.scss */ "./src/app/components/technicians/technicians.component.scss")]
        }),
        __metadata("design:paramtypes", [_service_member_service__WEBPACK_IMPORTED_MODULE_3__["MemberService"],
            _angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"]])
    ], TechniciansComponent);
    return TechniciansComponent;
}());



/***/ }),

/***/ "./src/app/directive/focus.directive.ts":
/*!**********************************************!*\
  !*** ./src/app/directive/focus.directive.ts ***!
  \**********************************************/
/*! exports provided: FocusDirective */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FocusDirective", function() { return FocusDirective; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

var FocusDirective = /** @class */ (function () {
    function FocusDirective(element, renderer) {
        this.element = element;
        this.renderer = renderer;
    }
    FocusDirective.prototype.ngOnInit = function () {
        var _this = this;
        if (this.focusEvent !== undefined) {
            this.focusEvent.subscribe(function (event) {
                _this.element.nativeElement.focus();
            });
        }
    };
    __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"])('focus'),
        __metadata("design:type", _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"])
    ], FocusDirective.prototype, "focusEvent", void 0);
    FocusDirective = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Directive"])({
            selector: '[focus]'
        }),
        __metadata("design:paramtypes", [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["Renderer2"]])
    ], FocusDirective);
    return FocusDirective;
}());



/***/ }),

/***/ "./src/app/extensions/angular2-image-upload/index.js":
/*!***********************************************************!*\
  !*** ./src/app/extensions/angular2-image-upload/index.js ***!
  \***********************************************************/
/*! exports provided: ImageUploadModule, ImageUploadComponent, FileHolder */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _lib_image_upload_module__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lib/image-upload.module */ "./src/app/extensions/angular2-image-upload/lib/image-upload.module.js");
/* harmony import */ var _lib_image_upload_module__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_lib_image_upload_module__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "ImageUploadModule", function() { return _lib_image_upload_module__WEBPACK_IMPORTED_MODULE_0__["ImageUploadModule"]; });

/* harmony import */ var _lib_image_upload_image_upload_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lib/image-upload/image-upload.component */ "./src/app/extensions/angular2-image-upload/lib/image-upload/image-upload.component.js");
/* harmony import */ var _lib_image_upload_image_upload_component__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_lib_image_upload_image_upload_component__WEBPACK_IMPORTED_MODULE_1__);
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "ImageUploadComponent", function() { return _lib_image_upload_image_upload_component__WEBPACK_IMPORTED_MODULE_1__["ImageUploadComponent"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "FileHolder", function() { return _lib_image_upload_image_upload_component__WEBPACK_IMPORTED_MODULE_1__["FileHolder"]; });





/***/ }),

/***/ "./src/app/extensions/angular2-image-upload/lib/file-drop.directive.js":
/*!*****************************************************************************!*\
  !*** ./src/app/extensions/angular2-image-upload/lib/file-drop.directive.js ***!
  \*****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var FileDropDirective = (function () {
    function FileDropDirective() {
        this.fileOver = new core_1.EventEmitter();
        this.fileDrop = new core_1.EventEmitter();
    }
    FileDropDirective.prototype.onDrop = function (event) {
        var dataTransfer = FileDropDirective.getDataTransfer(event);
        if (!FileDropDirective.hasFiles(dataTransfer.types)) {
            return;
        }
        event.preventDefault();
        var files = this.filterFiles(dataTransfer.files);
        event.preventDefault();
        this.fileOver.emit(false);
        this.fileDrop.emit(files);
    };
    FileDropDirective.prototype.onDragLeave = function (event) {
        this.fileOver.emit(false);
    };
    FileDropDirective.prototype.onDragOver = function (event) {
        var dataTransfer = FileDropDirective.getDataTransfer(event);
        if (!FileDropDirective.hasFiles(dataTransfer.types)) {
            return;
        }
        dataTransfer.dropEffect = 'copy';
        event.preventDefault();
        this.fileOver.emit(true);
    };
    FileDropDirective.prototype.filterFiles = function (files) {
        if (!this.accept || this.accept.length === 0) {
            return files;
        }
        var acceptedFiles = [];
        for (var i = 0; i < files.length; i++) {
            for (var j = 0; j < this.accept.length; j++) {
                if (FileDropDirective.matchRule(this.accept[j], files[i].type)) {
                    acceptedFiles.push(files[i]);
                    break;
                }
            }
        }
        return acceptedFiles;
    };
    FileDropDirective.getDataTransfer = function (event) {
        return event.dataTransfer ? event.dataTransfer : event.originalEvent.dataTransfer;
    };
    FileDropDirective.hasFiles = function (types) {
        if (!types) {
            return false;
        }
        if (types.indexOf) {
            return types.indexOf('Files') !== -1;
        }
        if (types.contains) {
            return types.contains('Files');
        }
        return false;
    };
    FileDropDirective.matchRule = function (rule, candidate) {
        return new RegExp("^" + rule.split("*").join(".*") + "$").test(candidate);
    };
    return FileDropDirective;
}());
FileDropDirective.decorators = [
    { type: core_1.Directive, args: [{
                selector: '[fileDrop]'
            },] },
];
FileDropDirective.ctorParameters = function () { return []; };
FileDropDirective.propDecorators = {
    'accept': [{ type: core_1.Input },],
    'fileOver': [{ type: core_1.Output },],
    'fileDrop': [{ type: core_1.Output },],
    'onDrop': [{ type: core_1.HostListener, args: ['drop', ['$event'],] },],
    'onDragLeave': [{ type: core_1.HostListener, args: ['dragleave', ['$event'],] },],
    'onDragOver': [{ type: core_1.HostListener, args: ['dragover', ['$event'],] },],
};
exports.FileDropDirective = FileDropDirective;


/***/ }),

/***/ "./src/app/extensions/angular2-image-upload/lib/image-upload.module.js":
/*!*****************************************************************************!*\
  !*** ./src/app/extensions/angular2-image-upload/lib/image-upload.module.js ***!
  \*****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var http_1 = __webpack_require__(/*! @angular/http */ "./node_modules/@angular/http/fesm5/http.js");
var file_drop_directive_1 = __webpack_require__(/*! ./file-drop.directive */ "./src/app/extensions/angular2-image-upload/lib/file-drop.directive.js");
var image_upload_component_1 = __webpack_require__(/*! ./image-upload/image-upload.component */ "./src/app/extensions/angular2-image-upload/lib/image-upload/image-upload.component.js");
var image_service_1 = __webpack_require__(/*! ./image-upload/image.service */ "./src/app/extensions/angular2-image-upload/lib/image-upload/image.service.js");
var ImageUploadModule = (function () {
    function ImageUploadModule() {
    }
    ImageUploadModule.forRoot = function () {
        return {
            ngModule: ImageUploadModule,
            providers: [image_service_1.ImageService]
        };
    };
    return ImageUploadModule;
}());
ImageUploadModule.decorators = [
    { type: core_1.NgModule, args: [{
                imports: [common_1.CommonModule, http_1.HttpModule],
                declarations: [image_upload_component_1.ImageUploadComponent, file_drop_directive_1.FileDropDirective],
                exports: [image_upload_component_1.ImageUploadComponent]
            },] },
];
ImageUploadModule.ctorParameters = function () { return []; };
exports.ImageUploadModule = ImageUploadModule;


/***/ }),

/***/ "./src/app/extensions/angular2-image-upload/lib/image-upload/image-upload.component.js":
/*!*********************************************************************************************!*\
  !*** ./src/app/extensions/angular2-image-upload/lib/image-upload/image-upload.component.js ***!
  \*********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t;
    return { next: verb(0), "throw": verb(1), "return": verb(2) };
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = y[op[0] & 2 ? "return" : op[0] ? "throw" : "next"]) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [0, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var image_service_1 = __webpack_require__(/*! ./image.service */ "./src/app/extensions/angular2-image-upload/lib/image-upload/image.service.js");
var FileHolder = (function () {
    function FileHolder(src, file) {
        this.src = src;
        this.file = file;
        this.pending = false;
    }
    return FileHolder;
}());
exports.FileHolder = FileHolder;
var ImageUploadComponent = (function () {
    function ImageUploadComponent(imageService) {
        var _this = this;
        this.imageService = imageService;
        this.files = [];
        this.fileCounter = 0;
        this.fileOver = false;
        this.showFileTooLargeMessage = false;
        this.beforeUpload = function (data) { return data; };
        this.buttonCaption = 'Select Images';
        this.disabled = false;
        this.cssClass = 'img-ul';
        this.clearButtonCaption = 'Clear';
        this.dropBoxMessage = 'Drop your images here!';
        this.max = 100;
        this.preview = true;
        this.withCredentials = false;
        this.uploadedFiles = [];
        this.removed = new core_1.EventEmitter();
        this.uploadStateChanged = new core_1.EventEmitter();
        this.uploadFinished = new core_1.EventEmitter();
        this.previewClicked = new core_1.EventEmitter();
        this.pendingFilesCounter = 0;
        this.onFileOver = function (isOver) { return _this.fileOver = isOver; };
        this.countRemainingSlots = function () { return _this.max - _this.fileCounter; };
    }
    ImageUploadComponent.prototype.ngOnInit = function () {
        if (!this.fileTooLargeMessage) {
            this.fileTooLargeMessage = 'An image was too large and was not uploaded.' + (this.maxFileSize ? (' The maximum file size is ' + this.maxFileSize / 1024) + 'KiB.' : '');
        }
        this.supportedExtensions = this.supportedExtensions ? this.supportedExtensions.map(function (ext) { return 'image/' + ext; }) : ['image/*'];
    };
    ImageUploadComponent.prototype.deleteAll = function () {
        var _this = this;
        this.files.forEach(function (f) { return _this.removed.emit(f); });
        this.files = [];
        this.fileCounter = 0;
        this.inputElement.nativeElement.value = '';
    };
    ImageUploadComponent.prototype.deleteFile = function (file) {
        var index = this.files.indexOf(file);
        this.files.splice(index, 1);
        this.fileCounter--;
        this.inputElement.nativeElement.value = '';
        this.removed.emit(file);
    };
    ImageUploadComponent.prototype.previewFileClicked = function (file) {
        this.previewClicked.emit(file);
    };
    ImageUploadComponent.prototype.ngOnChanges = function (changes) {
        if (changes.uploadedFiles && changes.uploadedFiles.currentValue.length > 0) {
            this.processUploadedFiles();
        }
    };
    ImageUploadComponent.prototype.onFileChange = function (files) {
        if (this.disabled)
            return;
        var remainingSlots = this.countRemainingSlots();
        var filesToUploadNum = files.length > remainingSlots ? remainingSlots : files.length;
        if (this.url && filesToUploadNum != 0) {
            this.uploadStateChanged.emit(true);
        }
        this.fileCounter += filesToUploadNum;
        this.showFileTooLargeMessage = false;
        this.uploadFiles(files, filesToUploadNum);
    };
    ImageUploadComponent.prototype.onResponse = function (response, fileHolder) {
        fileHolder.serverResponse = { status: response.status, response: response };
        fileHolder.pending = false;
        this.uploadFinished.emit(fileHolder);
        if (--this.pendingFilesCounter == 0) {
            this.uploadStateChanged.emit(false);
        }
    };
    ImageUploadComponent.prototype.processUploadedFiles = function () {
        for (var i = 0; i < this.uploadedFiles.length; i++) {
            var data = this.uploadedFiles[i];
            var fileBlob = void 0, file = void 0, fileUrl = void 0;
            if (data instanceof Object) {
                fileUrl = data.url;
                fileBlob = (data.blob) ? data.blob : new Blob([data]);
                file = new File([fileBlob], data.fileName);
            }
            else {
                fileUrl = data;
                fileBlob = new Blob([fileUrl]);
                file = new File([fileBlob], fileUrl);
            }
            this.files.push(new FileHolder(fileUrl, file));
        }
    };
    ImageUploadComponent.prototype.uploadFiles = function (files, filesToUploadNum) {
        return __awaiter(this, void 0, void 0, function () {
            var _this = this;
            var _loop_1, this_1, i;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        _loop_1 = function (i) {
                            var file, beforeUploadResult, img, reader;
                            return __generator(this, function (_a) {
                                switch (_a.label) {
                                    case 0:
                                        file = files[i];
                                        if (this_1.maxFileSize && file.size > this_1.maxFileSize) {
                                            this_1.fileCounter--;
                                            this_1.inputElement.nativeElement.value = '';
                                            this_1.showFileTooLargeMessage = true;
                                            return [2 /*return*/, "continue"];
                                        }
                                        return [4 /*yield*/, this_1.beforeUpload({ file: file, url: this_1.url, abort: false })];
                                    case 1:
                                        beforeUploadResult = _a.sent();
                                        if (beforeUploadResult.abort) {
                                            this_1.fileCounter--;
                                            this_1.inputElement.nativeElement.value = '';
                                            return [2 /*return*/, "continue"];
                                        }
                                        img = document.createElement('img');
                                        img.src = window.URL.createObjectURL(beforeUploadResult.file);
                                        reader = new FileReader();
                                        reader.addEventListener('load', function (event) {
                                            var fileHolder = new FileHolder(event.target.result, beforeUploadResult.file);
                                            _this.uploadSingleFile(fileHolder, beforeUploadResult.url, beforeUploadResult.formData);
                                            _this.files.push(fileHolder);
                                        }, false);
                                        reader.readAsDataURL(beforeUploadResult.file);
                                        return [2 /*return*/];
                                }
                            });
                        };
                        this_1 = this;
                        i = 0;
                        _a.label = 1;
                    case 1:
                        if (!(i < filesToUploadNum)) return [3 /*break*/, 4];
                        return [5 /*yield**/, _loop_1(i)];
                    case 2:
                        _a.sent();
                        _a.label = 3;
                    case 3:
                        i++;
                        return [3 /*break*/, 1];
                    case 4: return [2 /*return*/];
                }
            });
        });
    };
    ImageUploadComponent.prototype.uploadSingleFile = function (fileHolder, url, customForm) {
        var _this = this;
        if (url === void 0) { url = this.url; }
        if (url) {
            this.pendingFilesCounter++;
            fileHolder.pending = true;
            this.imageService
                .postImage(url, fileHolder.file, this.headers, this.partName, customForm, this.withCredentials)
                .subscribe(function (response) { return _this.onResponse(response, fileHolder); }, function (error) {
                _this.onResponse(error, fileHolder);
                _this.deleteFile(fileHolder);
            });
        }
        else {
            this.uploadFinished.emit(fileHolder);
        }
    };
    return ImageUploadComponent;
}());
ImageUploadComponent.decorators = [
    { type: core_1.Component, args: [{
                selector: 'image-upload',
                template: "\n    <div\n         fileDrop\n         [accept]=\"supportedExtensions\"\n         (fileOver)=\"onFileOver($event)\"\n         (fileDrop)=\"onFileChange($event)\"\n         [ngClass]=\"cssClass\"\n         [ngClass]=\"{'img-ul-file-is-over': fileOver}\"     \n         [ngStyle]=\"style?.layout\"\n    >\n      <div class=\"img-ul-file-upload img-ul-hr-inline-group\">    \n        <label *ngIf=\"fileCounter != max\"\n          class=\"img-ul-upload img-ul-button\" \n          [ngStyle]=\"style?.selectButton\"\n          [ngClass]=\"{'img-ul-disabled': disabled}\">\n          <span [innerText]=\"buttonCaption\"></span>\n          <input\n            type=\"file\"\n            [disabled]=\"disabled\"\n            [accept]=\"supportedExtensions\"\n            multiple (change)=\"onFileChange(input.files)\"\n            #input>\n        </label>\n        <button *ngIf=\"fileCounter > 0\"\n          [disabled]=\"disabled\"\n          class=\"img-ul-clear img-ul-button\" \n          (click)=\"deleteAll()\" \n          [ngStyle]=\"style?.clearButton\"\n          [innerText]=\"clearButtonCaption\">\n        </button>\n        <div class=\"img-ul-drag-box-msg\" [innerText]=\"dropBoxMessage\"></div>\n      </div>\n\n      <p class=\"img-ul-file-too-large\" *ngIf=\"showFileTooLargeMessage\" [innerText]=\"fileTooLargeMessage\"></p>\n\n      <div *ngIf=\"preview\" class=\"img-ul-container img-ul-hr-inline-group\" [ngStyle]=\"style?.previewPanel\">\n        <div\n          class=\"img-ul-image\"\n          *ngFor=\"let file of files\"\n          (click)=\"previewFileClicked(file)\"\n          [ngStyle]=\"{'background-image': 'url('+ file.src +')'}\"\n        >\n          <div *ngIf=\"file.pending\" class=\"img-ul-loading-overlay\">\n            <div class=\"img-ul-spinning-circle\"></div>\n          </div>\n          <div *ngIf=\"!file.pending && !file.serverResponse\" \n            [ngClass]=\"{'img-ul-disabled': disabled}\" \n            class=\"img-ul-x-mark\" \n            (click)=\"deleteFile(file)\">\n            <span class=\"img-ul-close\"></span>\n          </div>\n        </div>\n      </div>\n    </div>\n  ",
                styles: ["\n    .img-ul {\n        --active-color: #3C9;\n        --common-radius: 3px;\n        background-color: #f8f8f8;\n        border-radius: var(--common-radius);\n        border: #d0d0d0 dashed 1px;\n        font-family: sans-serif;\n        position: relative;\n        color: #9b9b9b;\n    }\n\n    .img-ul-file-is-over {\n        border: var(--active-color) solid;\n    }\n\n    .img-ul-hr-inline-group:after {\n        clear: both;\n        content: \"\";\n        display: table;\n    }\n\n    .img-ul-file-upload {    \n        padding: 16px;\n    }\n\n    .img-ul-drag-box-msg {    \n        display: inline-block;\n        font-weight: 600;\n        margin-left: 12px;\n        padding-top: 14px;\n    }\n\n    label.img-ul-button input[type=file] {\n        display: none;\n        position: fixed;\n        top: -99999px;\n    }\n\n    .img-ul-clear {\n        background-color: #FF0000;\n    }\n\n    .img-ul-clear:disabled {\n        background-color: #FF6464;\n        cursor: default;\n    }\n\n    .img-ul-upload {\n        background-color: var(--active-color);\n    }\n\n    .img-ul-button {\n        -moz-box-shadow: 2px 2px 4px 0 rgba(148, 148, 148, 0.6);\n        -webkit-box-shadow: 2px 2px 4px 0 rgba(148, 148, 148, 0.6);\n        border: none;\n        box-shadow: 2px 2px 4px 0 rgba(148, 148, 148, 0.6);\n        color: #FFF;\n        cursor: pointer;\n        display: inline-block;\n        float: left;\n        font-size: 1.25em;\n        font-weight: 500;\n        padding: 10px;\n        text-transform: uppercase;\n    }\n\n    .img-ul-button:active span {\n        display: block;\n        position: relative;\n        top: 1px;\n    }\n\n    .img-ul-container {\n        background-color: #fdfdfd;\n        padding: 0 10px;\n    }\n\n    .img-ul-image {    \n        background: center center no-repeat;\n        background-size: contain;\n        display: inline-block;\n        float: left;\n        height: 86px;\n        margin: 6px;\n        position: relative;\n        width: 86px;\n    }\n\n    .img-ul-x-mark {\n        background-color: #000;\n        border-radius: 2px;\n        color: #FFF;\n        cursor: pointer;\n        float: right;\n        height: 20px;\n        margin: 2px;\n        opacity: .7;\n        text-align: center;\n        width: 20px;\n    }\n\n    .img-ul-close {\n        height: 20px;\n        opacity: .7;\n        padding-right: 3px;\n        position: relative;\n        width: 20px;\n    }\n\n    .img-ul-x-mark:hover .img-ul-close {\n        opacity: 1;\n    }\n\n    .img-ul-close:before, .img-ul-close:after {\n        background-color: #FFF;\n        border-radius: 2px;\n        content: '';\n        height: 15px;\n        position: absolute;\n        top: 0;\n        width: 2px;\n    }\n\n    .img-ul-close:before {\n        transform: rotate(45deg);\n    }\n\n    .img-ul-close:after {\n        transform: rotate(-45deg);\n    }\n\n    .img-ul-x-mark.img-ul-disabled {\n        display: none;\n    }\n\n    .img-ul-loading-overlay {\n        background-color: #000;\n        bottom: 0;\n        left: 0;\n        opacity: .7;\n        position: absolute;\n        right: 0;\n        top: 0;\n    }\n\n    .img-ul-spinning-circle {\n        height: 30px;\n        width: 30px;\n        margin: auto;\n        position: absolute;\n        top: 0;\n        left: 0;\n        bottom: 0;\n        right: 0;\n        border-radius: 50%;\n        border: 3px solid rgba(255, 255, 255, 0);\n        border-top: 3px solid #FFF;\n        border-right: 3px solid #FFF;\n        -webkit-animation: spinner 2s infinite cubic-bezier(0.085, 0.625, 0.855, 0.360);\n        animation: spinner 2s infinite cubic-bezier(0.085, 0.625, 0.855, 0.360);\n    }\n\n    .img-ul-file-too-large {\n        color: red;\n        padding: 0 15px;\n    }\n\n    .img-ul-upload.img-ul-disabled {\n        background-color: #86E9C9;\n        cursor: default;\n    }\n\n    .img-ul-upload.img-ul-disabled:active span {\n        top: 0px;\n    }\n\n    @-webkit-keyframes spinner {\n      0% {\n        -webkit-transform: rotate(0deg);\n        transform: rotate(0deg);\n      }\n\n      100% {\n        -webkit-transform: rotate(360deg);\n        transform: rotate(360deg);\n      }\n    }\n\n    @keyframes spinner {\n      0% {\n        -webkit-transform: rotate(0deg);\n        transform: rotate(0deg);\n      }\n\n      100% {\n        -webkit-transform: rotate(360deg);\n        transform: rotate(360deg);\n      }\n    }\n  "]
            },] },
];
ImageUploadComponent.ctorParameters = function () { return [
    { type: image_service_1.ImageService, },
]; };
ImageUploadComponent.propDecorators = {
    'beforeUpload': [{ type: core_1.Input },],
    'buttonCaption': [{ type: core_1.Input },],
    'disabled': [{ type: core_1.Input },],
    'cssClass': [{ type: core_1.Input, args: ['class',] },],
    'clearButtonCaption': [{ type: core_1.Input },],
    'dropBoxMessage': [{ type: core_1.Input },],
    'fileTooLargeMessage': [{ type: core_1.Input },],
    'headers': [{ type: core_1.Input },],
    'max': [{ type: core_1.Input },],
    'maxFileSize': [{ type: core_1.Input },],
    'preview': [{ type: core_1.Input },],
    'partName': [{ type: core_1.Input },],
    'style': [{ type: core_1.Input },],
    'supportedExtensions': [{ type: core_1.Input, args: ['extensions',] },],
    'url': [{ type: core_1.Input },],
    'withCredentials': [{ type: core_1.Input },],
    'uploadedFiles': [{ type: core_1.Input },],
    'removed': [{ type: core_1.Output },],
    'uploadStateChanged': [{ type: core_1.Output },],
    'uploadFinished': [{ type: core_1.Output },],
    'previewClicked': [{ type: core_1.Output },],
    'inputElement': [{ type: core_1.ViewChild, args: ['input',] },],
};
exports.ImageUploadComponent = ImageUploadComponent;


/***/ }),

/***/ "./src/app/extensions/angular2-image-upload/lib/image-upload/image.service.js":
/*!************************************************************************************!*\
  !*** ./src/app/extensions/angular2-image-upload/lib/image-upload/image.service.js ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var http_1 = __webpack_require__(/*! @angular/http */ "./node_modules/@angular/http/fesm5/http.js");
var ImageService = (function () {
    function ImageService(http) {
        this.http = http;
    }
    ImageService.prototype.postImage = function (url, image, headers, partName, customFormData, withCredentials) {
        if (partName === void 0) { partName = 'image'; }
        if (!url || url === '') {
            throw new Error('Url is not set! Please set it before doing queries');
        }
        var options = new http_1.RequestOptions();
        if (withCredentials) {
            options.withCredentials = withCredentials;
        }
        if (headers) {
            options.headers = new http_1.Headers(headers);
        }
        var formData = new FormData();
        for (var key in customFormData) {
            formData.append(key, customFormData[key]);
        }
        formData.append(partName, image);
        return this.http.post(url, formData, options);
    };
    return ImageService;
}());
ImageService.decorators = [
    { type: core_1.Injectable },
];
ImageService.ctorParameters = function () { return [
    { type: http_1.Http, },
]; };
exports.ImageService = ImageService;


/***/ }),

/***/ "./src/app/helper/helper.ts":
/*!**********************************!*\
  !*** ./src/app/helper/helper.ts ***!
  \**********************************/
/*! exports provided: Helper */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Helper", function() { return Helper; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

var Helper = /** @class */ (function () {
    function Helper() {
    }
    Helper.prototype.explode = function (delimiter, string, limit) {
        //  discuss at: http://locutus.io/php/explode/
        // original by: Kevin van Zonneveld (http://kvz.io)
        //   example 1: explode(' ', 'Kevin van Zonneveld')
        //   returns 1: [ 'Kevin', 'van', 'Zonneveld' ]
        if (arguments.length < 2 ||
            typeof delimiter === 'undefined' ||
            typeof string === 'undefined') {
            return null;
        }
        if (delimiter === '' ||
            delimiter === false ||
            delimiter === null) {
            return false;
        }
        if (typeof delimiter === 'function' ||
            typeof delimiter === 'object' ||
            typeof string === 'function' ||
            typeof string === 'object') {
            return {
                0: ''
            };
        }
        if (delimiter === true) {
            delimiter = '1';
        }
        // Here we go...
        delimiter += '';
        string += '';
        var s = string.split(delimiter);
        if (typeof limit === 'undefined')
            return s;
        // Support for limit
        if (limit === 0)
            limit = 1;
        // Positive limit
        if (limit > 0) {
            if (limit >= s.length) {
                return s;
            }
            return s
                .slice(0, limit - 1)
                .concat([s.slice(limit - 1)
                    .join(delimiter)
            ]);
        }
        // Negative limit
        if (-limit >= s.length) {
            return [];
        }
        s.splice(s.length + limit);
        return s;
    };
    Helper = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])(),
        __metadata("design:paramtypes", [])
    ], Helper);
    return Helper;
}());



/***/ }),

/***/ "./src/app/helper/token.ts":
/*!*********************************!*\
  !*** ./src/app/helper/token.ts ***!
  \*********************************/
/*! exports provided: decode, exp, isExpired, requireToken */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "decode", function() { return decode; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "exp", function() { return exp; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isExpired", function() { return isExpired; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "requireToken", function() { return requireToken; });
/* harmony import */ var _components_login_modal_login_modal_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/login-modal/login-modal.component */ "./src/app/components/login-modal/login-modal.component.ts");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");



function decode(base64url) {
    try {
        //Convert base 64 url to base 64
        var base64 = base64url.replace('-', '+').replace('_', '/');
        //atob() is a built in JS function that decodes a base-64 encoded string
        var utf8 = atob(base64);
        //Then parse that into JSON
        var json = JSON.parse(utf8);
        //Then make that JSON look pretty
        var json_string = JSON.stringify(json, null, 4);
    }
    catch (err) {
        console.log(err);
    }
    return json;
}
function exp(token) {
    var payload = token.split('\.')[1];
    return decode(payload).exp;
}
function isExpired(token) {
    return exp(token) * 1000 <= +new Date();
    // return true;
}
function requireToken(service, callback) {
    var token = window.localStorage.getItem('token');
    var refresh = window.localStorage.getItem('refresh_token');
    if (isExpired(token)) {
        var http = service.http;
        http.post("" + _environments_environment__WEBPACK_IMPORTED_MODULE_1__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_1__["apiEndPointBase"] + "/token/refresh", {
            refresh_token: refresh
        })
            .pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["catchError"])(function (error, caught) {
            var modal = service.modal.show(_components_login_modal_login_modal_component__WEBPACK_IMPORTED_MODULE_0__["LoginModalComponent"]);
            modal.content.callback = callback;
            return;
        }))
            .subscribe(function (res) {
            window.localStorage.setItem('token', res['token']);
            window.localStorage.setItem('refresh_token', res['refresh_token']);
            // console.log("Token refreshed");
            callback();
        });
    }
    else {
        // console.log("No need to refresh token");
        callback();
    }
}


/***/ }),

/***/ "./src/app/model/service-note.ts":
/*!***************************************!*\
  !*** ./src/app/model/service-note.ts ***!
  \***************************************/
/*! exports provided: ServiceNote */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ServiceNote", function() { return ServiceNote; });
var ServiceNote = /** @class */ (function () {
    function ServiceNote() {
    }
    return ServiceNote;
}());



/***/ }),

/***/ "./src/app/service/case.service.ts":
/*!*****************************************!*\
  !*** ./src/app/service/case.service.ts ***!
  \*****************************************/
/*! exports provided: CaseService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CaseService", function() { return CaseService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var CaseService = /** @class */ (function () {
    function CaseService(http, modal) {
        this.http = http;
        this.modal = modal;
        this.warrantyCaseApiUrl = "/warranty-cases";
        this.url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + this.warrantyCaseApiUrl;
        this.token = localStorage.getItem('token');
    }
    CaseService.prototype.markCompleted = function (aCase) {
        return this.http.put(this.url + "/" + aCase.id, {
            completed: true,
            status: "COMPLETED"
        }, {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({
                'Content-Type': 'application/ld+json',
                'Authorization': "Bearer " + this.token
            })
        }).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) { return res; }));
    };
    CaseService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"],
            ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__["BsModalService"]])
    ], CaseService);
    return CaseService;
}());



/***/ }),

/***/ "./src/app/service/member.service.ts":
/*!*******************************************!*\
  !*** ./src/app/service/member.service.ts ***!
  \*******************************************/
/*! exports provided: MemberService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MemberService", function() { return MemberService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var MemberService = /** @class */ (function () {
    function MemberService(http, modal) {
        this.http = http;
        this.modal = modal;
        this.membersUrl = '/organisation-members';
    }
    MemberService.prototype.getMembers = function (organisation) {
        this.token = localStorage.getItem('token');
        return this.http.get("" + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + this.membersUrl + "?organization=" + organisation, {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({
                'Authorization': "Bearer " + this.token
            })
        })
            .pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var members = res['hydra:member'];
            return members;
        }));
    };
    MemberService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"],
            ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__["BsModalService"]])
    ], MemberService);
    return MemberService;
}());



/***/ }),

/***/ "./src/app/service/note.service.ts":
/*!*****************************************!*\
  !*** ./src/app/service/note.service.ts ***!
  \*****************************************/
/*! exports provided: NoteService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "NoteService", function() { return NoteService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};



var NoteService = /** @class */ (function () {
    function NoteService(http) {
        this.http = http;
        this.noteApiUrl = '/service-notes';
    }
    NoteService.prototype.add = function (note) {
        return this.http.post("" + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + this.noteApiUrl, note, {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({ 'Content-Type': 'application/ld+json' })
        })
            .pipe(function (res) { return res; });
    };
    NoteService.prototype.update = function (note) {
        return this.http.put("" + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + this.noteApiUrl + "/" + note.id, note, {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({ 'Content-Type': 'application/ld+json' })
        })
            .pipe(function (res) { return res; });
    };
    NoteService.prototype.delete = function (id) {
        return this.http.delete("" + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + this.noteApiUrl + "/" + id)
            .pipe(function (res) { return res; });
    };
    NoteService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"]])
    ], NoteService);
    return NoteService;
}());



/***/ }),

/***/ "./src/app/service/organisation.service.ts":
/*!*************************************************!*\
  !*** ./src/app/service/organisation.service.ts ***!
  \*************************************************/
/*! exports provided: OrganisationService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "OrganisationService", function() { return OrganisationService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var rxjs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var httpOptions = {
    headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({ 'Content-Type': 'application/ld+json' })
};
var OrganisationService = /** @class */ (function () {
    function OrganisationService(http) {
        this.http = http;
    }
    OrganisationService.prototype.getOrganisation = function () {
        var orgId = localStorage.getItem('orgId');
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["organisationPath"] + "/" + orgId;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            return res;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getOrganisation', [])));
    };
    OrganisationService.prototype.getLogo = function () {
        var orgId = localStorage.getItem('orgId');
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["organisationPath"] + "/" + orgId;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            //http://dev-swarranty.magentapulse.com/media-api/media/4/binaries/reference/view.json
            var logoId = res.logo.id;
            var logoSrc = _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointMedia"] + "/media/" + logoId + "/binaries/reference/view.json";
            //http://dev-swarranty.magentapulse.com/media-api/media/4/binaries/reference/view.json
            return logoSrc;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getLogo' +
            '', [])));
    };
    /**
     * Handle Http operation that failed.
     * Let the app continue.
     * @param operation - name of the operation that failed
     * @param result - optional value to return as the observable result
     */
    OrganisationService.prototype.handleError = function (operation, result) {
        if (operation === void 0) { operation = 'operation'; }
        return function (error) {
            // TODO: send the error to remote logging infrastructure
            console.error(error); // log to console instead
            // TODO: better job of transforming error for user consumption
            console.log(operation + " failed: " + error.message);
            // Let the app keep running by returning an empty result.
            return Object(rxjs__WEBPACK_IMPORTED_MODULE_2__["of"])(result);
        };
    };
    OrganisationService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"]])
    ], OrganisationService);
    return OrganisationService;
}());



/***/ }),

/***/ "./src/app/service/product.service.ts":
/*!********************************************!*\
  !*** ./src/app/service/product.service.ts ***!
  \********************************************/
/*! exports provided: ProductService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ProductService", function() { return ProductService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var rxjs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var httpOptions = {
    headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({ 'Content-Type': 'application/ld+json' })
};
var httpUploadsOptions = {
    headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({ 'Content-Type': 'multipart/form-data' })
};
var ProductService = /** @class */ (function () {
    function ProductService(http) {
        this.http = http;
        this.brandsUrl = '/brands';
        this.categoriesUrl = '/brand-categories';
        this.productsUrl = '/products';
        this.dealersUrl = '/dealers';
        this.registrationsUrl = '/registrations';
        this.verifyEmailUrl = '/email';
    }
    ProductService.prototype.getDealers = function () {
        var orgId = localStorage.getItem('orgId');
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["organisationPath"] + "/" + orgId + this.dealersUrl;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var collection = res["hydra:member"];
            var dealers = [];
            for (var _i = 0, collection_1 = collection; _i < collection_1.length; _i++) {
                var item = collection_1[_i];
                dealers.push({ id: item['@id'], name: item['name'] });
            }
            return dealers;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getBrands', [])));
    };
    ProductService.prototype.getBrands = function () {
        var orgId = localStorage.getItem('orgId');
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["organisationPath"] + "/" + orgId + this.brandsUrl;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var collection = res["hydra:member"];
            var brands = [];
            for (var _i = 0, collection_2 = collection; _i < collection_2.length; _i++) {
                var item = collection_2[_i];
                brands.push({ id: item['@id'], name: item['name'] });
            }
            return brands;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getBrands', [])));
    };
    ProductService.prototype.getCategories = function (brandId) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + brandId + this.categoriesUrl;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var collection = res["hydra:member"];
            var cats = [];
            for (var _i = 0, collection_3 = collection; _i < collection_3.length; _i++) {
                var item = collection_3[_i];
                cats.push({ id: item['@id'], name: item['name'] });
            }
            return cats;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getBrands', [])));
    };
    ProductService.prototype.getProductsByCategory = function (categoryId) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + categoryId + this.productsUrl;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var collection = res['hydra:member'];
            var prods = [];
            for (var _i = 0, collection_4 = collection; _i < collection_4.length; _i++) {
                var item = collection_4[_i];
                prods.push({ id: item['@id'], name: item['name'] });
            }
            return prods;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getProducts', [])));
    };
    // get warranties
    ProductService.prototype.getApiWarranties = function (regId) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.registrationsUrl + "/" + regId;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var collection = res['warranties'];
            // console.log('collection', collection);
            var prods = [];
            for (var _i = 0, collection_5 = collection; _i < collection_5.length; _i++) {
                var item = collection_5[_i];
                prods.push(item);
            }
            return prods;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getWarranties', [])));
    };
    // get data customer
    ProductService.prototype.getApiCustomer = function (regId) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.registrationsUrl + "/" + regId;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var dataCutomer = res["customer"];
            return dataCutomer;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getCustomer', [])));
    };
    // get data Registration
    ProductService.prototype.getApiRegistration = function (regId) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.registrationsUrl + "/" + regId;
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) {
            var dataRegistration = res;
            console.log('dataRegistration', dataRegistration);
            return dataRegistration;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('getRegistration', [])));
    };
    // verification email
    ProductService.prototype.postVerifyEmail = function (params) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.registrationsUrl + this.verifyEmailUrl;
        return this.http.post(url, params, httpOptions).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('postVerify', [])));
    };
    // delete image
    ProductService.prototype.deleteWarrantyImg = function (warId) {
        var url = _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointMedia"] + "/media/" + warId + ".json";
        console.log('warId', warId);
        return this.http.delete(url, warId).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["catchError"])(this.handleError('deleteImage', [])));
    };
    /**
     * Handle Http operation that failed.
     * Let the app continue.
     * @param operation - name of the operation that failed
     * @param result - optional value to return as the observable result
     */
    ProductService.prototype.handleError = function (operation, result) {
        if (operation === void 0) { operation = 'operation'; }
        return function (error) {
            // TODO: send the error to remote logging infrastructure
            console.error('error', error); // log to console instead
            // TODO: better job of transforming error for user consumption
            console.log(operation + " failed: " + error.message);
            // Let the app keep running by returning an empty result.
            return Object(rxjs__WEBPACK_IMPORTED_MODULE_2__["of"])(result);
        };
    };
    ProductService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"]])
    ], ProductService);
    return ProductService;
}());



/***/ }),

/***/ "./src/app/service/warranty.service.ts":
/*!*********************************************!*\
  !*** ./src/app/service/warranty.service.ts ***!
  \*********************************************/
/*! exports provided: WarrantyService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "WarrantyService", function() { return WarrantyService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var WarrantyService = /** @class */ (function () {
    function WarrantyService(http, modal) {
        this.http = http;
        this.modal = modal;
        this.warrantyUrl = "/warranties";
        this.url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_2__["apiEndPointBase"] + this.warrantyUrl;
        this.token = localStorage.getItem('token');
    }
    WarrantyService.prototype.updateWarrantyProduct = function (warranty) {
        return this.http.put(this.url + "/" + warranty.id, {
            product: warranty.product.id
        }, {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({
                'Content-Type': 'application/ld+json',
                'Authorization': "Bearer " + this.token
            })
        }).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) { return res; }));
    };
    WarrantyService.prototype.updateWarrantyProductSerialNumber = function (warranty) {
        return this.http.put(this.url + "/" + warranty.id, {
            productSerialNumber: warranty.productSerialNumber
        }, {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({
                'Content-Type': 'application/ld+json',
                'Authorization': "Bearer " + this.token
            })
        }).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_3__["map"])(function (res) { return res; }));
    };
    WarrantyService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"],
            ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_4__["BsModalService"]])
    ], WarrantyService);
    return WarrantyService;
}());



/***/ }),

/***/ "./src/environments/environment.ts":
/*!*****************************************!*\
  !*** ./src/environments/environment.ts ***!
  \*****************************************/
/*! exports provided: environment, apiEndPoint, apiEndPointBase, organisationPath, MEDIA_PREFIX, apiEndPointMedia, apiMediaUploadPath, binariesMedia */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "environment", function() { return environment; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "apiEndPoint", function() { return apiEndPoint; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "apiEndPointBase", function() { return apiEndPointBase; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "organisationPath", function() { return organisationPath; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MEDIA_PREFIX", function() { return MEDIA_PREFIX; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "apiEndPointMedia", function() { return apiEndPointMedia; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "apiMediaUploadPath", function() { return apiMediaUploadPath; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "binariesMedia", function() { return binariesMedia; });
// This file can be replaced during build by using the `fileReplacements` array.
// `ng build ---prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.
var environment = {
    production: false
};
var apiEndPoint = 'http://dev-swarranty.magentapulse.com';
var apiEndPointBase = '/api';
var organisationPath = '/organisations';
var MEDIA_PREFIX = '/media';
var apiEndPointMedia = 'http://dev-swarranty.magentapulse.com/media-api';
var apiMediaUploadPath = '/providers/sonata.media.provider.image/media.json';
var binariesMedia = '/binaries/reference/view.json';
/*
 * In development mode, to ignore zone related error stack frames such as
 * `zone.run`, `zoneDelegate.invokeTask` for easier debugging, you can
 * import the following file, but please comment it out in production mode
 * because it will have performance impact when throw error
 */
// import 'zone.js/dist/zone-error';  // Included with Angular CLI.


/***/ }),

/***/ "./src/main.ts":
/*!*********************!*\
  !*** ./src/main.ts ***!
  \*********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_platform_browser_dynamic__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/platform-browser-dynamic */ "./node_modules/@angular/platform-browser-dynamic/fesm5/platform-browser-dynamic.js");
/* harmony import */ var _app_app_module__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./app/app.module */ "./src/app/app.module.ts");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./environments/environment */ "./src/environments/environment.ts");




if (_environments_environment__WEBPACK_IMPORTED_MODULE_3__["environment"].production) {
    Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["enableProdMode"])();
}
Object(_angular_platform_browser_dynamic__WEBPACK_IMPORTED_MODULE_1__["platformBrowserDynamic"])().bootstrapModule(_app_app_module__WEBPACK_IMPORTED_MODULE_2__["AppModule"])
    .catch(function (err) { return console.log(err); });


/***/ }),

/***/ 0:
/*!***************************!*\
  !*** multi ./src/main.ts ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /srv/http/smart-warranty-dev/libraries/spa/ngx-technician/src/main.ts */"./src/main.ts");


/***/ })

},[[0,"runtime","vendor"]]]);
//# sourceMappingURL=main.js.map
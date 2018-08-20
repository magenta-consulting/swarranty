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
/* harmony import */ var _components_registration_registration_component__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/registration/registration.component */ "./src/app/components/registration/registration.component.ts");
/* harmony import */ var _components_uploads_uploads_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/uploads/uploads.component */ "./src/app/components/uploads/uploads.component.ts");
/* harmony import */ var _components_send_email_send_email_component__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/send-email/send-email.component */ "./src/app/components/send-email/send-email.component.ts");
/* harmony import */ var _components_success_success_component__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/success/success.component */ "./src/app/components/success/success.component.ts");
/* harmony import */ var _service_auth_guard_service__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./service/auth-guard.service */ "./src/app/service/auth-guard.service.ts");
/* harmony import */ var _components_survey_survey_component__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/survey/survey.component */ "./src/app/components/survey/survey.component.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};


// import component




// import services


var routes = [
    // { path: '', component:  AppComponent},
    { path: '', redirectTo: '/survey', pathMatch: 'full' },
    { path: 'survey', component: _components_survey_survey_component__WEBPACK_IMPORTED_MODULE_7__["SurveyComponent"], canActivate: [_service_auth_guard_service__WEBPACK_IMPORTED_MODULE_6__["AuthGuard"]] },
    { path: 'registration', component: _components_registration_registration_component__WEBPACK_IMPORTED_MODULE_2__["RegistrationComponent"] },
    { path: 'upload-receipt-image/:id', component: _components_uploads_uploads_component__WEBPACK_IMPORTED_MODULE_3__["UploadsComponent"] },
    { path: 'send-email/:id', component: _components_send_email_send_email_component__WEBPACK_IMPORTED_MODULE_4__["SendEmailComponent"] },
    { path: 'success/:id', component: _components_success_success_component__WEBPACK_IMPORTED_MODULE_5__["SuccessComponent"] },
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

module.exports = "<div class=\"text-center\">\n  <img class=\"logo\" src=\"{{logoSrc}}\">\n</div>\n<div class=\"container\">\n  <router-outlet></router-outlet>\n</div>\n\n<!--<h2 *ngFor=\"let item of data; index as i; first as isFirst\">-->\n  <!--{{item}} - <span *ngIf=\"isFirst\">default</span>-->\n<!--</h2>-->\n<!--<button class=\"btn btn-primary\" type=\"button\" (click)=\"addData()\">Add Item</button>-->\n"

/***/ }),

/***/ "./src/app/app.component.scss":
/*!************************************!*\
  !*** ./src/app/app.component.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".logo {\n  max-height: 120px;\n  width: auto;\n  margin-bottom: 30px; }\n"

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
/* harmony import */ var _service_organisation_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./service/organisation.service */ "./src/app/service/organisation.service.ts");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
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
        this.title = 'app';
        this.data = ['item 1', 'item 2', 'item 3'];
        this.logoSrc = null;
        var native = eRef.nativeElement;
        var orgId = native.getAttribute('organisation');
        localStorage.setItem('orgId', orgId);
        organisationService.getLogo().subscribe(function (logoSrc) { return _this.logoSrc = logoSrc; });
    }
    AppComponent.prototype.addData = function () {
        this.data.push('new data');
    };
    AppComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'app-root',
            template: __webpack_require__(/*! ./app.component.html */ "./src/app/app.component.html"),
            styles: [__webpack_require__(/*! ./app.component.scss */ "./src/app/app.component.scss")]
        }),
        __metadata("design:paramtypes", [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"],
            _service_organisation_service__WEBPACK_IMPORTED_MODULE_1__["OrganisationService"],
            _angular_router__WEBPACK_IMPORTED_MODULE_2__["Router"]])
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
/* harmony import */ var _components_registration_registration_component__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./components/registration/registration.component */ "./src/app/components/registration/registration.component.ts");
/* harmony import */ var _components_uploads_uploads_component__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./components/uploads/uploads.component */ "./src/app/components/uploads/uploads.component.ts");
/* harmony import */ var _components_send_email_send_email_component__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./components/send-email/send-email.component */ "./src/app/components/send-email/send-email.component.ts");
/* harmony import */ var _components_success_success_component__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./components/success/success.component */ "./src/app/components/success/success.component.ts");
/* harmony import */ var _service_auth_guard_service__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ./service/auth-guard.service */ "./src/app/service/auth-guard.service.ts");
/* harmony import */ var ng2_completer__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! ng2-completer */ "./node_modules/ng2-completer/esm5/ng2-completer.js");
/* harmony import */ var _extensions_angular2_image_upload__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! ./extensions/angular2-image-upload */ "./src/app/extensions/angular2-image-upload/index.js");
/* harmony import */ var _helper_helper__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! ./helper/helper */ "./src/app/helper/helper.ts");
/* harmony import */ var _agm_core__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(/*! @agm/core */ "./node_modules/@agm/core/index.js");
/* harmony import */ var _components_survey_survey_component__WEBPACK_IMPORTED_MODULE_20__ = __webpack_require__(/*! ./components/survey/survey.component */ "./src/app/components/survey/survey.component.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};











// import components




// import services


// import libs




var AppModule = /** @class */ (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
            declarations: [
                _app_component__WEBPACK_IMPORTED_MODULE_2__["AppComponent"],
                _components_registration_registration_component__WEBPACK_IMPORTED_MODULE_11__["RegistrationComponent"],
                _directive_focus_directive__WEBPACK_IMPORTED_MODULE_10__["FocusDirective"],
                _components_uploads_uploads_component__WEBPACK_IMPORTED_MODULE_12__["UploadsComponent"],
                _components_send_email_send_email_component__WEBPACK_IMPORTED_MODULE_13__["SendEmailComponent"],
                _components_success_success_component__WEBPACK_IMPORTED_MODULE_14__["SuccessComponent"],
                _components_survey_survey_component__WEBPACK_IMPORTED_MODULE_20__["SurveyComponent"]
            ],
            imports: [
                _angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__["BrowserModule"],
                _ng_select_ng_select__WEBPACK_IMPORTED_MODULE_4__["NgSelectModule"],
                _angular_forms__WEBPACK_IMPORTED_MODULE_5__["FormsModule"],
                _angular_forms__WEBPACK_IMPORTED_MODULE_5__["ReactiveFormsModule"],
                _angular_common_http__WEBPACK_IMPORTED_MODULE_9__["HttpClientModule"],
                angular_font_awesome__WEBPACK_IMPORTED_MODULE_6__["AngularFontAwesomeModule"],
                ngx_bootstrap_datepicker__WEBPACK_IMPORTED_MODULE_7__["BsDatepickerModule"].forRoot(),
                ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_8__["ModalModule"].forRoot(),
                // import libs
                _extensions_angular2_image_upload__WEBPACK_IMPORTED_MODULE_17__["ImageUploadModule"].forRoot(),
                _agm_core__WEBPACK_IMPORTED_MODULE_19__["AgmCoreModule"].forRoot({
                    apiKey: "AIzaSyAN6XsSJRAUI4Iuj0Q3OdziE1D0Sou_b_c",
                    libraries: ["places"]
                }),
                ng2_completer__WEBPACK_IMPORTED_MODULE_16__["Ng2CompleterModule"],
                _app_routing_module__WEBPACK_IMPORTED_MODULE_3__["AppRoutingModule"]
            ],
            providers: [_service_auth_guard_service__WEBPACK_IMPORTED_MODULE_15__["AuthGuard"], _helper_helper__WEBPACK_IMPORTED_MODULE_18__["Helper"]],
            bootstrap: [_app_component__WEBPACK_IMPORTED_MODULE_2__["AppComponent"]]
        })
    ], AppModule);
    return AppModule;
}());



/***/ }),

/***/ "./src/app/components/registration/registration.component.html":
/*!*********************************************************************!*\
  !*** ./src/app/components/registration/registration.component.html ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n    <div class=\"col-md-6 offset-md-3 col-lg-4 offset-lg-4\">\n        <div class=\"text-center\">\n            <h3>Customer and Product Registration</h3>\n            <section>\n                <h5>Customer Details</h5>\n                <div *ngIf=\"!isPreview('customerName')\">\n                    <div class=\"input-group mb-2\">\n                        <input [(ngModel)]=\"customer.name\" type=\"text\" class=\"form-control\"\n                               placeholder=\"(*) Your Full name\"\n                               aria-label=\"Your Full name\"\n                               (keyup.enter)=\"updateField('customerName')\"\n                               (blur)=\"updateField('customerName')\">\n                    </div>\n                </div>\n                <div *ngIf=\"isPreview('customerName')\" (click)=\"editPreview('customerName')\">\n                    <div class=\"input-group mb-2 preview-container\">\n                        <div class=\"input-group-prepend preview-label\">\n                            <span class=\"input-group-text\">Full Name </span>\n                        </div>\n                        <div class=\"form-control preview-text\">\n                            <span>{{customer.name}}</span>\n                        </div>\n                        <div class=\"input-group-append\">\n                            <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                        </div>\n                    </div>\n                </div>\n                <div *ngIf=\"checkingError && (customer.name == null || customer.name == '')\" class=\"alert alert-danger\"\n                     role=\"alert\">\n                    This field is required\n                </div>\n                <div *ngIf=\"!isPreview('customerTelephone')\">\n                    <div class=\"input-group mb-2\">\n                        <div class=\"input-group-prepend\">\n                            <span *ngIf=\"!isDialingCodeEditing\" (click)=\"editDialingCode()\" class=\"input-group-text\">+{{customer.dialingCode}}</span>\n                            <input #dialingCode [focus]=\"focusDialingCodeEM\" *ngIf=\"isDialingCodeEditing\"\n                                   style=\"width: 45px;\" type=\"number\" class=\"form-control mr-1\" value=\"65\"\n                                   aria-label=\"Country Dialing Code\"\n                                   (keyup.enter)=\"updateDialingCode(dialingCode.value)\"\n                                   (blur)=\"updateDialingCode(dialingCode.value)\">\n                        </div>\n                        <input type=\"number\" [(ngModel)]=\"customer.telephone\" class=\"form-control\"\n                               placeholder=\"(*) Contact Number\"\n                               aria-label=\"Contact Number\"\n                               (keyup.enter)=\"updateField('customerTelephone')\"\n                               (blur)=\"updateField('customerTelephone')\"\n                               (keypress)=\"checkPhone($event)\"\n                        />\n                    </div>\n                </div>\n                <div *ngIf=\"isPreview('customerTelephone')\" (click)=\"editPreview('customerTelephone')\">\n                    <div class=\"input-group mb-2 preview-container\">\n                        <div class=\"input-group-prepend preview-label\">\n                            <span class=\"input-group-text\">Contact Number </span>\n                        </div>\n                        <div class=\"form-control preview-text\">\n                            <span>+{{customer.dialingCode}} {{ customer.telephone }}</span>\n                        </div>\n                        <div class=\"input-group-append\">\n                            <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                        </div>\n                    </div>\n                </div>\n                <div *ngIf=\"checkingError && (!customer.telephone || customer.telephone.toString().length != 8)\"\n                     class=\"alert alert-danger\" role=\"alert\">\n                    <span *ngIf=\"!customer.telephone\">This field is required</span>\n                    <span *ngIf=\"customer.telephone && customer.telephone.toString().length != 8\">Contact number has 8 digits</span>\n                </div>\n                <div *ngIf=\"!isPreview('emailAddress')\" class=\"input-group mb-2\">\n                    <input [(ngModel)]=\"customer.email\" type=\"text\" class=\"form-control\" placeholder=\"Email Address\"\n                           aria-label=\"Email Address\"\n                           (keyup.enter)=\"updateField('emailAddress')\"\n                           (focus)=\"typingEmail=true\"\n                           (blur)=\"updateField('emailAddress'); typingEmail=false;\"\n                           (change)=\"customer.email = customer.email.trim().toLowerCase()\"\n                    >\n                </div>\n                <div *ngIf=\"isPreview('emailAddress')\" (click)=\"editPreview('emailAddress')\"\n                     class=\"input-group mb-2 preview-container\">\n                    <div class=\"input-group-prepend preview-label\">\n                        <span class=\"input-group-text\">Email Address </span>\n                    </div>\n                    <div class=\"form-control preview-text\">\n                        <span>{{customer.email}}</span>\n                    </div>\n                    <div class=\"input-group-append\">\n                        <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                    </div>\n                </div>\n                <div *ngIf=\"!isEmailValid() && !typingEmail\" class=\"alert alert-danger\" role=\"alert\">\n                    Email must be valid!\n                </div>\n                <div *ngIf=\"!isPreview('emailConfirm')\" class=\"input-group mb-2\">\n                    <input [(ngModel)]=\"emailConfirm\" type=\"text\" class=\"form-control\"\n                           placeholder=\"Confirm Email Address\"\n                           aria-label=\"Confirm Email Address\"\n                           (keyup.enter)=\"updateField('emailConfirm')\"\n                           (blur)=\"updateField('emailConfirm'); typingConfirm=false\"\n                           (focus)=\"typingConfirm=true\"\n                           (change)=\"emailConfirm = emailConfirm.trim().toLowerCase()\"\n                    >\n                </div>\n                <div *ngIf=\"isPreview('emailConfirm')\" (click)=\"editPreview('emailConfirm')\"\n                     class=\"input-group mb-2 preview-container\">\n                    <div class=\"input-group-prepend preview-label\">\n                        <span class=\"input-group-text\">Confirm Email Address </span>\n                    </div>\n                    <div class=\"form-control preview-text\">\n                        <span>{{emailConfirm}}</span>\n                    </div>\n                    <div class=\"input-group-append\">\n                        <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                    </div>\n                </div>\n                <div *ngIf=\"customer.email && emailConfirm != customer.email && !typingConfirm && !typingEmail\"\n                     class=\"alert alert-danger\" role=\"alert\">\n                    The Confirmation Email must match your Email!\n                </div>\n                <div *ngIf=\"!isPreview('homeAddress')\" class=\"input-group mb-2\">\n                    <input [(ngModel)]=\"customer.homeAddress\" type=\"text\" class=\"form-control\"\n                           placeholder=\"Your Address\"\n                           aria-label=\"Your Address\"\n                           (keyup.enter)=\"updateField('homeAddress')\"\n                           (blur)=\"updateField('homeAddress')\"\n                           autocorrect=\"off\" autocapitalize=\"off\" spellcheck=\"off\" type=\"text\" #search\n                           [formControl]=\"searchControl\"\n                    >\n\n                </div>\n                <div *ngIf=\"isPreview('homeAddress')\" (click)=\"editPreview('homeAddress')\"\n                     class=\"input-group mb-2 preview-container\">\n                    <div class=\"input-group-prepend preview-label\">\n                        <span class=\"input-group-text\">Your Address </span>\n                    </div>\n                    <div class=\"form-control preview-text\">\n                        <span>{{customer.homeAddress}}</span>\n                    </div>\n                    <div class=\"input-group-append\">\n                        <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                    </div>\n                </div>\n                <div *ngIf=\"isPreview('addressUnitNumber')\" (click)=\"editPreview('addressUnitNumber')\"\n                     class=\"input-group mb-2 preview-container\">\n                    <div class=\"input-group-prepend preview-label\">\n                        <span class=\"input-group-text\">Unit/Block/House Number </span>\n                    </div>\n                    <div class=\"form-control preview-text\">\n                        <span>{{customer.addressUnitNumber}}</span>\n                    </div>\n                    <div class=\"input-group-append\">\n                        <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                    </div>\n                </div>\n                <div *ngIf=\"!isPreview('addressUnitNumber')\" class=\"input-group mb-2\">\n                    <input [(ngModel)]=\"customer.addressUnitNumber\" type=\"text\" class=\"form-control\"\n                           placeholder=\"Unit/Block/House Number\"\n                           aria-label=\"Unit/Block/House Number\"\n                           (keyup.enter)=\"updateField('addressUnitNumber')\"\n                           (blur)=\"updateField('addressUnitNumber')\"\n                    >\n                </div>\n                <div *ngIf=\"!isPreview('homePostalCode')\" class=\"input-group mb-2\">\n                    <input [(ngModel)]=\"customer.homePostalCode\" type=\"text\" class=\"form-control\"\n                           placeholder=\"Postal Code\"\n                           aria-label=\"Postal Code\"\n                           (keyup.enter)=\"updateField('homePostalCode')\"\n                           (blur)=\"updateField('homePostalCode')\"\n                           type=\"number\"\n                    >\n                </div>\n                <div *ngIf=\"isPreview('homePostalCode')\" (click)=\"editPreview('homePostalCode')\"\n                     class=\"input-group mb-2 preview-container\">\n                    <div class=\"input-group-prepend preview-label\">\n                        <span class=\"input-group-text\">Postal Code </span>\n                    </div>\n                    <div class=\"form-control preview-text\">\n                        <span>{{customer.homePostalCode}}</span>\n                    </div>\n                    <div class=\"input-group-append\">\n                        <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                    </div>\n                </div>\n            </section>\n            <h3>Product Purchase Information</h3>\n            <section *ngFor=\"let warranty of warranties; index as i; first as isFirst\">\n                <div *ngIf=\"!isFirst\" class=\"remove-product mb-2\" (click)=\"removeWarranty(warranty)\">\n                    <fa size=\"lg\" name=\"minus-square\"></fa>\n                    Remove\n                </div>\n                <div *ngIf=\"!isPreview('productBrand'+i)\">\n                    <div class=\"input-group mb-2\">\n                        <ng-select class=\"mb-2\" (change)=\"selectBrand($event,warranty)\" [items]=\"warranty.brands\"\n                                   bindLabel=\"name\"\n                                   placeholder=\"(*) Product Brand\"\n                                   [(ngModel)]=\"warranty.selectedBrand\"\n                                   (blur)=\"updateField('productBrand'+i)\">\n                        </ng-select>\n                    </div>\n                </div>\n                <div *ngIf=\"isPreview('productBrand'+i)\" (click)=\"editPreview('productBrand'+i)\">\n                    <div class=\"input-group mb-2 preview-container\">\n                        <div class=\"input-group-prepend preview-label\">\n                            <span class=\"input-group-text\">Product Brand </span>\n                        </div>\n                        <div class=\"form-control preview-text\">\n                            <span>{{warranty.selectedBrand.name}}</span>\n                        </div>\n                        <div class=\"input-group-append\">\n                            <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                        </div>\n                    </div>\n                </div>\n                <div *ngIf=\"checkingError && warranty.selectedBrand == null\" class=\"alert alert-danger\" role=\"alert\">\n                    This field is required\n                </div>\n                <div *ngIf=\"!warranty.isCategoryHidden\">\n                    <div *ngIf=\"!isPreview('productCategory'+i)\" class=\"input-group mb-2\">\n                        <ng-select (change)=\"selectCategory($event,warranty)\" class=\"mb-2\"\n                                   [items]=\"warranty.categories\"\n                                   bindLabel=\"name\"\n                                   placeholder=\"(*) Product Category\"\n                                   [(ngModel)]=\"warranty.selectedCategory\"\n                                   (blur)=\"updateField('productCategory'+i)\">\n                        </ng-select>\n                    </div>\n                    <div *ngIf=\"isPreview('productCategory'+i)\" (click)=\"editPreview('productCategory'+i)\"\n                         class=\"input-group mb-2 preview-container\">\n                        <div class=\"input-group-prepend preview-label\">\n                            <span class=\"input-group-text\">Product Category </span>\n                        </div>\n                        <div class=\"form-control preview-text\">\n                            <span>{{warranty.selectedCategory.name}}</span>\n                        </div>\n                        <div class=\"input-group-append\">\n                            <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                        </div>\n                    </div>\n                    <div *ngIf=\"checkingError && warranty.selectedCategory == null\" class=\"alert alert-danger\"\n                         role=\"alert\">\n                        This field is required\n                    </div>\n                </div>\n                <div *ngIf=\"!warranty.isProductHidden\">\n                    <div *ngIf=\"!isPreview('modelName'+i)\" class=\"input-group mb-2\">\n                        <ng-select class=\"mb-2\" [items]=\"warranty.products\"\n                                   bindLabel=\"name\"\n                                   placeholder=\"(*) Model Name\"\n                                   [(ngModel)]=\"warranty.selectedProduct\"\n                                   (blur)=\"updateField('modelName'+i)\">\n                        </ng-select>\n                    </div>\n                    <div *ngIf=\"isPreview('modelName'+i)\" (click)=\"editPreview('modelName'+i)\"\n                         class=\"input-group mb-2 preview-container\">\n                        <div class=\"input-group-prepend preview-label\">\n                            <span class=\"input-group-text\">Model Name </span>\n                        </div>\n                        <div class=\"form-control preview-text\">\n                            <span>{{warranty.selectedProduct.name}}</span>\n                        </div>\n                        <div class=\"input-group-append\">\n                            <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                        </div>\n                    </div>\n                    <div *ngIf=\"checkingError && warranty.selectedProduct == null\" class=\"alert alert-danger\"\n                         role=\"alert\">\n                        This field is required\n                    </div>\n                </div>\n                <div *ngIf=\"!isPreview('purchaseDate'+i)\">\n                    <div class=\"input-group mb-2\">\n                        <input [(ngModel)]=\"warranty.purchaseDate\" type=\"text\"\n                               placeholder=\"(*) Delivery Date (DD-MM-YYYY)\"\n                               class=\"form-control\"\n                               [bsConfig]=\"{ dateInputFormat: 'DD-MM-YYYY' }\"\n                               (ngModelChange)=\"updateField('purchaseDate'+i)\"\n                               bsDatepicker/>\n                    </div>\n                </div>\n                <div *ngIf=\"isPreview('purchaseDate'+i)\" (click)=\"editPreview('purchaseDate'+i)\">\n                    <div class=\"input-group mb-2 preview-container\">\n                        <div class=\"input-group-prepend preview-label\">\n                            <span class=\"input-group-text\">Delivery Date </span>\n                        </div>\n                        <div class=\"form-control preview-text\">\n                            <span>{{warranty.purchaseDate|date}}</span>\n                        </div>\n                        <div class=\"input-group-append\">\n                            <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                        </div>\n                    </div>\n                </div>\n                <div *ngIf=\"checkingError && warranty.purchaseDate == null\" class=\"alert alert-danger\" role=\"alert\">\n                    This field is required\n                </div>\n                <div *ngIf=\"!isPreview('productSerialNumber'+i)\" class=\"input-group mb-1\">\n                    <input [(ngModel)]=\"warranty.productSerialNumber\" type=\"text\" class=\"form-control\"\n                           placeholder=\"(*) Product Serial Number\"\n                           aria-label=\"Product Serial Number\"\n                           (keyup.enter)=\"updateField('productSerialNumber'+i)\"\n                           (blur)=\"updateField('productSerialNumber'+i)\">\n                </div>\n                <div *ngIf=\"!isPreview('productSerialNumber'+i)\" class=\"input-group mb-2\"><a href=\"{{organisation.psnLocationUrl}}\" target=\"_blank\">How\n                    to find the product serial number.</a></div>\n                <div *ngIf=\"isPreview('productSerialNumber'+i)\" (click)=\"editPreview('productSerialNumber'+i)\"\n                     class=\"input-group mb-2 preview-container\">\n                    <div class=\"input-group-prepend preview-label\">\n                        <span class=\"input-group-text\">Serial Number </span>\n                    </div>\n                    <div class=\"form-control preview-text\">\n                        <span>{{warranty.productSerialNumber}}</span>\n                    </div>\n                    <div class=\"input-group-append\">\n                        <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                    </div>\n                </div>\n                <div *ngIf=\"checkingError && warranty.productSerialNumber == null\" class=\"alert alert-danger\"\n                     role=\"alert\">\n                    This field is required\n                </div>\n                <div *ngIf=\"!isPreview('dealerName'+i)\" class=\"input-group mb-2\">\n                    <ng-select class=\"mb-2\" [items]=\"warranty.dealers\"\n                               bindLabel=\"name\"\n                               placeholder=\"Dealer's Name\"\n                               [(ngModel)]=\"warranty.selectedDealer\"\n                               (blur)=\"updateField('dealerName'+i)\">\n                    </ng-select>\n                    <!--<ng2-completer class=\"ng2-ipt mb-2\"-->\n                    <!--placeholder=\"Dealer's Name\"-->\n                    <!--[(ngModel)]=\"warranty.selectedDealer\"-->\n                    <!--[datasource]=\"dataDealers\"-->\n                    <!--inputClass=\"form-control\"-->\n                    <!--[minSearchLength]=\"0\"></ng2-completer>-->\n                </div>\n                <div *ngIf=\"isPreview('dealerName'+i)\" (click)=\"editPreview('dealerName'+i)\"\n                     class=\"input-group mb-2 preview-container\">\n                    <div class=\"input-group-prepend preview-label\">\n                        <span class=\"input-group-text\">Dealer's Name </span>\n                    </div>\n                    <div class=\"form-control preview-text\">\n                        <span>{{warranty.selectedDealer.name}}</span>\n                    </div>\n                    <div class=\"input-group-append\">\n                        <span class=\"input-group-text\"><fa name=\"edit\"></fa></span>\n                    </div>\n                </div>\n            </section>\n            <div *ngIf=\"!isFormPreview\" class=\"input-group mb-2\" style=\"cursor: pointer;\" (click)=\"addWarranty()\">\n                <fa size=\"lg\" name=\"plus-square\"></fa>\n                <span class=\"add-product-text\"> Add another Product</span>\n            </div>\n            <section *ngIf=\"!isFormPreview\" class=\"checkboxes\">\n                <div *ngIf=\"customer.email\" class=\"form-check\">\n                    <input type=\"checkbox\" aria-label=\"Checkbox for following text input\"\n                           id=\"newsletterSubscription\" [(ngModel)]=\"subscribeNewsletter\">\n                    <label class=\"form-check-label\" for=\"newsletterSubscription\">\n                        Keep me updated on new {{organisation.name}} product and promotions.\n                    </label>\n                </div>\n                <div class=\"form-check\">\n                    <input required=\"required\" type=\"checkbox\" [(ngModel)]=\"isAgreedToTermsAndPolicy\"\n                           aria-label=\"Checkbox for following text input\" id=\"agreeTos\">\n                    <label class=\"form-check-label\" for=\"agreeTos\">\n                        I have read and agree to the <a (click)=\"lgModal.show();getInforModal(1); false\">Warranty Terms\n                        and Conditions</a> and <a (click)=\"lgModal.show();getInforModal(2);false\">{{organisation.name}}\n                        Data Protection Policy</a>.\n                    </label>\n                </div>\n                <div *ngIf=\"!isAgreedToTermsAndPolicy && checkingError\" class=\"alert alert-danger\" role=\"alert\">\n                    Please read and agree to our Terms, Conditions and Policy.\n                </div>\n            </section>\n            <section>\n                <div class=\"input-group mb-2\">\n                    <button *ngIf=\"!isFormPreview\" (click)=\"submit()\" type=\"button\"\n                            class=\"btn btn-primary form-control\">REGISTER\n                    </button>\n                    <button *ngIf=\"isFormPreview\" (click)=\"submit()\" type=\"button\" class=\"btn btn-danger form-control\"\n                            [disabled]=\"!isOk() || processing\">CONFIRM\n                    </button>\n                </div>\n            </section>\n        </div>\n    </div>\n</div>\n\n<div bsModal #lgModal=\"bs-modal\" class=\"modal fade\" tabindex=\"-1\"\n     role=\"dialog\" aria-labelledby=\"dialog-sizes-name1\">\n    <div class=\"modal-dialog modal-lg\">\n        <div class=\"modal-content\">\n            <div class=\"modal-header\">\n                <h4 id=\"dialog-sizes-name1\" class=\"modal-title pull-left\">{{modalTitle}}</h4>\n                <button type=\"button\" class=\"close pull-right\" (click)=\"lgModal.hide()\" aria-label=\"Close\">\n                    <span aria-hidden=\"true\">&times;</span>\n                </button>\n            </div>\n            <div class=\"modal-body\" [innerHtml]=\"modalContent\">\n            </div>\n            <div class=\"modal-footer\">\n                <button type=\"button\" class=\"btn btn-default\" (click)=\"lgModal.hide()\">Close</button>\n            </div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/components/registration/registration.component.scss":
/*!*********************************************************************!*\
  !*** ./src/app/components/registration/registration.component.scss ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".add-product-text, .remove-product {\n  cursor: pointer;\n  display: inherit;\n  text-align: left;\n  padding-left: 3px; }\n\ninput::-webkit-outer-spin-button,\ninput::-webkit-inner-spin-button {\n  -webkit-appearance: none; }\n\n.preview-label {\n  flex: 0 0 101px; }\n\n.preview-label .input-group-text {\n  width: 101px; }\n\n.preview-text {\n  display: flex;\n  align-items: center; }\n\n.preview-label .input-group-text {\n  white-space: normal; }\n\n.preview-container {\n  cursor: pointer; }\n\ndiv.input-group ng-select {\n  width: 100%; }\n\n.alert.alert-danger {\n  text-align: left; }\n\na {\n  color: #0056b3 !important;\n  cursor: pointer; }\n\na:hover {\n  text-decoration: underline !important; }\n\ntable.checkboxes td {\n  text-align: left !important;\n  vertical-align: top;\n  padding-right: 15px; }\n\n.form-check {\n  text-align: left !important;\n  padding-left: 0px;\n  display: flex;\n  align-items: baseline; }\n\n.form-check-label {\n  padding-left: 10px; }\n\nagm-map {\n  height: 300px; }\n"

/***/ }),

/***/ "./src/app/components/registration/registration.component.ts":
/*!*******************************************************************!*\
  !*** ./src/app/components/registration/registration.component.ts ***!
  \*******************************************************************/
/*! exports provided: RegistrationComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RegistrationComponent", function() { return RegistrationComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _service_product_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../service/product.service */ "./src/app/service/product.service.ts");
/* harmony import */ var _model_warranty__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../model/warranty */ "./src/app/model/warranty.ts");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _service_organisation_service__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../service/organisation.service */ "./src/app/service/organisation.service.ts");
/* harmony import */ var _service_customer_service__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../service/customer.service */ "./src/app/service/customer.service.ts");
/* harmony import */ var _model_registration__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../model/registration */ "./src/app/model/registration.ts");
/* harmony import */ var _service_registration_service__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../../service/registration.service */ "./src/app/service/registration.service.ts");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
/* harmony import */ var _agm_core__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @agm/core */ "./node_modules/@agm/core/index.js");
/* harmony import */ var ng2_completer__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ng2-completer */ "./node_modules/ng2-completer/esm5/ng2-completer.js");
/* harmony import */ var _service_newsletter_subscription_service__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../../service/newsletter-subscription.service */ "./src/app/service/newsletter-subscription.service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};












var RegistrationComponent = /** @class */ (function () {
    function RegistrationComponent(productService, organisationService, customerService, registrationService, newsletterSubscriptionService, router, mapsAPILoader, ngZone, completerService) {
        var _this = this;
        this.productService = productService;
        this.organisationService = organisationService;
        this.customerService = customerService;
        this.registrationService = registrationService;
        this.newsletterSubscriptionService = newsletterSubscriptionService;
        this.router = router;
        this.mapsAPILoader = mapsAPILoader;
        this.ngZone = ngZone;
        this.completerService = completerService;
        this.focusDialingCodeEM = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
        this.customer = { id: null, name: null, dialingCode: 65 };
        this.isAgreedToTermsAndPolicy = false;
        this.processing = false;
        this.warranties = [];
        this.isDialingCodeEditing = false;
        this.previewStates = {};
        this.isFormPreview = false;
        this.checkingError = false;
        this.organisation = { id: null, name: null, tos: null, dataPolicy: null };
        var warranty = new _model_warranty__WEBPACK_IMPORTED_MODULE_2__["Warranty"]();
        warranty.id = null;
        this.warranties.push(warranty);
        productService.getBrands().subscribe(function (brands) { return warranty.brands = brands; });
        productService.getDealers().subscribe(function (d) {
            warranty.dealers = d;
            _this.dataDealers = completerService.local(warranty.dealers, 'id', 'name');
        });
        organisationService.getOrganisation().subscribe(function (organisation) { return _this.organisation = organisation; });
    }
    RegistrationComponent.prototype.ngOnInit = function () {
        if (!localStorage.getItem('survey')) {
            this.router.navigate(['/survey']);
            return;
        }
        this.initMap();
    };
    RegistrationComponent.prototype.ngAfterViewInit = function () {
    };
    RegistrationComponent.prototype.isPreview = function (field) {
        if (!this.previewStates.hasOwnProperty(field)) {
            this.previewStates[field] = true;
        }
        return this.previewStates[field] && this.isFormPreview;
    };
    RegistrationComponent.prototype.editPreview = function (field) {
        this.previewStates[field] = false;
    };
    RegistrationComponent.prototype.updateField = function (field) {
        this.previewStates[field] = true;
    };
    RegistrationComponent.prototype.isEmailValid = function () {
        if (this.customer.email == null || this.customer.email.trim() === '') {
            return true;
        }
        return (/^.+\@.+\..+$/.test(this.customer.email));
    };
    RegistrationComponent.prototype.isOk = function () {
        if (this.customer.name == null || this.customer.name.trim() === '') {
            return false;
        }
        if (!this.customer.telephone) {
            return false;
        }
        if (this.customer.telephone && this.customer.telephone.toString().length != 8) {
            return false;
        }
        if (!this.isEmailValid()) {
            return false;
        }
        if (this.emailConfirm != null) {
            if (this.emailConfirm.trim() !== this.customer.email.trim()) {
                return false;
            }
        }
        else {
            if (this.customer.email != null) {
                return false;
            }
        }
        for (var i = 0; i < this.warranties.length; i++) {
            var warranty = this.warranties[i];
            if (warranty.selectedBrand == null || warranty.selectedCategory == null || warranty.selectedProduct == null) {
                return false;
            }
            if (warranty.purchaseDate == null) {
                return false;
            }
        }
        return this.isAgreedToTermsAndPolicy;
    };
    RegistrationComponent.prototype.submit = function () {
        var _this = this;
        if (this.isFormPreview) {
            this.processing = true;
            // Confirmed
            this.customerService.postCustomer(this.customer).subscribe(function (customer) {
                var reg = new _model_registration__WEBPACK_IMPORTED_MODULE_6__["Registration"]();
                reg.customer = customer['@id'];
                reg['dialingCode'] = customer.dialingCode;
                reg['email'] = customer.email;
                reg['homeAddress'] = customer.homeAddress;
                reg['addressUnitNumber'] = _this.customer.addressUnitNumber;
                reg['homePostalCode'] = customer.homePostalCode;
                reg['name'] = customer.name;
                reg['organisation'] = customer.organisation;
                reg['telephone'] = customer.telephone;
                reg.submitted = false;
                _this.attachSurvey(reg);
                reg.warranties = [];
                for (var _i = 0, _a = _this.warranties; _i < _a.length; _i++) {
                    var w = _a[_i];
                    var rw = { customer: reg.customer };
                    rw.product = w.selectedProduct.id;
                    rw.purchaseDate = w.purchaseDate;
                    rw.productSerialNumber = w.productSerialNumber;
                    rw.dealer = w.selectedDealer.id;
                    reg.warranties.push(rw);
                }
                _this.registrationService.postRegistration(reg).subscribe(function (reg) {
                    localStorage.setItem('regId', reg['@id']);
                    var regId = reg['@id'];
                    var cutstr = '/api/registrations/';
                    console.log('regId', regId, cutstr.length);
                    var regRId = regId.substring(cutstr.length);
                    _this.router.navigate(["/upload-receipt-image/" + regRId]);
                });
                if (_this.customer.email != null && _this.customer.email.trim() != '' && _this.subscribeNewsletter) {
                    _this.newsletterSubscriptionService.postNewsletterSubscription(_this.customer).subscribe(function (res) {
                        console.log('Newsletter subscription successfully!');
                    });
                }
            });
        }
        else {
            if (this.isOk()) {
                this.isFormPreview = true;
            }
            else {
                this.processing = false;
            }
            this.checkingError = true;
        }
        // this.router.navigate(['/preview', {customer: this.customer, warranties: this.warranties}]);
    };
    RegistrationComponent.prototype.editDialingCode = function () {
        this.isDialingCodeEditing = true;
        this.focusDialingCodeEM.emit(true);
    };
    RegistrationComponent.prototype.updateDialingCode = function (value) {
        this.customer.dialingCode = value;
        this.isDialingCodeEditing = false;
    };
    RegistrationComponent.prototype.removeWarranty = function (w) {
        var index = this.warranties.indexOf(w);
        if (index > -1) {
            this.warranties.splice(index, 1);
            this.warranties = this.warranties;
        }
    };
    RegistrationComponent.prototype.addWarranty = function () {
        var _this = this;
        var warranty = new _model_warranty__WEBPACK_IMPORTED_MODULE_2__["Warranty"]();
        warranty.id = null;
        this.warranties.push(warranty);
        this.productService.getBrands().subscribe(function (brands) { return warranty.brands = brands; });
        this.productService.getDealers().subscribe(function (d) {
            warranty.dealers = d;
            _this.dataDealers = _this.completerService.local(warranty.dealers, 'id', 'name');
        });
    };
    RegistrationComponent.prototype.selectBrand = function (e, warranty) {
        if (warranty.selectedBrand.id !== null) {
            warranty.categories = [{ id: null, name: 'Loading' }];
            warranty.isProductHidden = true;
            warranty.isCategoryHidden = true;
            this.productService.getCategories(warranty.selectedBrand.id).subscribe(function (cats) {
                warranty.categories = cats;
                warranty.isCategoryHidden = false;
                warranty.selectedCategory = null;
            });
        }
    };
    RegistrationComponent.prototype.selectCategory = function (e, warranty) {
        if (warranty.selectedCategory.id !== null) {
            warranty.products = [{ id: null, name: 'Loading' }];
            warranty.isProductHidden = true;
            this.productService.getProductsByCategory(warranty.selectedCategory.id).subscribe(function (prods) {
                warranty.products = prods;
                warranty.isProductHidden = false;
                warranty.selectedProduct = null;
            });
        }
    };
    RegistrationComponent.prototype.getInforModal = function (type) {
        if (type == 1) {
            this.modalTitle = 'Terms and Conditions';
            this.modalContent = this.organisation.tos;
        }
        else if (type == 2) {
            this.modalTitle = 'Data Protection Policy';
            this.modalContent = this.organisation.dataPolicy;
        }
    };
    RegistrationComponent.prototype.initMap = function () {
        var _this = this;
        //set google maps defaults
        this.zoom = 4;
        this.latitude = 39.8282;
        this.longitude = -98.5795;
        //create search FormControl
        this.searchControl = new _angular_forms__WEBPACK_IMPORTED_MODULE_8__["FormControl"]();
        //set current position
        this.setCurrentPosition();
        //load Places Autocomplete
        this.mapsAPILoader.load().then(function () {
            var autocomplete = new google.maps.places.Autocomplete(_this.searchElementRef.nativeElement, {
                types: ["address"]
            });
            autocomplete.addListener("place_changed", function () {
                _this.ngZone.run(function () {
                    //get the place result
                    var place = autocomplete.getPlace();
                    //verify result
                    if (place.geometry === undefined || place.geometry === null) {
                        return;
                    }
                    // get address information
                    _this.customer.homeAddress = place.formatted_address;
                    //set latitude, longitude and zoom
                    _this.latitude = place.geometry.location.lat();
                    _this.longitude = place.geometry.location.lng();
                    _this.zoom = 12;
                });
            });
        });
    };
    RegistrationComponent.prototype.setCurrentPosition = function () {
        var _this = this;
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                _this.latitude = position.coords.latitude;
                _this.longitude = position.coords.longitude;
                _this.zoom = 12;
            });
        }
    };
    RegistrationComponent.prototype.checkPhone = function (e) {
        if (e.key.length == 1 && (e.key.toLowerCase() < '0' || e.key.toLowerCase() > '9')) {
            return false;
        }
        if (this.customer.telephone && e.key.length == 1 && this.customer.telephone.toString().length == 8) {
            return false;
        }
    };
    RegistrationComponent.prototype.attachSurvey = function (reg) {
        var survey = JSON.parse(localStorage.getItem('survey'));
        if (!survey) {
            this.router.navigate(['/survey']);
            return;
        }
        reg['ageGroup'] = survey.ageGroup;
        reg['hearOthers'] = survey.hearFrom.other;
        reg['reasonOthers'] = survey.reason.other;
        survey.hearFrom.options.forEach(function (option) {
            reg[option] = true;
        });
        survey.hearFrom.blanks.forEach(function (option) {
            reg[option] = false;
        });
        survey.reason.options.forEach(function (option) {
            reg[option] = true;
        });
        survey.reason.blanks.forEach(function (option) {
            reg[option] = false;
        });
    };
    __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewChild"])("search"),
        __metadata("design:type", _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"])
    ], RegistrationComponent.prototype, "searchElementRef", void 0);
    RegistrationComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'app-registration',
            template: __webpack_require__(/*! ./registration.component.html */ "./src/app/components/registration/registration.component.html"),
            styles: [__webpack_require__(/*! ./registration.component.scss */ "./src/app/components/registration/registration.component.scss")]
        }),
        __metadata("design:paramtypes", [_service_product_service__WEBPACK_IMPORTED_MODULE_1__["ProductService"],
            _service_organisation_service__WEBPACK_IMPORTED_MODULE_4__["OrganisationService"],
            _service_customer_service__WEBPACK_IMPORTED_MODULE_5__["CustomerService"],
            _service_registration_service__WEBPACK_IMPORTED_MODULE_7__["RegistrationService"],
            _service_newsletter_subscription_service__WEBPACK_IMPORTED_MODULE_11__["NewsletterSubscriptionService"],
            _angular_router__WEBPACK_IMPORTED_MODULE_3__["Router"],
            _agm_core__WEBPACK_IMPORTED_MODULE_9__["MapsAPILoader"],
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"],
            ng2_completer__WEBPACK_IMPORTED_MODULE_10__["CompleterService"]])
    ], RegistrationComponent);
    return RegistrationComponent;
}());



/***/ }),

/***/ "./src/app/components/send-email/send-email.component.html":
/*!*****************************************************************!*\
  !*** ./src/app/components/send-email/send-email.component.html ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"send-email-wrap\">\n    <div\n    *ngIf=\"!isLoading\"\n    class=\"text-center\">\n        <h3>Almost There! Just One More Step:)</h3>\n        <div\n        *ngIf=\"dataCustomer.email && dataCustomer.email != ''\"\n        class=\"email-note\">\n            <p>An email has been sent to <a href=\"mailto:{{dataCustomer.email}}\">{{dataCustomer.email}}</a> </p>\n            <p>Please check your email to verify your email address and receive the Registration Confirmation.</p>\n        </div>\n        <div\n        *ngIf=\"dataVerify != '' \"\n        class=\"note alert alert-success\">\n            {{dataVerify}}\n        </div>\n        <div\n        *ngIf=\"verifyFail\"\n        class=\"note alert alert-danger\">\n            Error! Pls contact admin to help via <a href=\"mailto: peter@magenta-wellness.com\">peter@magenta-wellness.com</a>.\n        </div>\n        <p\n        *ngIf=\"!isClick\"\n        class=\"note\">If you have waited for over 30 seconds and have not received an email. Please check your spam or junk mailbox. If it’s still not in there, click <a href=\"javascript:;\" (click)=\"resendEmail($event)\">Resend </a></p>\n        <div class=\"text-center cancel-wrap\">\n            <button (click)=\"openModal(modalRemoveRegId)\" type=\"button\" class=\"btn btn-secondary\">Cancel</button>\n        </div>\n        <ng-template #modalRemoveRegId>\n            <div class=\"modal-body text-center\">\n                <p>Do you really want to redirect to page registration ?</p>\n                <div class=\"cancel-wrap\">\n                    <button (click)=\"clearRegistration()\" type=\"button\" class=\"btn btn-primary\">YES</button>\n                    <button (click)=\"modalRef.hide()\" type=\"button\" class=\"btn btn-secondary btn-cancel\">NO</button>\n                </div>\n            </div>\n        </ng-template>\n    </div>\n    <!-- Loading -->\n    <div\n    *ngIf=\"isLoading\"\n    class=\"text-center\">\n        <div class=\"lds-hourglass\"></div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/components/send-email/send-email.component.scss":
/*!*****************************************************************!*\
  !*** ./src/app/components/send-email/send-email.component.scss ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".email-note {\n  width: 400px;\n  margin: 0 auto;\n  border: 1px solid #ddd;\n  background-color: #eee;\n  border-radius: 5px;\n  padding: 20px;\n  margin-bottom: 30px;\n  text-align: left; }\n  .email-note p {\n    margin-bottom: 0; }\n  .send-email-wrap .note {\n  width: 500px;\n  margin: 0 auto; }\n  .send-email-wrap h3 {\n  margin-bottom: 30px; }\n"

/***/ }),

/***/ "./src/app/components/send-email/send-email.component.ts":
/*!***************************************************************!*\
  !*** ./src/app/components/send-email/send-email.component.ts ***!
  \***************************************************************/
/*! exports provided: SendEmailComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SendEmailComponent", function() { return SendEmailComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
/* harmony import */ var _service_product_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../service/product.service */ "./src/app/service/product.service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var SendEmailComponent = /** @class */ (function () {
    function SendEmailComponent(productService, router, modalService) {
        this.productService = productService;
        this.router = router;
        this.modalService = modalService;
        this.isLoading = false;
        this.dataCustomer = [];
        this.dataVerify = '';
        this.verifyFail = false;
        this.isClick = false;
    }
    SendEmailComponent.prototype.ngOnInit = function () {
        // 1.
        this.getDataCustomer();
    };
    SendEmailComponent.prototype.ngAfterViewInit = function () {
    };
    /* =========================================== */
    /** Actions in this Comp */
    // 1. Get Data Customer
    SendEmailComponent.prototype.getDataCustomer = function () {
        var _this = this;
        // let regId = this.router.snapshot.params['id'];
        this.isLoading = true;
        if (localStorage.getItem('regId')) {
            var regId = parseInt(localStorage.getItem('regId'));
            this.productService.getApiCustomer(regId).subscribe(function (res) {
                _this.isLoading = false;
                _this.dataCustomer = res;
            });
        }
        else {
            this.dataCustomer = [];
            this.isLoading = false;
        }
    };
    // 2. Resend Email
    SendEmailComponent.prototype.resendEmail = function (event) {
        var _this = this;
        if (localStorage.getItem('regId')) {
            var regId = parseInt(localStorage.getItem('regId'));
            var params = {
                "registrationId": regId,
                "type": "verification"
            };
            this.productService.postVerifyEmail(params)
                .subscribe(function (res) {
                if (res) {
                    var resVerify = res;
                    _this.dataVerify = resVerify.message;
                    // hide button click
                    _this.isClick = true;
                }
            }, function (error) {
                // var details = error.json();
                console.log(error);
                _this.verifyFail = true;
                // hide button click
                _this.isClick = true;
            }, function () { return console.log("Finished"); });
        }
        else {
            // this.dataCustomer = [];
            // this.isLoading = false;
        }
    };
    // clear localStorage and then redirect to page registration
    SendEmailComponent.prototype.clearRegistration = function () {
        this.modalRef.hide();
        localStorage.removeItem('regId');
        this.router.navigate(['/registration']);
    };
    SendEmailComponent.prototype.openModal = function (template) {
        this.modalRef = this.modalService.show(template);
    };
    SendEmailComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'send-email',
            template: __webpack_require__(/*! ./send-email.component.html */ "./src/app/components/send-email/send-email.component.html"),
            styles: [__webpack_require__(/*! ./send-email.component.scss */ "./src/app/components/send-email/send-email.component.scss")]
        }),
        __metadata("design:paramtypes", [_service_product_service__WEBPACK_IMPORTED_MODULE_3__["ProductService"],
            _angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"],
            ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_2__["BsModalService"]])
    ], SendEmailComponent);
    return SendEmailComponent;
}());



/***/ }),

/***/ "./src/app/components/success/success.component.html":
/*!***********************************************************!*\
  !*** ./src/app/components/success/success.component.html ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"success-wrap\">\n    <div class=\"text-center\">\n        <h3>SUCCESSFULLY SUBMITTED</h3>\n        <p class=\"note\">If you have specified an email address earlier. A copy of this product registration will be sent to your email for your reference.</p>\n        <div class=\"success-list\"\n        *ngIf=\"!isLoading\">\n            <div *ngIf=\"prodList.length > 0\">\n                <div\n                *ngFor=\"let warranty of prodList; index as i;\"\n                class=\"success-item\">\n                    <p>Warranty Registration ID: {{warranty.number}}</p>\n                    <p>Date of Registration: {{warranty.purchaseDate | date:'dd MMM yyyy'}}</p>\n                    <p>Warranty Expiry: {{warranty.expiryDate | date:'dd MMM yyyy'}}</p>\n                    <p>Product Category: {{warranty.product.category.name}}</p>\n                    <p>Model Name: {{warranty.product.name}}</p>\n                    <p>Serial Number: {{warranty.productSerialNumber}}</p>\n                </div>\n                <div>\n                    All hoods have a default motor warranty period of 3 years.\n                </div>\n            </div>\n            <div\n            *ngIf=\"prodList.length == 0\"\n            class=\"success-item\">\n                No data\n            </div>\n\n            <div class=\"text-center cancel-wrap\">\n                <button (click)=\"openModal(modalRemoveRegId)\" type=\"button\" class=\"btn btn-primary\">Register a new Product </button>\n            </div>\n            <ng-template #modalRemoveRegId>\n                <div class=\"modal-body text-center\">\n                    <p>Do you really want to redirect to page registration ?</p>\n                    <div class=\"cancel-wrap\">\n                        <button (click)=\"clearRegistration()\" type=\"button\" class=\"btn btn-primary\">YES</button>\n                        <button (click)=\"modalRef.hide()\" type=\"button\" class=\"btn btn-secondary btn-cancel\">NO</button>\n                    </div>\n                </div>\n            </ng-template>\n        </div>\n        <!-- Loading -->\n        <div\n        *ngIf=\"isLoading\"\n        class=\"text-center\">\n            <div class=\"lds-hourglass\"></div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/components/success/success.component.scss":
/*!***********************************************************!*\
  !*** ./src/app/components/success/success.component.scss ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".success-list .success-item {\n  width: 400px;\n  margin: 0 auto;\n  margin-bottom: 30px;\n  border: 1px solid #ddd;\n  border-radius: 5px;\n  padding: 10px; }\n  .success-list .success-item p {\n    margin-bottom: 0; }\n  .success-wrap h3 {\n  margin-bottom: 20px; }\n  .success-wrap .note {\n  width: 400px;\n  margin: 0 auto;\n  margin-bottom: 15px; }\n"

/***/ }),

/***/ "./src/app/components/success/success.component.ts":
/*!*********************************************************!*\
  !*** ./src/app/components/success/success.component.ts ***!
  \*********************************************************/
/*! exports provided: SuccessComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SuccessComponent", function() { return SuccessComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
/* harmony import */ var _service_product_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../service/product.service */ "./src/app/service/product.service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var SuccessComponent = /** @class */ (function () {
    function SuccessComponent(route, productService, router, modalService) {
        this.route = route;
        this.productService = productService;
        this.router = router;
        this.modalService = modalService;
        this.prodList = [];
        this.isLoading = false;
        this.dataVerify = '';
        this.verifyFail = false;
        this.isClick = false;
    }
    SuccessComponent.prototype.ngOnInit = function () {
        var regId = this.route.snapshot.params['id'];
        localStorage.setItem('regId', regId);
        // 1.
        this.getDataWarranties();
    };
    SuccessComponent.prototype.ngAfterViewInit = function () {
        this.sendEmail();
    };
    /* =========================================== */
    /** Actions in this Comp */
    // 1. Get Data Warranties
    SuccessComponent.prototype.getDataWarranties = function () {
        var _this = this;
        this.isLoading = true;
        if (localStorage.getItem('regId')) {
            var regId = localStorage.getItem('regId');
            if (Number.isNaN(parseInt(regId))) {
                var cutstr = '/api/registrations/';
                console.log('regId', regId, cutstr.length);
                regId = parseInt(regId.substring(cutstr.length));
            }
            else {
                regId = parseInt(regId);
            }
            this.productService.getApiWarranties(regId).subscribe(function (prods) {
                _this.isLoading = false;
                _this.prodList = prods;
            });
        }
        else {
            this.prodList = [];
            this.isLoading = false;
        }
    };
    // 2. send Email
    SuccessComponent.prototype.sendEmail = function () {
        var _this = this;
        if (localStorage.getItem('regId')) {
            var regId = parseInt(localStorage.getItem('regId'));
            var params = {
                "registrationId": regId,
                "type": "confirmation"
            };
            this.productService.postVerifyEmail(params)
                .subscribe(function (res) {
                if (res) {
                    var resVerify = res;
                    _this.dataVerify = resVerify.message;
                    // hide button click
                    _this.isClick = true;
                }
            }, function (error) {
                // var details = error.json();
                console.log(error);
                _this.verifyFail = true;
                // hide button click
                _this.isClick = true;
            }, function () { return console.log("Finished"); });
        }
        else {
            // this.dataCustomer = [];
            // this.isLoading = false;
        }
    };
    // clear localStorage and then redirect to page registration
    SuccessComponent.prototype.clearRegistration = function () {
        this.modalRef.hide();
        localStorage.removeItem('regId');
        this.router.navigate(['/registration']);
    };
    SuccessComponent.prototype.openModal = function (template) {
        this.modalRef = this.modalService.show(template);
    };
    SuccessComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'success',
            template: __webpack_require__(/*! ./success.component.html */ "./src/app/components/success/success.component.html"),
            styles: [__webpack_require__(/*! ./success.component.scss */ "./src/app/components/success/success.component.scss")]
        }),
        __metadata("design:paramtypes", [_angular_router__WEBPACK_IMPORTED_MODULE_1__["ActivatedRoute"], _service_product_service__WEBPACK_IMPORTED_MODULE_3__["ProductService"],
            _angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"],
            ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_2__["BsModalService"]])
    ], SuccessComponent);
    return SuccessComponent;
}());



/***/ }),

/***/ "./src/app/components/survey/survey.component.html":
/*!*********************************************************!*\
  !*** ./src/app/components/survey/survey.component.html ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div>\n  <p>Age Group *</p>\n  <ul class=\"option-group\">\n    <li *ngFor=\"let option of survey.ageGroup\">\n      <label><input name=\"ageGroup\" type=\"radio\" value=\"{{option.value}}\" [(ngModel)]=\"survey.selectedAgeGroup\"> {{option.name}}</label>\n    </li>\n  </ul>\n  <p>How did you know FUJIOH? (Multiple answers allowed) *</p>\n  <ul class=\"option-group\">\n    <li *ngFor=\"let option of survey.hearFrom\">\n      <span>\n        <label><input name=\"hearFrom\" type=\"checkbox\" value=\"{{option.value}}\" [(ngModel)]=\"option.selected\"> {{option.name}}</label>\n      </span>\n    </li>\n    <li>\n      <span>\n        <label><input type=\"hearFrom\" type=\"checkbox\" value=\"other\" [(ngModel)]=\"survey.otherHearFrom.selected\"> Others (Enter comment)<br></label>\n        <div>Others (Please write comment if others is selected)</div>\n        <input type=\"text\" [(ngModel)]=\"survey.otherHearFrom.name\">\n      </span>\n    </li>\n  </ul>\n  <p>Why did you choose FUJIOH product? (Multiple answers allowed) *</p>\n  <ul class=\"option-group\">\n    <li *ngFor=\"let option of survey.reason\">\n      <span>\n        <label><input name=\"reason\" type=\"checkbox\" value=\"{{option.value}}\" [(ngModel)]=\"option.selected\"> {{option.name}}</label>\n      </span>\n    </li>\n    <li>\n      <span>\n        <label><input type=\"reason\" type=\"checkbox\" value=\"other\" [(ngModel)]=\"survey.otherReason.selected\"> Others (Enter comment)<br></label>\n        <div>Others (Please write comment if others is selected)</div>\n        <input type=\"text\" [(ngModel)]=\"survey.otherReason.name\">\n      </span>\n    </li>\n  </ul>\n  <div *ngIf=\"!survey.getResult()\" style=\"color: red\">{{message}}</div>\n  <button class=\"btn btn-success\" (click)=\"submit()\">Next</button>\n</div>"

/***/ }),

/***/ "./src/app/components/survey/survey.component.scss":
/*!*********************************************************!*\
  !*** ./src/app/components/survey/survey.component.scss ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".option-group {\n  list-style-type: none;\n  padding: 0px; }\n"

/***/ }),

/***/ "./src/app/components/survey/survey.component.ts":
/*!*******************************************************!*\
  !*** ./src/app/components/survey/survey.component.ts ***!
  \*******************************************************/
/*! exports provided: SurveyComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SurveyComponent", function() { return SurveyComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _model_survey__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../model/survey */ "./src/app/model/survey.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};



var SurveyComponent = /** @class */ (function () {
    function SurveyComponent(router) {
        this.router = router;
        this.survey = new _model_survey__WEBPACK_IMPORTED_MODULE_2__["Survey"]();
    }
    SurveyComponent.prototype.ngOnInit = function () {
        this.buildOptions();
    };
    SurveyComponent.prototype.submit = function () {
        var res = this.survey.getResult();
        if (!res) {
            this.message = "Please fill out required field";
        }
        else {
            // fetch some api
            localStorage.setItem('survey', JSON.stringify(this.survey.getResult()));
            this.router.navigate(['registration']);
        }
    };
    SurveyComponent.prototype.buildOptions = function () {
        this.survey.ageGroup = [
            {
                name: '19 and below',
                value: '19-and-below',
                selected: false
            },
            {
                name: '20-29',
                value: '20-29',
                selected: false
            },
            {
                name: '30-39',
                value: '30-39',
                selected: false
            },
            {
                name: '40-49',
                value: '40-49',
                selected: false
            },
            {
                name: '50-59',
                value: '50-59',
                selected: false
            },
            {
                name: '60 and above',
                value: '60-and-above',
                selected: false
            }
        ];
        this.survey.hearFrom = [
            {
                name: 'Online search',
                value: 'hearFromOnlineSearch',
                selected: false
            },
            {
                name: 'Online advertisement (Facebook/Instagram/etc.)',
                value: 'hearFromOnlineAd',
                selected: false
            },
            {
                name: 'Introduced by friend/family',
                value: 'hearFromFriendFamily',
                selected: false
            },
            {
                name: 'Introduced by interior designer',
                value: 'reasonInteriorDesigner',
                selected: false
            },
            {
                name: 'Walk in to the shop',
                value: 'hearWalkShop',
                selected: false
            }
        ];
        this.survey.reason = [
            {
                name: 'Because there were promotions going on',
                value: 'reasonPromotions',
                selected: false
            },
            {
                name: 'Because I liked the brand',
                value: 'reasonTheBrand',
                selected: false
            },
            {
                name: 'Because I liked the technology (Suction/Easy cleaning/etc.)',
                value: 'reasonTechnology',
                selected: false
            },
            {
                name: 'Because I liked the Japanese quality',
                value: 'reasonJapanese',
                selected: false
            },
            {
                name: 'Because I liked the design',
                value: 'reasonTheDesign',
                selected: false
            },
            {
                name: 'Because price was affordable',
                value: 'reasonAffordable',
                selected: false
            },
            {
                name: 'Because my interior designer suggested to me',
                value: 'reasonDesignerSuggested',
                selected: false
            },
            {
                name: 'Because my friend/family suggested to me',
                value: 'reasonFriendFamilySuggested',
                selected: false
            }
        ];
    };
    SurveyComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'app-survey',
            template: __webpack_require__(/*! ./survey.component.html */ "./src/app/components/survey/survey.component.html"),
            styles: [__webpack_require__(/*! ./survey.component.scss */ "./src/app/components/survey/survey.component.scss")]
        }),
        __metadata("design:paramtypes", [_angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"]])
    ], SurveyComponent);
    return SurveyComponent;
}());



/***/ }),

/***/ "./src/app/components/uploads/uploads.component.html":
/*!***********************************************************!*\
  !*** ./src/app/components/uploads/uploads.component.html ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n    <div class=\"col-md-10 offset-md-1 blk-upload\">\n        <div\n                *ngIf=\"!isLoading\"\n                class=\" text-center\">\n            <h3>Upload Receipt</h3>\n            <div class=\"row\">\n                <div class=\"col-md-6 col-sm-6 col-xs-12 col-left\">\n                    <div\n                            *ngIf=\"qrCodeImg != ''\"\n                            class=\"upload-inner\">\n                        <h5>Scan this QR Code to open this page on your phone</h5>\n                        <img src={{qrCodeImg}} alt=\"\"/>\n                    </div>\n                </div>\n                <div class=\"col-md-6 col-sm-6 col-12 col-right\">\n                    <div class=\"upload-inner \">\n                        <h5> Use this form to upload/ capture pictures from your device </h5>\n                        <div class=\"upload-lst\"\n                             *ngIf=\"prodList.length != 0\">\n                            <div\n                                    *ngFor=\"let prod of prodList; index as i;\"\n                                    class=\"upload-itm\">\n                                <div class=\"inner\">\n                                    <p>Product Category: {{prod.product.name}}</p>\n                                    <p>Model Name: {{prod.product.modelNumber}}</p>\n                                    <p>Serial Number: {{prod.productSerialNumber}}</p>\n                                </div>\n\n                                <!--<button type=\"button\" class=\"btn btn-warning form-control\">Upload/Take a Picture Now</button>-->\n\n                                <!--<image-upload-->\n                                <!--class=\"custome-upload warning d-block d-sm-none\"-->\n                                <!--url=\"prod.uploadUrl\"-->\n                                <!--partName=\"binaryContent\"-->\n                                <!--[beforeUpload]=\"onBeforeUpload\"-->\n                                <!--(removed)=\"onRemoved($event)\"-->\n                                <!--(uploadFinished)=\"onUploadFinished($event, prod.id)\"-->\n                                <!--(uploadStateChanged)=\"onUploadStateChanged($event)\"-->\n                                <!--buttonCaption=\"Take a Picture Now\"></image-upload>-->\n\n                                <image-upload\n                                        class=\"custome-upload\"\n                                        [url]=prod.uploadUrl\n                                        partName=\"binaryContent\"\n                                        [uploadedFiles]=\"prod.imageUrl\"\n                                        [beforeUpload]=\"onBeforeUpload\"\n                                        (removed)=\"onRemoved($event)\"\n                                        (uploadFinished)=\"onUploadFinished($event)\"\n                                        (uploadStateChanged)=\"onUploadStateChanged($event)\"\n                                        buttonCaption=\"Upload a Picture Now\"></image-upload>\n                            </div>\n                        </div>\n\n                        <div class=\"upload-lst\"\n                             *ngIf=\"prodList.length == 0\">\n                            <h5>No data</h5>\n                        </div>\n                    </div>\n                </div>\n            </div>\n            <div class=\"row\">\n                <div class=\"col-12\">\n                    <button (click)=\"submitRegistration()\" type=\"button\" class=\"btn btn-primary\">\n                        Submit\n                    </button>\n\n                    <button (click)=\"openModal(modalRemoveRegId)\" type=\"button\" class=\"btn btn-secondary btn-cancel\">Cancel</button>\n                </div>\n\n                <ng-template #modalRemoveRegId>\n                    <div class=\"modal-body text-center\">\n                        <p>Do you really want to redirect to page registration ?</p>\n                        <div class=\"cancel-wrap\">\n                            <button (click)=\"clearRegistration()\" type=\"button\" class=\"btn btn-primary\">YES</button>\n                            <button (click)=\"modalRef.hide()\" type=\"button\" class=\"btn btn-secondary btn-cancel\">NO</button>\n                        </div>\n                    </div>\n                </ng-template>\n            </div>\n        </div>\n\n        <!-- Loading -->\n        <div\n                *ngIf=\"isLoading\"\n                class=\"text-center\">\n            <div class=\"lds-hourglass\"></div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/components/uploads/uploads.component.scss":
/*!***********************************************************!*\
  !*** ./src/app/components/uploads/uploads.component.scss ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".blk-upload .col-right .upload-inner {\n  width: 80%;\n  margin: 0 auto; }\n\n.blk-upload .col-left {\n  min-height: 349px;\n  position: relative; }\n\n.blk-upload .col-left h5 {\n    width: 70%;\n    margin: 0 auto; }\n\n.blk-upload .col-left .upload-inner {\n    position: relative; }\n\n.blk-upload .col-left .upload-inner::before {\n      content: \"\";\n      display: block;\n      width: 1px;\n      position: absolute;\n      right: 0;\n      top: 0;\n      bottom: 0;\n      height: 100%;\n      background-color: #ddd; }\n\n.blk-upload .col-left .upload-inner::after {\n      content: \"OR\";\n      display: block;\n      width: 30px;\n      height: 30px;\n      line-height: 30px;\n      font-size: 13px;\n      font-weight: bold;\n      position: absolute;\n      right: -15px;\n      top: 50%;\n      -webkit-transform: translateY(-50%);\n              transform: translateY(-50%);\n      background-color: #fff;\n      border-radius: 50%;\n      color: #000;\n      z-index: 2; }\n\n.blk-upload {\n  position: relative; }\n\n.blk-upload h3 {\n    margin-bottom: 20px; }\n\n.blk-upload h5 {\n    margin-bottom: 10px; }\n\n.blk-upload img {\n    width: 180px;\n    display: block;\n    margin: 0 auto; }\n\n.blk-upload .upload-itm {\n    margin-bottom: 10px;\n    padding-bottom: 15px;\n    border-bottom: 1px dashed #ddd; }\n\n.blk-upload .upload-itm:last-child {\n      border-bottom: none; }\n\n.blk-upload .upload-itm p {\n      margin-bottom: 5px; }\n"

/***/ }),

/***/ "./src/app/components/uploads/uploads.component.ts":
/*!*********************************************************!*\
  !*** ./src/app/components/uploads/uploads.component.ts ***!
  \*********************************************************/
/*! exports provided: UploadsComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UploadsComponent", function() { return UploadsComponent; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ngx-bootstrap/modal */ "./node_modules/ngx-bootstrap/modal/index.js");
/* harmony import */ var _service_product_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../service/product.service */ "./src/app/service/product.service.ts");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var _helper_helper__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../helper/helper */ "./src/app/helper/helper.ts");
/* harmony import */ var _service_registration_service__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../service/registration.service */ "./src/app/service/registration.service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};







var UploadsComponent = /** @class */ (function () {
    function UploadsComponent(route, router, productService, helper, regService, modalService) {
        this.route = route;
        this.router = router;
        this.productService = productService;
        this.helper = helper;
        this.regService = regService;
        this.modalService = modalService;
        this.prodList = [];
        this.isLoading = false;
        this.qrCodeImg = '';
        // 2. Event uploads
        this.onBeforeUpload = function (metadata) {
            // mutate the file or replace it entirely - metadata.file
            // console.log('metadata.url', metadata.url);
            var apiUploadWarranty = _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointMedia"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiMediaUploadPath"];
            var warId = metadata.url.substring(apiUploadWarranty.length + 1);
            metadata.formData = {
                "receiptImageWarranty": warId,
                "context": "receipt_image"
            };
            // console.log('warid is',warId);
            metadata.url = apiUploadWarranty;
            return metadata;
        };
    }
    UploadsComponent.prototype.ngOnInit = function () {
        // 1.
        this.getDataWarranties();
        this.qrCodeImg = _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + '/qr-code/' + location.protocol + '//' + window.location.hostname + '/upload-receipt-image/' + this.route.snapshot.params['id'] + '.png';
    };
    UploadsComponent.prototype.ngAfterViewInit = function () {
    };
    /* =========================================== */
    /** Actions in this Comp */
    UploadsComponent.prototype.submitRegistration = function () {
        var _this = this;
        console.log('submitting');
        var regId = this.route.snapshot.params['id'];
        this.regService.submitRegistration(regId).subscribe(function (res) {
            _this.isLoading = false;
            var c = res.customer;
            var email = c.email;
            if (typeof email !== 'undefined' && email !== null && email !== '') {
                if (!res.verified) {
                    _this.router.navigate(['/send-email/' + regId]);
                }
            }
            _this.router.navigate(['/success/' + regId]);
        }, function (error) {
            console.log('Error', error);
        }, function () {
            console.log('Complete Request');
        });
    };
    // 1. Get Data Warranties
    UploadsComponent.prototype.getDataWarranties = function () {
        var _this = this;
        var regId = this.route.snapshot.params['id'];
        if (!localStorage.getItem('regId')) {
            localStorage.setItem('regId', regId);
        }
        this.isLoading = true;
        // localStorage.setItem('regId', apiEndPointBase + '/registrations/' + regId);
        // let regId = parseInt(localStorage.getItem('regId'));
        var apiUploadWarranty = _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointMedia"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiMediaUploadPath"];
        this.productService.getApiWarranties(regId).subscribe(function (res) {
            _this.isLoading = false;
            _this.prodList = res;
            for (var _i = 0, _a = _this.prodList; _i < _a.length; _i++) {
                var prod = _a[_i];
                prod.uploadUrl = apiUploadWarranty + '/' + prod.id;
                // create array images
                prod.imageUrl = [];
                for (var _b = 0, _c = prod.receiptImages; _b < _c.length; _b++) {
                    var prodImg = _c[_b];
                    prod.imageUrl.push(_environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointMedia"] + '/media/' + prodImg.id + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["binariesMedia"]);
                }
            }
        }, function (error) {
            console.log('Error', error);
            _this.prodList = [];
            _this.isLoading = false;
        }, function () {
            console.log('Complete Request');
        });
    };
    UploadsComponent.prototype.onUploadFinished = function (file) {
        console.log('finished', file);
        // 1.
        // this.getDataWarranties();
    };
    UploadsComponent.prototype.onRemoved = function (file) {
        var splitUrlMedia = this.helper.explode('/media/', file.src, undefined);
        var imgId = this.helper.explode(_environments_environment__WEBPACK_IMPORTED_MODULE_4__["binariesMedia"], splitUrlMedia[1], undefined);
        var v_confirm = false;
        // check android or ios
        if (navigator.userAgent.toLowerCase().indexOf("android") > -1
            || navigator.userAgent.toLowerCase().indexOf("ios") > -1) {
            v_confirm = true;
        }
        else {
            // not android
            v_confirm = confirm('Do you really want to remove this image ?');
            // console.log('removed', file);
        }
        // After Asking.
        if (v_confirm == true) {
            this.productService.deleteWarrantyImg(parseInt(imgId[0])).subscribe(function (res) {
                console.log('res', res);
            }, function (error) {
                console.log('Error', error);
            }, function () {
                console.log('Complete Request');
            });
        }
    };
    UploadsComponent.prototype.onUploadStateChanged = function (state) {
        console.log('state', state);
    };
    // clear localStorage and then redirect to page registration
    UploadsComponent.prototype.clearRegistration = function () {
        this.modalRef.hide();
        localStorage.removeItem('regId');
        this.router.navigate(['/registration']);
    };
    UploadsComponent.prototype.openModal = function (template) {
        this.modalRef = this.modalService.show(template);
    };
    UploadsComponent = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Component"])({
            selector: 'uploads',
            template: __webpack_require__(/*! ./uploads.component.html */ "./src/app/components/uploads/uploads.component.html"),
            styles: [__webpack_require__(/*! ./uploads.component.scss */ "./src/app/components/uploads/uploads.component.scss")]
        }),
        __metadata("design:paramtypes", [_angular_router__WEBPACK_IMPORTED_MODULE_1__["ActivatedRoute"],
            _angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"],
            _service_product_service__WEBPACK_IMPORTED_MODULE_3__["ProductService"],
            _helper_helper__WEBPACK_IMPORTED_MODULE_5__["Helper"],
            _service_registration_service__WEBPACK_IMPORTED_MODULE_6__["RegistrationService"],
            ngx_bootstrap_modal__WEBPACK_IMPORTED_MODULE_2__["BsModalService"]])
    ], UploadsComponent);
    return UploadsComponent;
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

/***/ "./src/app/model/registration.ts":
/*!***************************************!*\
  !*** ./src/app/model/registration.ts ***!
  \***************************************/
/*! exports provided: Registration */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Registration", function() { return Registration; });
var Registration = /** @class */ (function () {
    function Registration() {
        this.submitted = false;
    }
    return Registration;
}());



/***/ }),

/***/ "./src/app/model/survey.ts":
/*!*********************************!*\
  !*** ./src/app/model/survey.ts ***!
  \*********************************/
/*! exports provided: Survey, Option */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Survey", function() { return Survey; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Option", function() { return Option; });
var HearFrom = /** @class */ (function () {
    function HearFrom() {
    }
    return HearFrom;
}());
var Survey = /** @class */ (function () {
    function Survey() {
        this.otherHearFrom = {
            name: '',
            value: 'other',
            selected: false
        };
        this.otherReason = {
            name: '',
            value: 'other',
            selected: false
        };
    }
    Survey.prototype.getResult = function () {
        var res = {
            ageGroup: this.selectedAgeGroup,
            hearFrom: {
                options: this.hearFrom ? this.hearFrom.filter(function (o) { return o.selected; }).map(function (o) { return o.value; }) : null,
                blanks: this.hearFrom ? this.hearFrom.filter(function (o) { return !o.selected; }).map(function (o) { return o.value; }) : null,
                other: this.otherHearFrom.selected ? this.otherHearFrom.name : ''
            },
            reason: {
                options: this.reason ? this.reason.filter(function (o) { return o.selected; }).map(function (o) { return o.value; }) : null,
                blanks: this.reason ? this.reason.filter(function (o) { return !o.selected; }).map(function (o) { return o.value; }) : null,
                other: this.otherReason.selected ? this.otherReason.name : ''
            }
        };
        if (!res.ageGroup) {
            return false;
        }
        if (!res.hearFrom.other && res.hearFrom.options.length == 0) {
            return false;
        }
        if (!res.reason.other && res.reason.options.length == 0) {
            return false;
        }
        return res;
    };
    return Survey;
}());

var Option = /** @class */ (function () {
    function Option() {
    }
    return Option;
}());



/***/ }),

/***/ "./src/app/model/warranty.ts":
/*!***********************************!*\
  !*** ./src/app/model/warranty.ts ***!
  \***********************************/
/*! exports provided: Warranty */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Warranty", function() { return Warranty; });
var Warranty = /** @class */ (function () {
    function Warranty() {
        this.isCategoryHidden = true;
        this.isProductHidden = true;
        this.selectedBrand = null;
        this.selectedCategory = null;
        this.selectedProduct = null;
        this.selectedDealer = null;
        this.brands = [
            { id: null, name: 'Loading' }
        ];
        this.categories = [
            { id: null, name: 'Loading' }
        ];
        this.subCategories = [
            { id: null, name: 'Loading' }
        ];
        this.products = [
            { id: null, name: 'Loading' }
        ];
        this.dealers = [
            { id: null, name: 'Loading' }
        ];
    }
    return Warranty;
}());



/***/ }),

/***/ "./src/app/service/auth-guard.service.ts":
/*!***********************************************!*\
  !*** ./src/app/service/auth-guard.service.ts ***!
  \***********************************************/
/*! exports provided: AuthGuard */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "AuthGuard", function() { return AuthGuard; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _product_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./product.service */ "./src/app/service/product.service.ts");
/* harmony import */ var _registration_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./registration.service */ "./src/app/service/registration.service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var AuthGuard = /** @class */ (function () {
    function AuthGuard(router, productService, registrationService) {
        this.router = router;
        this.productService = productService;
        this.registrationService = registrationService;
        this.dataRegistration = "";
    }
    AuthGuard.prototype.canActivate = function () {
        if (localStorage.getItem('regId')) {
            this.getDataRegistration();
            return false;
        }
        else if (localStorage.getItem('survey')) {
            this.router.navigate(['registration']);
            return false;
        }
        return true;
    };
    /* =========================================== */
    /** Actions in this Comp */
    // 1. Get Data Registration
    AuthGuard.prototype.getDataRegistration = function () {
        var _this = this;
        if (localStorage.getItem('regId')) {
            var regId_1 = localStorage.getItem('regId');
            if (Number.isNaN(parseInt(regId_1))) {
                var cutstr = '/api/registrations/';
                regId_1 = regId_1.substring(cutstr.length);
            }
            this.registrationService.getRegistration(regId_1).subscribe(function (res) {
                if (res.submitted === false) {
                    _this.router.navigate(['upload-receipt-image/', parseInt(regId_1)]);
                }
                else {
                    // check email exists
                    if (res.customer !== undefined && res && res.customer.email && !res.verified) {
                        _this.router.navigate(['send-email/', parseInt(regId_1)]);
                    }
                    else {
                        _this.router.navigate(['success/', parseInt(regId_1)]);
                    }
                }
            });
        }
    };
    AuthGuard = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])(),
        __metadata("design:paramtypes", [_angular_router__WEBPACK_IMPORTED_MODULE_1__["Router"],
            _product_service__WEBPACK_IMPORTED_MODULE_2__["ProductService"],
            _registration_service__WEBPACK_IMPORTED_MODULE_3__["RegistrationService"]])
    ], AuthGuard);
    return AuthGuard;
}());



/***/ }),

/***/ "./src/app/service/customer.service.ts":
/*!*********************************************!*\
  !*** ./src/app/service/customer.service.ts ***!
  \*********************************************/
/*! exports provided: CustomerService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CustomerService", function() { return CustomerService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
/* harmony import */ var rxjs__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
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
var CustomerService = /** @class */ (function () {
    function CustomerService(http) {
        this.http = http;
        this.customersUrl = '/customers';
    }
    CustomerService.prototype.postCustomer = function (customer) {
        delete customer.id;
        customer.homePostalCode = String(customer.homePostalCode);
        customer.telephone = String(customer.telephone);
        customer.organisation = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["organisationPath"] + "/" + localStorage.getItem('orgId');
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.customersUrl;
        return this.http.post(url, customer, httpOptions).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["catchError"])(this.handleError('postCustomer')));
    };
    /**
     * Handle Http operation that failed.
     * Let the app continue.
     * @param operation - name of the operation that failed
     * @param result - optional value to return as the observable result
     */
    CustomerService.prototype.handleError = function (operation, result) {
        if (operation === void 0) { operation = 'operation'; }
        return function (error) {
            // TODO: send the error to remote logging infrastructure
            console.error('error', error); // log to console instead
            // TODO: better job of transforming error for user consumption
            console.log(operation + " failed: " + error.message);
            // Let the app keep running by returning an empty result.
            return Object(rxjs__WEBPACK_IMPORTED_MODULE_3__["of"])(result);
        };
    };
    CustomerService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"]])
    ], CustomerService);
    return CustomerService;
}());



/***/ }),

/***/ "./src/app/service/newsletter-subscription.service.ts":
/*!************************************************************!*\
  !*** ./src/app/service/newsletter-subscription.service.ts ***!
  \************************************************************/
/*! exports provided: NewsletterSubscriptionService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "NewsletterSubscriptionService", function() { return NewsletterSubscriptionService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _node_modules_angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../node_modules/@angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _node_modules_rxjs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/rxjs */ "./node_modules/rxjs/_esm5/index.js");
/* harmony import */ var _environments_environment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../environments/environment */ "./src/environments/environment.ts");
/* harmony import */ var _node_modules_rxjs_operators__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../node_modules/rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
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
    headers: new _node_modules_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpHeaders"]({ 'Content-Type': 'application/ld+json' })
};
var NewsletterSubscriptionService = /** @class */ (function () {
    function NewsletterSubscriptionService(http) {
        this.http = http;
    }
    NewsletterSubscriptionService.prototype.postNewsletterSubscription = function (customer) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_3__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_3__["apiEndPointBase"] + "/newsletter-subscriptions";
        return this.http.post(url, {
            customer: customer,
            name: customer.name,
            email: customer.email
        }, httpOptions).pipe(Object(_node_modules_rxjs_operators__WEBPACK_IMPORTED_MODULE_4__["catchError"])(this.handleError('postNewsletterSubscription')));
    };
    /**
    * Handle Http operation that failed.
    * Let the app continue.
    * @param operation - name of the operation that failed
    * @param result - optional value to return as the observable result
    */
    NewsletterSubscriptionService.prototype.handleError = function (operation, result) {
        if (operation === void 0) { operation = 'operation'; }
        return function (error) {
            if (operation === 'getRegistration') {
                localStorage.removeItem('regId');
            }
            // TODO: send the error to remote logging infrastructure
            console.error('error', error); // log to console instead
            // TODO: better job of transforming error for user consumption
            console.log(operation + " failed: " + error.message);
            // Let the app keep running by returning an empty result.
            return Object(_node_modules_rxjs__WEBPACK_IMPORTED_MODULE_2__["of"])(result);
        };
    };
    NewsletterSubscriptionService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_node_modules_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"]])
    ], NewsletterSubscriptionService);
    return NewsletterSubscriptionService;
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
        // console.log('warId', warId);
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

/***/ "./src/app/service/registration.service.ts":
/*!*************************************************!*\
  !*** ./src/app/service/registration.service.ts ***!
  \*************************************************/
/*! exports provided: RegistrationService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RegistrationService", function() { return RegistrationService; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var rxjs_operators__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
/* harmony import */ var rxjs__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
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
var RegistrationService = /** @class */ (function () {
    function RegistrationService(http) {
        this.http = http;
        this.registrationsUrl = '/registrations';
    }
    RegistrationService.prototype.submitRegistration = function (regId) {
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.registrationsUrl + "/" + regId;
        return this.http.put(url, { 'submitted': true }, httpOptions).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["catchError"])(this.handleError('submitRegistration')));
    };
    RegistrationService.prototype.postRegistration = function (reg) {
        reg['ageGroup'] = "18-20";
        var url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.registrationsUrl;
        return this.http.post(url, reg, httpOptions).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["catchError"])(this.handleError('postRegistration')));
    };
    // get data Registration
    RegistrationService.prototype.getRegistration = function (id) {
        var url = null;
        if (Number.isNaN(parseInt(id))) {
            url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + id;
        }
        else {
            url = "" + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPoint"] + _environments_environment__WEBPACK_IMPORTED_MODULE_4__["apiEndPointBase"] + this.registrationsUrl + "/" + id;
        }
        return this.http.get(url).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["map"])(function (res) {
            var dataRegistration = res;
            console.log('dataRegistration', dataRegistration);
            return dataRegistration;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["catchError"])(this.handleError('getRegistration', [])));
    };
    /**
     * Handle Http operation that failed.
     * Let the app continue.
     * @param operation - name of the operation that failed
     * @param result - optional value to return as the observable result
     */
    RegistrationService.prototype.handleError = function (operation, result) {
        if (operation === void 0) { operation = 'operation'; }
        return function (error) {
            if (operation === 'getRegistration') {
                localStorage.removeItem('regId');
            }
            // TODO: send the error to remote logging infrastructure
            console.error('error', error); // log to console instead
            // TODO: better job of transforming error for user consumption
            console.log(operation + " failed: " + error.message);
            // Let the app keep running by returning an empty result.
            return Object(rxjs__WEBPACK_IMPORTED_MODULE_3__["of"])(result);
        };
    };
    RegistrationService = __decorate([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"])({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_1__["HttpClient"]])
    ], RegistrationService);
    return RegistrationService;
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
// export const apiEndPoint = 'http://swarranty.magenta-dev.com';
var apiEndPoint = 'http://dev-swarranty.magentapulse.com';
var apiEndPointBase = '/api';
var organisationPath = '/organisations';
var MEDIA_PREFIX = '/media';
// export const apiEndPointMedia   = 'http://swarranty.magenta-dev.com';
var apiEndPointMedia = 'http://dev-swarranty.magentapulse.com/media-api';
var apiMediaUploadPath = '/providers/sonata.media.provider.image/media.json';
var binariesMedia = '/binaries/reference/view.json';
//export const apiUploadWarranty = 'http://dev-swarranty.magentapulse.com/media-api/providers/sonata.media.provider.image/media.json';
/**
 * http://127.0.0.1:8000/index.php/api/qr-code/http:%2F%2Fwww.google.com.png
 */
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

module.exports = __webpack_require__(/*! /srv/http/smart-warranty-dev/libraries/spa/ngx-reg/src/main.ts */"./src/main.ts");


/***/ })

},[[0,"runtime","vendor"]]]);
//# sourceMappingURL=main.js.map
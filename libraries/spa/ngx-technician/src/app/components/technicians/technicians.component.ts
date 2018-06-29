import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router} from "@angular/router";

// import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";
import {dataTechnicians} from '../../model/fakeTechnicians';
import * as $ from 'jquery';

@Component({
    selector: 'technicians',
    templateUrl: './technicians.component.html',
    styleUrls: ['./technicians.component.scss']
})
export class TechniciansComponent implements OnInit, AfterViewInit {

    isLoading: boolean = false;
    techList : any = '';
    techListResolved : any = '';

    constructor() {
    }

    ngOnInit() {
        // console.log('dataTechnicians', dataTechnicians.products)
        this.techList = dataTechnicians.products_response;
        this.techListResolved = dataTechnicians.products_resolved;
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */
    // 1. switchTab
    switchTab(event: any, tabId: any) {
        // addclass tab
        $('.nav-link').removeClass('active');
        $(event.target).addClass('active');

        // show content
        $('.tab-pane').removeClass('fade show in active');
        $(tabId).addClass('fade show in active');
    }
}

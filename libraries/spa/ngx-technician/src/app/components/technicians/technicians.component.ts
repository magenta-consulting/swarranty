import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router} from "@angular/router";

import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";
import * as $ from 'jquery';
import {MemberService} from '../../service/member.service'
import { Member } from '../../model/member';
import { Case } from '../../model/case';
import { requireToken } from '../../helper/token';

@Component({
    selector: 'technicians',
    templateUrl: './technicians.component.html',
    styleUrls: ['./technicians.component.scss']
})
export class TechniciansComponent implements OnInit, AfterViewInit {

    isLoading: boolean = false;
    cases: Case[];

    constructor(private memberService: MemberService) {
        this.fetchMembers();
    }

    fetchMembers() {
        requireToken(this.memberService, () => {
            this.memberService.getMembers(1).subscribe(members => {
                this.cases = members[0].assignedCases;
            });
        })
    }

    ngOnInit() {
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

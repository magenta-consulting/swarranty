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
    completedCount = 0;
    uncompletedCount = 0;

    constructor(
        private memberService: MemberService,
        private router: Router
    ) {
        this.fetchMembers();
    }

    fetchMembers() {
        requireToken(this.memberService, () => {
            this.memberService.getMembers(1).subscribe(members => {
                this.cases = members[0].assignedOpenCases;
                this.completedCount = this.cases.filter(c => c.completed).length;
                this.uncompletedCount = this.cases.filter(c => !c.completed).length;
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

    logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_token');
        this.router.navigateByUrl('/login');
    }
}

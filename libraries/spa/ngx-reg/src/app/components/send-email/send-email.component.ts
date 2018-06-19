import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router} from "@angular/router";

@Component({
    selector: 'send-email',
    templateUrl: './send-email.component.html',
    styleUrls: ['./send-email.component.scss']
})
export class SendEmailComponent implements OnInit, AfterViewInit {

    constructor(private router: Router) {
    }

    ngOnInit() {
    }

    ngAfterViewInit() {
    }

}

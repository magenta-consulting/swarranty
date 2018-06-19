import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router} from "@angular/router";

@Component({
    selector: 'uploads',
    templateUrl: './uploads.component.html',
    styleUrls: ['./uploads.component.scss']
})
export class UploadsComponent implements OnInit, AfterViewInit {

    constructor(private router: Router) {
    }

    ngOnInit() {
    }

    ngAfterViewInit() {
    }

}

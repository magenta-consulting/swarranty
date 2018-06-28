import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router} from "@angular/router";

import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";

import {ImageUploadModule, FileHolder, UploadMetadata} from "../../extensions/angular2-image-upload";

@Component({
    selector: 'technician',
    templateUrl: './technician.component.html',
    styleUrls: ['../technicians/technicians.component.scss']
})
export class TechnicianComponent implements OnInit, AfterViewInit {

    isLoading: boolean = false;

    constructor() {
    }

    ngOnInit() {
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */
    // 1. Event uploads
    onBeforeUpload = (metadata: UploadMetadata) => {
        // mutate the file or replace it entirely - metadata.file
        // console.log('metadata.url', metadata.url);
    };

    onUploadFinished(file: FileHolder, warId: any) {
        console.log('finished', file);
    }

    onRemoved(file: FileHolder) {
        console.log('removed', file);
    }

    onUploadStateChanged(state: boolean) {
        console.log('state', state);
    }
}

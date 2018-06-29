import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";

import {apiEndPoint, apiEndPointBase, organisationPath} from "../../../environments/environment";

import {ImageUploadModule, FileHolder, UploadMetadata} from "../../extensions/angular2-image-upload";
import {dataTechnicians} from '../../model/fakeTechnicians';

@Component({
    selector: 'technician',
    templateUrl: './technician.component.html',
    styleUrls: ['../technicians/technicians.component.scss']
})
export class TechnicianComponent implements OnInit, AfterViewInit {

    isLoading: boolean = false;
    dataTech : any = '';
    brandList: any = '';
    modelNameList: any = '';
    modelNumberList: any = '';
    selectedBrand: any = '';
    selectedModelName: any = '';
    selectedModelNumber: any = '';

    constructor(private router: ActivatedRoute) {
        console.log('id', this.router.snapshot.params['id']);
    }

    ngOnInit() {
        this.dataTech = dataTechnicians.detailTechnician;
        this.brandList = dataTechnicians.brandList;
        this.modelNameList = dataTechnicians.modelNameList;
        this.modelNumberList = dataTechnicians.modelNumberList;

        // declare sample model
        this.selectedBrand = 'Fujioh';
        this.selectedModelName = 'ARG Hood';
        this.selectedModelNumber = 'GS99009';
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

    onChange(event: any) {
        console.log('event', event);
    }
}

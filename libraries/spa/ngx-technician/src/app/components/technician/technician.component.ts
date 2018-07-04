import {AfterViewInit, Component, ElementRef, EventEmitter, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';
import {Router, ActivatedRoute} from "@angular/router";

import {apiEndPoint, apiEndPointBase, organisationPath, apiEndPointMedia, apiMediaUploadPath, binariesMedia} from "../../../environments/environment";

import {ImageUploadModule, FileHolder, UploadMetadata} from "../../extensions/angular2-image-upload";
import { MemberService } from '../../service/member.service';
import { Member } from '../../model/member';
import { Case } from '../../model/case';
import { Brand } from '../../model/brand';
import { Product } from '../../model/product';
import { BrandCategory } from '../../model/brand-category';
import { Warranty } from '../../model/warranty';
import { ProductService } from '../../service/product.service';
import { Helper } from "../../helper/helper";
import { ServiceNote } from '../../model/service-note';
import { NoteService } from "../../service/note.service";
import { ServiceSheet } from '../../model/service-sheet';

@Component({
    selector: 'technician',
    templateUrl: './technician.component.html',
    styleUrls: ['../technicians/technicians.component.scss']
})
export class TechnicianComponent implements OnInit, AfterViewInit {
    id: number;
    sub: any;
    isLoading: boolean = false;
    cases: Case[];
    case: Case = null;
    uploadUrl: string = apiEndPointMedia + apiMediaUploadPath;
    currentAppointmentNote: ServiceNote;
    currentServiceSheet: ServiceSheet;
    noteDescription: string;
    isEditingDescription: boolean = false;
    imageUrls: string[] = [];

    constructor(
        private memberService: MemberService, 
        private productService: ProductService,
        private noteService: NoteService,
        private route: ActivatedRoute,
        private helper: Helper
    ) {
        memberService.getMembers(1).subscribe(members => {
            this.cases = members[0].assignedCases;
            this.cases.forEach(element => {
                if (element.id == this.id) {
                    this.case = element;
                    this.case.warranty.selectedBrand = (this.case.warranty.product as Product).brand;
                    this.case.warranty.selectedBrand.id = this.case.warranty.selectedBrand["@id"];
                }
            });
            this.case.appointments.forEach(appointment => {
                if (appointment.appointmentAt == this.case.appointmentAt) {
                    this.case.currentAppointment = appointment;
                }
            });
            this.case.serviceNotes.forEach(note => {
                if (note.appointment.appointmentAt == this.case.appointmentAt) {
                    this.currentAppointmentNote = note;
                }
            });
            this.case.serviceSheets.forEach(sheet => {
                if (sheet.appointment.appointmentAt == this.case.appointmentAt) {
                    this.currentServiceSheet = sheet;
                }
            });
            this.currentServiceSheet.images.forEach(img => {
                this.imageUrls.push(apiEndPointMedia + '/media/' + img.id + binariesMedia)
            });
            productService.getBrands().subscribe(brands => this.case.warranty.brands = brands);
            this.selectBrand(null, this.case.warranty);
            this.selectCategory(null, this.case.warranty);

            console.log(this.case);
        });
    }

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            this.id = params['id'];
        });
    }

    ngOnDestroy() {
        this.sub.unsubscribe();
    }

    ngAfterViewInit() {
    }

    /* =========================================== */
    /** Actions in this Comp */
    // 1. Event uploads
    onBeforeUpload = (metadata: UploadMetadata) => {
        // mutate the file or replace it entirely - metadata.file
        // console.log('metadata.url', metadata.url);
        let apiUploadWarranty = apiEndPointMedia + apiMediaUploadPath;
        let warId = metadata.url.substring(apiUploadWarranty.length + 1);
        metadata.formData = {
            "imageServiceSheet": this.currentServiceSheet.id,
            "context": "receipt_image"
        };

        // console.log('warid is',warId);        
        metadata.url = apiUploadWarranty;
        return metadata;
    };

    onUploadFinished(file: FileHolder, warId: any) {
        console.log('finished', file);
    }

    onRemoved(file: FileHolder) {
        // let v_confirm = confirm('Do you really want to remove this image ?');
        // console.log('removed', file);
        let splitUrlMedia = this.helper.explode('/media/', file.src, undefined);
        let imgId = this.helper.explode(binariesMedia, splitUrlMedia[1], undefined);
        if (imgId == null) {
            return;
        }
        // if (v_confirm == true) {
            this.productService.deleteWarrantyImg(parseInt(imgId[0])).subscribe(
                res => {
                    console.log('res', res);
                },
                error => {
                    console.log('Error', error);
                },
                () => {
                    console.log('Complete Request');
                }
            );
        // }
    }

    onUploadStateChanged(state: boolean) {
        console.log('state', state);
    }

    selectBrand(e, warranty: Warranty): void {
        let brand = warranty.selectedBrand;
        if (brand == null) {
            warranty.selectedCategory = null;
            warranty.product = null;
            return;
        }
        if (brand.id !== null) {
            warranty.categories = [{id: null, name: 'Loading'} as BrandCategory];
            warranty.isProductHidden = true;
            warranty.isCategoryHidden = true;

            this.productService.getCategories(brand.id).subscribe(cats => {
                warranty.categories = cats;
                warranty.isCategoryHidden = false;
                warranty.selectedCategory = null;
            });
        }
    }

    selectCategory(e, warranty: Warranty): void {
        if (warranty.selectedCategory == null) {
            // warranty.product = null;
            return;
        }
        if (warranty.selectedCategory.id !== null) {
            warranty.products = [{id: null, name: 'Loading'} as Product]
            warranty.isProductHidden = true;

            this.productService.getProductsByCategory(warranty.selectedCategory.id).subscribe(prods => {
                warranty.products = prods;
                warranty.isProductHidden = false;
                warranty.selectedProduct = null;
            });
        }
    }

    deleteNote(note: ServiceNote) {
        this.noteService.delete(note.id).subscribe((res) => console.log(res));
        if (note == this.currentAppointmentNote) {
            this.currentAppointmentNote = null;
        }
        this.case.serviceNotes.splice(this.case.serviceNotes.indexOf(note), 1);
    }

    updateNote() {
        let note = {
            appointment: `/api/case-appointments/${this.case.currentAppointment.id}`,
            case: `/api/warranty-cases/${this.case.id}`,
            description: this.currentAppointmentNote.description,
            id: this.currentAppointmentNote.id
        }
        this.noteService.update(note).subscribe(res => {
            console.log(res);
            this.isEditingDescription = false
        })
    }

    addNote() {
        let note = {
            appointment: `/api/case-appointments/${this.case.currentAppointment.id}`,
            case: `/api/warranty-cases/${this.case.id}`,
            description: this.noteDescription
        }
        console.log(note);
        this.noteService.add(note).subscribe(res => {
            this.currentAppointmentNote = new ServiceNote();
            this.currentAppointmentNote.appointment = this.case.currentAppointment;
            this.currentAppointmentNote.description = this.noteDescription;
            this.currentAppointmentNote.id = res['id'];
            this.case.serviceNotes.push(this.currentAppointmentNote);
        });
    }
}

import {Component, OnInit} from '@angular/core';
import {NgSelectModule, NgOption} from '@ng-select/ng-select';

@Component({
    selector: 'app-registration',
    templateUrl: './registration.component.html',
    styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent implements OnInit {

    categories = [
        {id: 1, name: "Category 1"},
        {id: 2, name: "Category 2"}
    ];
    selectedCategory: any;
    purchaseDate;

    constructor() {
    }

    ngOnInit() {
    }

    test():void {
        this.categories = [...this.categories, {id:3, name:"hello 3"}];
    }
}

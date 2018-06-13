import {Component, ElementRef} from '@angular/core';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent {
    title = 'app';
    data = ['item 1', 'item 2', 'item 3'];

    constructor(private eRef: ElementRef) {
        const native = eRef.nativeElement;
        const orgId = native.getAttribute('organisation');
        localStorage.setItem('orgId', orgId);
    }

    addData(): void {
        this.data.push('new data');
    }

}

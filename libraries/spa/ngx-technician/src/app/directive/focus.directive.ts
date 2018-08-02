import {Directive, ElementRef, EventEmitter, Input, OnInit, Renderer2} from '@angular/core';

@Directive({
    selector: '[focus]'
})
export class FocusDirective implements OnInit {
    @Input('focus') focusEvent: EventEmitter<boolean>;

    constructor(private element: ElementRef, private renderer: Renderer2) {
    }

    ngOnInit() {
        if (this.focusEvent !== undefined) {
            this.focusEvent.subscribe(event => {
                this.element.nativeElement.focus();
            });
        }
    }
}

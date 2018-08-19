class HearFrom {
    options: Option[];
    otherOption: string;
}
export class Survey {
    ageGroup: Option[];
    hearFrom: Option[];
    reason: Option[];

    selectedAgeGroup: string;
    otherHearFrom: Option = {
        name: '',
        value: 'other',
        selected: false
    };
    otherReason: Option = {
        name: '',
        value: 'other',
        selected: false
    };

    getResult() {
        var res = {
            ageGroup: this.selectedAgeGroup,
            hearFrom: {
                options: this.hearFrom ? this.hearFrom.filter(o => o.selected).map(o => o.value) : null,
                blanks: this.hearFrom ? this.hearFrom.filter(o => !o.selected).map(o => o.value) : null,
                other: this.otherHearFrom.selected ? this.otherHearFrom.name : ''
            },
            reason: {
                options: this.reason? this.reason.filter(o => o.selected).map(o => o.value) : null,
                blanks: this.reason? this.reason.filter(o => !o.selected).map(o => o.value) : null,
                other: this.otherReason.selected ? this.otherReason.name : ''
            }
        }
        if (!res.ageGroup) {
            return false;
        }
        if (!res.hearFrom.other && res.hearFrom.options.length == 0) {
            return false;
        }
        if (!res.reason.other && res.reason.options.length == 0) {
            return false;
        }
        return res;
    }
}

export class Option {
    name: string;
    value: string;
    selected: boolean;
}
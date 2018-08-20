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

    // 1 - Missing age group
    // 2 - Missing hear from
    // 3 - Missing other hear from when other is checked
    // 4 - Missing reason
    // 5 - Missing other reason when other is checked
    getResultOrErrorCode() {
        var errors = [];
        if (this.otherHearFrom.selected && !this.otherHearFrom.name) {
            errors.push(3);
        }
        if (this.otherReason.selected && !this.otherReason.name) {
            errors.push(5);
        }
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
            errors.push(1);
        }
        if (!res.hearFrom.other && res.hearFrom.options.length == 0) {
            errors.push(2);
        }
        if (!res.reason.other && res.reason.options.length == 0) {
            errors.push(4);
        }
        return {
            res: res,
            errors: errors
        };
    }

    getResult() {
        var res = this.getResultOrErrorCode();
        if (res.errors.length > 0) {
            return false;
        } else {
            return res.res;
        }
    }
}

export class Option {
    name: string;
    value: string;
    selected: boolean;
}
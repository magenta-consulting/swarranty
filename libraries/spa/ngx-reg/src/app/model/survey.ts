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
        return {
            ageGroup: this.selectedAgeGroup,
            hearFrom: {
                options: this.hearFrom ? this.hearFrom.filter(o => o.selected).map(o => o.value) : null,
                other: this.otherHearFrom.selected ? this.otherHearFrom.name : undefined
            },
            reason: {
                options: this.reason? this.reason.filter(o => o.selected).map(o => o.value) : null,
                other: this.otherReason.selected ? this.otherReason.name : undefined
            }
        }
    }
}

export class Option {
    name: string;
    value: string;
    selected: boolean;
}
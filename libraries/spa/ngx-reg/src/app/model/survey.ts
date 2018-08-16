export class Survey {
    ageGroup: Option[];
    howKnow: Option[];
    whyChoose: Option[];

    selectedAgeGroup: string;
    otherHowKnow: Option = {
        name: '',
        value: 'other',
        selected: false
    };
    otherWhyChoose: Option = {
        name: '',
        value: 'other',
        selected: false
    };

    getResult() {
        return {
            ageGroup: this.selectedAgeGroup,
            otherHowKnow: this.otherHowKnow.selected ? this.otherHowKnow.name : undefined,
            otherWhyChoose: this.otherWhyChoose.selected ? this.otherWhyChoose.name : undefined,
            howKnow: this.howKnow ? this.howKnow.filter(o => o.selected).map(o => o.value) : null,
            whyChoose: this.whyChoose? this.whyChoose.filter(o => o.selected).map(o => o.value) : null
        }
    }
}

export class Option {
    name: string;
    value: string;
    selected: boolean;
}
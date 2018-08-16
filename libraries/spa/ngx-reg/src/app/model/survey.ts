export class Survey {
    ageGroup: Option[];
    howKnow: Option[];
    whyChoose: Option[];

    selectedAgeGroup: string;

    getResult() {
        return {
            ageGroup: this.selectedAgeGroup,
            howKnow: this.howKnow ? this.howKnow.filter(o => o.selected).map(o => o.name) : null,
            whyChoose: this.whyChoose? this.whyChoose.filter(o => o.selected).map(o => o.name) : null
        }
    }
}

export class Option {
    name: string;
    value: string;
    selected: boolean;
}
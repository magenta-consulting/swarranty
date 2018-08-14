import {Case} from './case';
import { Person } from './person';

export class Member {
    id: number;
    type: string;
    assignedOpenCases: Case[];
    organization: string;
    person: Person
}
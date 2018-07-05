import {Case} from './case';
import { Person } from './person';

export class Member {
    id: number;
    type: string;
    assignedCases: Case[];
    organization: string;
    person: Person
}
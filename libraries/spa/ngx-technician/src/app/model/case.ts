import { Warranty } from "./warranty";
import { Registration } from "./registration";
import { Product } from "./product";
import { Appointment } from "./appointment";
import { ServiceNote } from "./service-note";
import { ServiceSheet } from "./service-sheet";
import {ServiceZone} from "./service-zone";

export class Case {
    _id: string;
    id: number;
    children: Case[];
    warranty: Warranty;
    serviceZone: ServiceZone;
    createdAt: Date;
    appointmentAt: Date;
    completed: boolean;
    status: string;
    number: string;
    description: string;
    specialRemarks: string;
    appointments: Appointment[];
    currentAppointment: Appointment;
    serviceNotes: ServiceNote[];
    serviceSheets: ServiceSheet[];
}
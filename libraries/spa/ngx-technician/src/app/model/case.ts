import { Warranty } from "./warranty";
import { Registration } from "./registration";
import { Product } from "./product";
import { Appointment } from "./appointment";
import { ServiceNote } from "./service-note";

export class Case {
    _id: string;
    id: number;
    children: Case[];
    warranty: Warranty;
    serviceZone: {};
    createdAt: Date;
    appointmentAt: Date;
    completed: boolean;
    status: string;
    number: string;
    description: string;
    appointments: Appointment[];
    currentAppointment: Appointment;
    serviceNotes: ServiceNote[];
    serviceSheets: any[]
}
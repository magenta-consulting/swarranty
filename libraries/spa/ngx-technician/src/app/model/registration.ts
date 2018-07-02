import { Customer } from './customer';
import { Warranty } from './warranty';

export class Registration {
  id?: string;
  customer: Customer|string;
  warranties: Warranty[];
  submitted = false;
  verified: boolean;

}

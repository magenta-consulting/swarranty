import { TestBed, inject } from '@angular/core/testing';

import { WarrantyService } from './warranty.service';

describe('WarrantyService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [WarrantyService]
    });
  });

  it('should be created', inject([WarrantyService], (service: WarrantyService) => {
    expect(service).toBeTruthy();
  }));
});

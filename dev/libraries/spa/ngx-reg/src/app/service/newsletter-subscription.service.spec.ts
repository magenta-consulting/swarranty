import { TestBed, inject } from '@angular/core/testing';

import { NewsletterSubscriptionService } from './newsletter-subscription.service';

describe('NewsletterSubscriptionService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [NewsletterSubscriptionService]
    });
  });

  it('should be created', inject([NewsletterSubscriptionService], (service: NewsletterSubscriptionService) => {
    expect(service).toBeTruthy();
  }));
});

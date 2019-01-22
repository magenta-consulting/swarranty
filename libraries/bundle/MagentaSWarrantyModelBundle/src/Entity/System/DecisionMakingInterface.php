<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

interface DecisionMakingInterface
{
    const DECISION_APPROVE = 'APPROVE';
    const DECISION_RESET = 'RESET';
    const DECISION_REJECT = 'REJECT';

    const STATUS_NEW = 'NEW';
    const STATUS_EXPIRED = 'EXPIRED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_APPROVED = 'APPROVED';

    public function getDecisionStatus(): string;

    public function makeDecision(string $decision);

    public function setDecisionRemarks(?string $remarks);

    public function getDecisionRemarks(): ?string;
}

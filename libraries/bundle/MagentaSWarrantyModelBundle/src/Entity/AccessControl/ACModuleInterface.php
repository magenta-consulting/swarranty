<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

interface ACModuleInterface {
	
	public function getModuleName(): string;
	
	public function getModuleCode(): string;
	
	public function getSupportedModuleActions(): array;
	
	public function isClassSupported(string $class): bool;
	
	public function isUserGranted(OrganisationMember $member, $permission, $object, $class): ?bool;
}
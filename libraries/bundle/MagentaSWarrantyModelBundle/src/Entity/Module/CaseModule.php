<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Module;


use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACModuleInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="module__case")
 */
class CaseModule extends SystemModule implements ACModuleInterface {
	
	function __construct() {
		parent::__construct();
	}
	
	public function isUserGranted(OrganisationMember $member = null, $permission, $object, $class): ?bool {
		if( ! $this->isClassSupported($class)) {
			return null;
		}
		
		return parent::isUserGranted($member, $permission, $object, $class);
	}
	
	public function isClassSupported(string $class): bool {
		return in_array($class, [ WarrantyCase::class, CaseAppointment::class ]);
	}
	
	public function getSupportedModuleActions(): array {
		return array_merge([
			ACEntry::PERMISSION_ASSIGN,
			ACEntry::PERMISSION_RECEIVE
		], ACEntry::getSupportedActions());
	}
	
	public function getModuleName(): string {
		return 'Case Management';
	}
	
	public function getModuleCode(): string {
		return 'CASE';
	}
}
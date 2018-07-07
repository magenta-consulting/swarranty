<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Module;

use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACModuleInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="module__warranty")
 */
class WarrantyModule extends SystemModule implements ACModuleInterface {
	const MODULE_CODE = 'WARRANTY';
	
	const PERMISSION_CREATE_CASE = ACEntry::PERMISSION_CREATE . '_CASE';
	const PERMISSION_LIST_CASES = ACEntry::PERMISSION_LIST . '_CASES';
	
	public function isUserGranted(User $user, $permission, $object): ?bool {
		/** @var Warranty $w */
		$w = $object;
		if( ! $this->isClassSupported(get_class($object))) {
			return null;
		}
		
		if($permission === self::PERMISSION_CREATE_CASE || $permission === self::PERMISSION_LIST_CASES) {
			return $w->isEnabled();
		}
		
		return true;
	}
	
	public function isClassSupported(string $class): bool {
		return $class === Warranty::class;
	}
	
	public function getSupportedModuleActions(): array {
		return array_merge([
			ACEntry::PERMISSION_APPROVE,
			ACEntry::PERMISSION_REJECT
		], ACEntry::getSupportedActions());
	}
	
	public function getModuleName(): string {
		return 'Warranty Management';
	}
	
	public function getModuleCode(): string {
		return self::MODULE_CODE;
	}
}
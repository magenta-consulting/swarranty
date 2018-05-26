<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Module;


use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACModuleInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;

/**
 * @ORM\Entity()
 * @ORM\Table(name="module__case")
 */
class CaseModule extends SystemModule implements ACModuleInterface {
	
	public function getSupportedModuleActions(): array {
		return ACEntry::getSupportedActions();
	}
	
	public function getModuleName(): string {
		return 'Case Management';
	}
	
	public function getModuleCode(): string {
		return 'CASE';
	}
}
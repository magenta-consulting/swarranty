<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Module;


use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACModuleInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="module__product")
 */
class ProductModule extends SystemModule implements ACModuleInterface {
	public function isUserGranted(User $user, $permission, $object): ?bool {
		return true;
	}
	public function isClassSupported(string $class): bool {
		return $class === Product::class;
	}
	
	public function getSupportedModuleActions(): array {
		return ACEntry::getSupportedActions();
	}
	
	public function getModuleName(): string {
		return 'Product Management';
	}
	
	public function getModuleCode(): string {
		return 'PRODUCT';
	}
}
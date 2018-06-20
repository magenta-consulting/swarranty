<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Media;

use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin as SonataMediaAdmin;

class MediaAdmin extends SonataMediaAdmin {
//	public function isGranted($name, $object = null) {
//		if($name === 'VIEW') {
//			return parent::isGranted($name, $object);
//		} else {
//			return $this->getConfigurationPool()->getContainer()->get(UserService::class)->getUser()->isAdmin();
//		}
//	}
}
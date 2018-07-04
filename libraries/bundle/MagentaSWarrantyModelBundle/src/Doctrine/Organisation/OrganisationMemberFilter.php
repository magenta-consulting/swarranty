<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Organisation;

use Doctrine\ORM\Mapping\ClassMetaData,
	Doctrine\ORM\Query\Filter\SQLFilter;

class OrganisationMemberFilter extends SQLFilter {
	
	public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias) {
		// Check if the entity implements the LocalAware interface
		if( ! $targetEntity->getReflectionClass()->implementsInterface('LocaleAware')) {
			return "";
		}
		
		return $targetTableAlias . '.locale = ' . $this->getParameter('locale'); // getParameter applies quoting automatically
	}
	
}
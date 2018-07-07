<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\System;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\ThingChildInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user__user")
 */
class User extends AbstractUser {
	const ROLE_ADMIN = 'ROLE_ADMIN';
	const ROLE_POWER_USER = 'ROLE_POWER_USER';
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	public function isAdmin(): bool {
		foreach($this->roles as $role) {
			if(in_array($role, [ User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN ])) {
				return true;
			}
		}
		
		return false;
	}
	
	public static function generateCharacterCode($code = null, $x = 4) {
		if(empty($code)) {
			$maxRange36 = '';
			for($i = 0; $i < $x; $i ++) {
				$maxRange36 .= 'Z';
			}
			
			$maxRange = intval(base_convert($maxRange36, 36, 10));
			$code     = base_convert(rand(0, $maxRange), 10, 36);
		}
		
		for($i = 0; $i < $x - strlen($code);) {
			$code = '0' . $code;
		}
		
		return strtoupper($code);
	}
	
	public function isGranted($permission = 'ALL', $object = null, $class = null, OrganisationMember $member = null) {
		if($permission === 'EXPORT') {
			return false;
		}
		
		if( ! empty($member)) {
			/** @var Organisation $org */
			$org    = $member->getOrganization();
			$system = $org->getSystem();
			
			$modules = $system->getModules();
			
			/** @var SystemModule $module */
			foreach($modules as $module) {
				if($module->isUserGranted($this, $permission, $object)) {
					return true;
				}
			}
		}
		
		switch($class) {
			case Organisation::class:
				return $this->isAdmin();
				break;
		}
		
		if($object instanceof Thing) {
			$org = $object->getOrganisation();
			if($this->adminOrganisation === $org) {
				return true;
			}
		} elseif($object instanceof ThingChildInterface) {
		
		}
		
		$permission = strtoupper($permission);
		if($permission === 'LIST') {
			return true;
		}
		if($permission === 'DELETE') {
			return true;
		}
		if($permission === 'EDIT') {
			return true;
		}
		if($permission === 'CREATE') {
			return true;
		}
		if($permission === 'VIEW') {
			return true;
		}
		
		if($object instanceof DecisionMakingInterface) {
			if($permission === 'DECISION_' . DecisionMakingInterface::DECISION_APPROVE) {
				return $object->getDecisionStatus() === null || $object->getDecisionStatus() === DecisionMakingInterface::STATUS_NEW;
			} elseif($permission === 'DECISION_' . DecisionMakingInterface::DECISION_REJECT) {
//				return $object->getDecisionStatus() !== DecisionMakingInterface::STATUS_REJECTED;
				return $object->getDecisionStatus() === null || $object->getDecisionStatus() === DecisionMakingInterface::STATUS_NEW;
			}
			if(in_array($permission, [
				'DECIDE',
				'DECIDE_ALL',
				'DECISION_APPROVE',
				'DECISION_REJECT',
				'DECISION_' . WarrantyCase::DECISION_CLOSE,
				'DECISION_' . WarrantyCase::DECISION_REOPEN
			])) {
				return true;
			}
		}
		
		return false;
	}
	
	//	For UserAdmin
	
	/**
	 * @return array
	 */
	public function getRealRoles() {
		return $this->roles;
	}
	
	/**
	 * @param array $roles
	 *
	 * @return User
	 */
	public function setRealRoles(array $roles) {
		$this->setRoles($roles);
		
		return $this;
	}
	
	/**
	 * @var Organisation|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="adminUser")
	 * @ORM\JoinColumn(name="id_admin_organisation", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $adminOrganisation;
	
	/**
	 * @var Person|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person", cascade={"persist", "merge"}, inversedBy="user")
	 * @ORM\JoinColumn(name="id_person", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $person;
	
	/**
	 * @return Person|null
	 */
	public function getPerson(): ?Person {
		return $this->person;
	}
	
	/**
	 * @param Person|null $person
	 */
	public function setPerson(?Person $person): void {
		$this->person = $person;
	}
	
	/**
	 * @return Organisation
	 */
	public function getAdminOrganisation(): ?Organisation {
		return $this->adminOrganisation;
	}
	
	/**
	 * @param Organisation $adminOrganisation
	 */
	public function setAdminOrganisation(Organisation $adminOrganisation): void {
		$this->adminOrganisation = $adminOrganisation;
	}
}

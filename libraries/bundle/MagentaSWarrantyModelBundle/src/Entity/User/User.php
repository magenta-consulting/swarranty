<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\ThingChildInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user__user")
 */
class User extends AbstractUser {
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
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
	
	public function isGranted($action = 'ALL', $object = null) {
		if($object instanceof Thing) {
		
		} elseif($object instanceof ThingChildInterface) {
		
		}
		$action = strtoupper($action);
		if($action === 'LIST') {
			return true;
		}
		if($action === 'DELETE') {
			return true;
		}
		if($action === 'EDIT') {
			return true;
		}
		if($action === 'CREATE') {
			return true;
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
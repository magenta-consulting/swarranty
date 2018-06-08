<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl;

use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;

/**
 * @ORM\Entity()
 * @ORM\Table(name="access__entry")
 */
class ACEntry {
	const PERMISSION_CREATE = 'CREATE';
	const PERMISSION_READ = 'READ';
	const PERMISSION_UPDATE = 'UPDATE';
	const PERMISSION_DELETE = 'DELETE';
	const PERMISSION_LIST = 'LIST';
	const PERMISSION_ASSIGN = 'ASSIGN';
	const PERMISSION_RECEIVE = 'RECEIVE';
	const PERMISSION_APPROVE = 'APPROVE';
	const PERMISSION_REJECT = 'REJECT';
	
	const STATUS_GRANTED = 'GRANTED';
	const STATUS_DENIED = 'DENIED';
	const STATUS_EMPTY = 'EMPTY';
	
	public static function getSupportedActions() {
		return [
			self::PERMISSION_CREATE,
			self::PERMISSION_READ,
			self::PERMISSION_UPDATE,
			self::PERMISSION_DELETE
		];
	}
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @var ACRole
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole", inversedBy="entries", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_role", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $role;
	
	/**
	 * @var SystemModule
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule", inversedBy="acEntries", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_module", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $module;
	
	
	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $permission;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $enabled = true;
	
	/**
	 * @return bool
	 */
	public function isEnabled(): bool {
		return $this->enabled;
	}
	
	/**
	 * @param bool $enabled
	 */
	public function setEnabled(bool $enabled): void {
		$this->enabled = $enabled;
	}
	
	/**
	 * @return ACRole
	 */
	public function getRole(): ACRole {
		return $this->role;
	}
	
	/**
	 * @param ACRole $role
	 */
	public function setRole(ACRole $role): void {
		$this->role = $role;
	}
	
	/**
	 * @return string
	 */
	public function getPermission(): string {
		return $this->permission;
	}
	
	/**
	 * @param string $permission
	 */
	public function setPermission(string $permission): void {
		$this->permission = $permission;
	}
	
	/**
	 * @return SystemModule
	 */
	public function getModule(): SystemModule {
		return $this->module;
	}
	
	/**
	 * @param SystemModule $module
	 */
	public function setModule(SystemModule $module): void {
		$this->module = $module;
	}
}
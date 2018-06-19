<?php

namespace Magenta\Bundle\SWarrantyApiBundle\Dto\Customer;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationEmail {
	
	const TYPE_VERIFICATION = 'verification';
	const TYPE_CONFIRMATION = 'confirmation';
	
	/**
	 * @var integer
	 * @Assert\NotBlank
	 */
	public $registrationId;
	
	/**
	 * @var string
	 * @Assert\NotBlank
	 * @Assert\Choice({"verification", "confirmation"})
	 */
	public $type;
}

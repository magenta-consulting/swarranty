<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Magenta\Bundle\SWarrantyModelBundle\Security;

class EmailUserProvider extends UserProvider
{
	/**
	 * {@inheritdoc}
	 */
	protected function findUser($username)
	{
		return $this->userManager->findUserByUsernameOrEmail($username);
	}
}
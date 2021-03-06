<?php

/*
 * This file is part of the BITFacebookBundle package.
*
* (c) bitgandtter <http://bitgandtter.github.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace BIT\FacebookBundle\Security\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserManagerInterface extends UserProviderInterface
{
  
  function createUserFromUid( $uid );
}

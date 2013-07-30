<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle\Security\Firewall;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;
use BIT\FacebookBundle\Security\Authentication\Token\FacebookUserToken;

/**
 * Facebook authentication listener.
 */
class FacebookListener extends AbstractAuthenticationListener
{
  
  protected function attemptAuthentication( Request $request )
  {
    return $this->authenticationManager->authenticate( new FacebookUserToken( $this->providerKey) );
  }
}

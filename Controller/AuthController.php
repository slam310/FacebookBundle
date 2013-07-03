<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
  
  public function writeAuthInSessionAction( )
  {
    $accessToken = $this->getRequest( )->get( "accessToken" );
    $this->get( "session" )->set( "fb.accessToken", $accessToken );
    return new JsonResponse( array( "accessToken" => $accessToken ));
  }
}

<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle\Templating\Helper;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\EngineInterface;

class FacebookHelper extends Helper
{
  protected $templating;
  protected $logging;
  protected $culture;
  protected $scope;
  protected $facebook;
  
  public function __construct( EngineInterface $templating, \BaseFacebook $facebook, $logging = true,
      $culture = 'en_US', array $scope = array( ) )
  {
    $this->templating = $templating;
    $this->logging = $logging;
    $this->culture = $culture;
    $this->scope = $scope;
    $this->facebook = $facebook;
  }
  
  /**
   * Returns the HTML necessary for initializing the JavaScript SDK.
   *
   * The default template includes the following parameters:
   *
   *  * async
   *  * fbAsyncInit
   *  * appId
   *  * xfbml
   *  * oauth
   *  * status
   *  * cookie
   *  * logging
   *  * culture
   *
   * @param array  $parameters An array of parameters for the initialization template
   * @param string $name       A template name
   *
   * @return string An HTML string
   */
  
  public function initialize( $parameters = array( ) )
  {
    $defaults = array( );
    $defaults[ 'async' ] = true;
    $defaults[ 'fbAsyncInit' ] = '';
    $defaults[ 'appId' ] = ( string ) $this->facebook->getAppId( );
    $defaults[ 'xfbml' ] = false;
    $defaults[ 'oauth' ] = true;
    $defaults[ 'status' ] = false;
    $defaults[ 'cookie' ] = true;
    $defaults[ 'logging' ] = $this->logging;
    $defaults[ 'culture' ] = $this->culture;
    $defaults[ 'onlycode' ] = false;
    
    $name = 'BITFacebookBundle::initialize.html.twig';
    return $this->templating->render( $name, array_merge( $defaults, $parameters ) );
  }
  
  public function loginButton( $parameters = array( ) )
  {
    $defaults = array( );
    $defaults[ 'autologoutlink' ] = 'false';
    $defaults[ 'label' ] = '';
    $defaults[ 'scope' ] = implode( ',', $this->scope );
    $defaults[ 'onlycode' ] = false;
    
    $name = 'BITFacebookBundle::loginButton.html.twig';
    return $this->templating->render( $name, array_merge( $defaults, $parameters ) );
  }
  
  public function scope( )
  {
    $parameters = array( 'scope' => implode( ',', $this->scope ) );
    $name = 'BITFacebookBundle::scope.html.twig';
    return $this->templating->render( $name, $parameters );
  }
  
  public function loginUrl( $redirectUrl )
  {
    $parameters[ "redirect_uri" ] = $redirectUrl . "?facebook=true";
    $defaults = array( 'scope' => implode( ',', $this->scope ) );
    return $this->facebook->getLoginUrl( array_merge( $defaults, $parameters ) );
  }
  
  public function loginFunction( )
  {
    $name = 'BITFacebookBundle::loginFunction.html.twig';
    return $this->templating->render( $name, array( ) );
  }
  
  public function loginFunction( )
  {
    $name = 'BITFacebookBundle::setAccessTokenFunction.html.twig';
    return $this->templating->render( $name, array( ) );
  }
  
  public function logoutUrl( $parameters = array( ), $name = null )
  {
    return $this->facebook->getLogoutUrl( $parameters );
  }
  
  public function getName( )
  {
    return 'facebook';
  }
}

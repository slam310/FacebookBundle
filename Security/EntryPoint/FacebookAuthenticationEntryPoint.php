<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle\Security\EntryPoint;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * FacebookAuthenticationEntryPoint starts an authentication via Facebook.
 *
 */
class FacebookAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
  protected $facebook;
  protected $options;
  protected $permissions;
  
  /**
   * Constructor
   *
   * @param BaseFacebook $facebook
   * @param array    $options
   */
  
  public function __construct( \BaseFacebook $facebook, array $options = array( ), array $permissions = array( ) )
  {
    $this->facebook = $facebook;
    $this->permissions = $permissions;
    $this->options = new ParameterBag( $options);
  }
  
  public function start( Request $request, AuthenticationException $authException = null )
  {
    $redirect_uri = $request->getUriForPath( $this->options->get( 'check_path', '' ) );
    if ( $this->options->get( 'server_url' ) && $this->options->get( 'app_url' ) )
      $redirect_uri = str_replace( $this->options->get( 'server_url' ), $this->options->get( 'app_url' ), $redirect_uri );
    
    $params = array( );
    $params[ 'display' ] = $this->options->get( 'display', 'page' );
    $params[ 'scope' ] = implode( ',', $this->permissions );
    $params[ 'redirect_uri' ] = $redirect_uri;
    $loginUrl = $this->facebook->getLoginUrl( $params );
    
    $htmlCode = '<html><head></head><body><script>top.location.href="' . $loginUrl . '";</script></body></html>';
    if ( $this->options->get( 'server_url' ) && $this->options->get( 'app_url' ) )
      return new Response( $htmlCode);
    
    return new RedirectResponse( $loginUrl);
  }
}

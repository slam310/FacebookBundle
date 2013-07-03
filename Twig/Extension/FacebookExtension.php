<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle\Twig\Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use BIT\FacebookBundle\Templating\Helper\FacebookHelper;

class FacebookExtension extends \Twig_Extension
{
  protected $container;
  
  /**
   * Constructor.
   *
   * @param ContainerInterface $container
   */
  
  public function __construct( ContainerInterface $container )
  {
    $this->container = $container;
  }
  
  /**
   * Returns a list of global functions to add to the existing list.
   *
   * @return array An array of global functions
   */
  
  public function getFunctions( )
  {
    $extra = array( 'is_safe' => array( 'html' ) );
    
    $functions = array( );
    $functions[ 'facebook_initialize' ] = new \Twig_Function_Method( $this, 'renderInitialize', $extra);
    $functions[ 'facebook_login_button' ] = new \Twig_Function_Method( $this, 'renderLoginButton', $extra);
    $functions[ 'facebook_scope' ] = new \Twig_Function_Method( $this, 'renderScope', $extra);
    $functions[ 'facebook_login_function' ] = new \Twig_Function_Method( $this, 'renderLoginFunction', $extra);
    $functions[ 'facebook_login_url' ] = new \Twig_Function_Method( $this, 'renderLoginUrl', $extra);
    $functions[ 'facebook_logout_url' ] = new \Twig_Function_Method( $this, 'renderLogoutUrl', $extra);
    
    return $functions;
  }
  
  private function helper( )
  {
    return $helper = $this->container->get( 'bit_facebook.helper' );
  }
  
  public function renderInitialize( $parameters = array( ), $name = null )
  {
    return $this->helper( )->initialize( $parameters, $name ? : 'BITFacebookBundle::initialize.html.twig' );
  }
  
  public function renderLoginButton( $parameters = array( ), $name = null )
  {
    return $this->helper( )->loginButton( $parameters, $name ? : 'BITFacebookBundle::loginButton.html.twig' );
  }
  
  public function renderScope( )
  {
    return $this->helper( )->scope( );
  }
  
  public function renderLoginFunction( $loginCheck )
  {
    return $this->helper( )->loginFunction( $loginCheck );
  }
  
  public function renderLoginUrl( $redirectUtl, $parameters = array( ) )
  {
    return $this->helper( )->loginUrl( $redirectUtl, $parameters );
  }
  
  public function renderLogoutUrl( $parameters = array( ), $name = null )
  {
    return $this->helper( )->logoutUrl( $parameters );
  }
  
  public function getName( )
  {
    return 'facebook';
  }
}

<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle\Facebook;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Implements Symfony2 session persistence for Facebook.
 *
 */
class FacebookSessionPersistence extends \BaseFacebook
{
  const PREFIX = '_bit_facebook_';
  
  protected $session;
  protected $prefix;
  protected static $kSupportedKeys = array( 'state', 'code', 'access_token', 'user_id' );
  
  /**
   * @param array $config the application configuration.
   * @see BaseFacebook::__construct in facebook.php
   */
  
  public function __construct( $config, Session $session, $prefix = self::PREFIX )
  {
    $this->session = $session;
    $this->prefix = $prefix;
    $this->session->start( );
    
    parent::__construct( $config );
  }
  
  /**
   * Stores the given ($key, $value) pair, so that future calls to
   * getPersistentData($key) return $value. This call may be in another request.
   *
   * @param string $key
   * @param array $value
   *
   * @return void
   */
  
  protected function setPersistentData( $key, $value )
  {
    if ( !in_array( $key, self::$kSupportedKeys ) )
    {
      self::errorLog( 'Unsupported key passed to setPersistentData.' );
      return;
    }
    
    $this->session->set( $this->constructSessionVariableName( $key ), $value );
  }
  
  /**
   * Get the data for $key, persisted by BaseFacebook::setPersistentData()
   *
   * @param string $key The key of the data to retrieve
   * @param boolean $default The default value to return if $key is not found
   *
   * @return mixed
   */
  
  protected function getPersistentData( $key, $default = false )
  {
    if ( !in_array( $key, self::$kSupportedKeys ) )
    {
      self::errorLog( 'Unsupported key passed to getPersistentData.' );
      return $default;
    }
    
    $sessionVariableName = $this->constructSessionVariableName( $key );
    if ( $this->session->has( $sessionVariableName ) )
    {
      return $this->session->get( $sessionVariableName );
    }
    
    return $default;
    
  }
  
  /**
   * Clear the data with $key from the persistent storage
   *
   * @param string $key
   * @return void
   */
  
  protected function clearPersistentData( $key )
  {
    if ( !in_array( $key, self::$kSupportedKeys ) )
    {
      self::errorLog( 'Unsupported key passed to clearPersistentData.' );
      return;
    }
    
    $this->session->remove( $this->constructSessionVariableName( $key ) );
  }
  
  /**
   * Clear all data from the persistent storage
   *
   * @return void
   */
  
  protected function clearAllPersistentData( )
  {
    foreach ( $this->session->all( ) as $k => $v )
    {
      if ( 0 !== strpos( $k, $this->prefix ) )
      {
        continue;
      }
      
      $this->session->remove( $k );
    }
  }
  
  protected function constructSessionVariableName( $key )
  {
    return $this->prefix . implode( '_', array( 'fb', $this->getAppId( ), $key, ) );
  }
}

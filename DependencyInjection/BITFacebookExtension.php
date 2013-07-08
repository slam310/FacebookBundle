<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BITFacebookExtension extends Extension
{
  
  public function load( array $configs, ContainerBuilder $container )
  {
    $processor = new Processor( );
    $configuration = new Configuration( );
    $config = $processor->processConfiguration( $configuration, $configs );
    
    $this->loadDefaults( $container );
    
    foreach ( array( 'api', 'helper', 'twig' ) as $attribute )
      $container->setParameter( 'bit_facebook.' . $attribute . '.class', $config[ 'class' ][ $attribute ] );
    
    foreach ( array( 'app_id', 'secret', 'cookie', 'domain', 'logging', 'culture', 'permissions' ) as $attribute )
      $container->setParameter( 'bit_facebook.' . $attribute, $config[ $attribute ] );
    
    if ( isset( $config[ 'file' ] ) && $container->hasDefinition( 'bit_facebook.api' ) )
    {
      $facebookApi = $container->getDefinition( 'bit_facebook.api' );
      $facebookApi->setFile( $config[ 'file' ] );
    }
  }
  
  protected function loadDefaults( $container )
  {
    $loader = new XmlFileLoader( $container, new FileLocator( __DIR__ . '/../Resources/config'));
    
    foreach ( array( 'facebook' => 'facebook.xml', 'security' => 'security.xml' ) as $resource )
      $loader->load( $resource );
  }
}

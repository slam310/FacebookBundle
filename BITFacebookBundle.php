<?php

/*
 * This file is part of the BITFacebookBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\FacebookBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use BIT\FacebookBundle\DependencyInjection\Security\Factory\FacebookFactory;

class BITFacebookBundle extends Bundle
{
  
  public function build( ContainerBuilder $container )
  {
    parent::build( $container );
    
    $extension = $container->getExtension( 'security' );
    $extension->addSecurityListenerFactory( new FacebookFactory( ) );
  }
}

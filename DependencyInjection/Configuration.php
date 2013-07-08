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
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  
  public function getConfigTreeBuilder( )
  {
    $treeBuilder = new TreeBuilder( );
    $rootNode = $treeBuilder->root( 'bit_facebook' );
    
    $rootNode->children( ) // config
        ->scalarNode( 'app_id' )->isRequired( )->cannotBeEmpty( )->end( ) // app id
        ->scalarNode( 'secret' )->isRequired( )->cannotBeEmpty( )->end( ) // secret
        ->scalarNode( 'cookie' )->defaultFalse( )->end( ) // cookie
        ->scalarNode( 'domain' )->defaultNull( )->end( ) // domain
        ->scalarNode( 'logging' )->defaultValue( '%kernel.debug%' )->end( ) // loggin
        ->scalarNode( 'culture' )->defaultValue( 'en_US' )->end( ) // culture
        ->arrayNode( 'class' )->addDefaultsIfNotSet( )->children( ) // clases
        ->scalarNode( 'api' )->defaultValue( 'BIT\FacebookBundle\Facebook\FacebookSessionPersistence' )->end( )
        ->scalarNode( 'helper' )->defaultValue( 'BIT\FacebookBundle\Templating\Helper\FacebookHelper' )->end( )
        ->scalarNode( 'twig' )->defaultValue( 'BIT\FacebookBundle\Twig\Extension\FacebookExtension' )->end( )->end( )
        ->end( )->arrayNode( 'permissions' )->prototype( 'scalar' )->end( )->end( );
    
    return $treeBuilder;
  }
}

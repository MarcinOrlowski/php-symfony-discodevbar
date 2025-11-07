<?php

declare(strict_types=1);

/* #############################################################################
 *
 *   █▀▀▄  ▀                     █▀▀▄           █▀▀▄
 *   █  █ ▀█  ▄▀▀▄ ▄▀▀▄ ▄▀▀▄     █  █ ▄▀▀▄ █  █ █▀▀▄ ▄▀▀▄ █▄▀
 *   █  █  █   ▀▄  █    █  █     █  █ █▀▀  █  █ █  █  ▄▄█ █
 *   █▄▄▀ ▄█▄ ▀▄▄▀ ▀▄▄▀ ▀▄▄▀     █▄▄▀ ▀▄▄▀ ▀▄▀  █▄▄▀ ▀▄▄▀ █
 *
 *     Customizable developer toolbar for Symfony projects
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2025 Marcin Orlowski
 * @license   https://opensource.org/license/mit MIT
 * @link      https://github.com/MarcinOrlowski/php-symfony-discodevbar
 *
 * ########################################################################## */

namespace MarcinOrlowski\DiscoDevBar\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('disco_dev_bar');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('font_awesome')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                            ->info('Enable automatic Font Awesome inclusion from CDN')
                        ->end()
                        ->scalarNode('version')
                            ->defaultValue('6.5.1')
                            ->info('Font Awesome version to use when enabled')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

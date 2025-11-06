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

namespace MarcinOrlowski\DiscoDevBar\Twig;

use MarcinOrlowski\DiscoDevBar\Service\DiscoDevBarService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension that provides access to DiscoDevBar data
 */
class DiscoDevBarExtension extends AbstractExtension
{
    public function __construct(
        private readonly DiscoDevBarService $discoDevBarService
    ) {
    }

    /**
     * Returns list of functions provided by this extension.
     *
     * @return array<TwigFunction> List of functions
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('debug_banner_data', [
                $this,
                'getDiscoDevBarData',
            ]),
        ];
    }

    /**
     * Returns DiscoDevBar data for template rendering
     */
    public function getDiscoDevBarData(): \MarcinOrlowski\DiscoDevBar\Dto\DiscoDevBarData
    {
        return $this->discoDevBarService->getDiscoDevBarData();
    }
}

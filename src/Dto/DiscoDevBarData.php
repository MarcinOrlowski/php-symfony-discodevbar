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

namespace MarcinOrlowski\DiscoDevBar\Dto;

class DiscoDevBarData
{
    /**
     * @param array<Widget> $left
     * @param array<Widget> $right
     * @param bool          $leftExpand   Whether left container should expand
     * @param bool          $rightExpand  Whether right container should expand
     * @param bool          $hasError     Whether to show error/alternative view
     * @param string        $errorMessage Error message to display (when hasError is true)
     * @param string|null   $version      Bundle version (null shows as N/A)
     */
    public function __construct(
        public readonly array $left,
        public readonly array $right,
        public readonly bool $leftExpand,
        public readonly bool $rightExpand,
        public readonly bool $hasError = false,
        public readonly string $errorMessage = '',
        public readonly ?string $version = null
    ) {
    }
}

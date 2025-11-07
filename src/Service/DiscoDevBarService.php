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

namespace MarcinOrlowski\DiscoDevBar\Service;

use MarcinOrlowski\DiscoDevBar\Dto\DiscoDevBarData;
use MarcinOrlowski\DiscoDevBar\Dto\Widget;
use Symfony\Component\Yaml\Yaml;

class DiscoDevBarService
{
    /**
     * List of supported config filenames (in order of preference)
     */
    private const CONFIG_FILES = [
        '.disco-devbar.yaml',
        '.disco-devbar.yml',
        '.debug-banner.yaml',  // Legacy, kept for backward compatibility
    ];

    public function __construct(
        private readonly string $projectDir
    ) {
    }

    public function getDiscoDevBarData(): DiscoDevBarData
    {
        $configPath = $this->findConfigFile();

        // Default: empty widgets
        if ($configPath === null) {
            return new DiscoDevBarData(
                left:        [],
                right:       [],
                leftExpand:  false,
                rightExpand: false
            );
        }

        $config = Yaml::parseFile($configPath);

        // Ensure config is an array and has the expected structure
        if (!\is_array($config)) {
            $config = [];
        }

        $widgets = $config['widgets'] ?? [];
        if (!\is_array($widgets)) {
            $widgets = [];
        }

        $left = $widgets['left'] ?? [];
        $right = $widgets['right'] ?? [];

        $leftWidgets = $this->loadWidgets(\is_array($left) ? $left : []);
        $rightWidgets = $this->loadWidgets(\is_array($right) ? $right : []);

        return new DiscoDevBarData(
            left:        $leftWidgets,
            right:       $rightWidgets,
            leftExpand:  $this->hasExpandingWidget($leftWidgets),
            rightExpand: $this->hasExpandingWidget($rightWidgets)
        );
    }

    /**
     * Find the first existing config file from the list of supported filenames
     *
     * @return string|null Full path to config file or null if none found
     */
    private function findConfigFile(): ?string
    {
        foreach (self::CONFIG_FILES as $filename) {
            $path = $this->projectDir . '/' . $filename;
            if (\file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Check if any widget in the array has expand=true
     *
     * @param array<Widget> $widgets
     */
    private function hasExpandingWidget(array $widgets): bool
    {
        foreach ($widgets as $widget) {
            if ($widget->expand) {
                return true;
            }
        }

        return false;
    }

    /**
     * Load and normalize widgets from configuration array
     *
     * @param array<mixed> $widgetsData
     *
     * @return array<Widget>
     */
    private function loadWidgets(array $widgetsData): array
    {
        return \array_map(
            function ($widgetData): Widget {
                /** @var array<string, mixed> $data */
                $data = \is_array($widgetData) ? $widgetData : [];
                return Widget::fromArray($data);
            },
            $widgetsData
        );
    }
}

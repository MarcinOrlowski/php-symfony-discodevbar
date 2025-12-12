<?php

declare(strict_types=1);

namespace MarcinOrlowski\DiscoDevBar\Listener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

/**
 * Injects DiscoDevBar into Symfony's exception debug pages in dev environment.
 *
 * The exception debug pages are standalone HTML pages that don't use Twig templates,
 * so we need to inject the devbar via response modification.
 */
#[AsEventListener(event: KernelEvents::RESPONSE, priority: -100)]
class ExceptionListener
{
    public function __construct(
        private readonly Environment $twig,
        private readonly KernelInterface $kernel,
    ) {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        // Only inject in dev environment
        if ($this->kernel->getEnvironment() !== 'dev') {
            return;
        }

        // Only process main requests
        if (!$event->isMainRequest()) {
            return;
        }

        $response = $event->getResponse();
        $content = $response->getContent();

        // Only process HTML responses
        if ($content === false || !str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            return;
        }

        // Check if this is Symfony's exception debug page
        // The exception page contains "Symfony Exception" and the specific CSS class "exception-message-wrapper"
        if (!str_contains($content, 'Symfony Exception') || !str_contains($content, 'exception-message-wrapper')) {
            return;
        }

        // Don't inject if devbar is already present (shouldn't happen, but be safe)
        if (str_contains($content, 'disco-devbar')) {
            return;
        }

        // Render the devbar template
        try {
            $devbarHtml = $this->twig->render('@DiscoDevBar/devbar.html.twig');
        } catch (\Throwable) {
            // If rendering fails, don't break the exception page
            return;
        }

        // Inject devbar CSS before </head>
        $cssLink = '<link rel="stylesheet" href="/bundles/discodevbar/devbar.css">';
        $content = str_replace('</head>', $cssLink . '</head>', $content);

        // Inject devbar after <body> tag (handle both <body> and <body ...>)
        $content = preg_replace(
            '/(<body[^>]*>)/i',
            '$1' . $devbarHtml,
            $content,
            1
        );

        // preg_replace returns null on error
        if ($content === null) {
            return;
        }

        // Add extra padding to the exception page header to avoid overlap with devbar
        $extraStyle = '<style>.sf-error-header { margin-top: 40px; }</style>';
        $content = str_replace('</head>', $extraStyle . '</head>', $content);

        $response->setContent($content);
    }
}

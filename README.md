```ascii
 █▀▀▄  ▀                     █▀▀▄           █▀▀▄
 █  █ ▀█  ▄▀▀▄ ▄▀▀▄ ▄▀▀▄     █  █ ▄▀▀▄ █  █ █▀▀▄ ▄▀▀▄ █▄▀
 █  █  █   ▀▄  █    █  █     █  █ █▀▀  █  █ █  █  ▄▄█ █
 █▄▄▀ ▄█▄ ▀▄▄▀ ▀▄▄▀ ▀▄▄▀     █▄▄▀ ▀▄▄▀ ▀▄▀  █▄▄▀ ▀▄▄▀ █
 
   Customizable developer toolbar for Symfony projects
```

# Welcome!

Development toolbar/banner for Symfony worktree-based workflows. Displays project information, links
to tools, and ticket details in development environment.

## Features

- Widget-based configuration system via YAML
- Displays milestone, PR, and ticket information
- Quick links to admin panel, phpMyAdmin, Mailpit
- Customizable icons, text, and links
- Only loads in development environment
- Zero production overhead

## Requirements

- PHP 8.1 or higher
- Symfony 6.4+ or 7.0+

## Installation

Install via Composer:

```bash
composer require marcinorlowski/symfony-discodevbar --dev
```

Register the bundle in `config/bundles.php`:

```php
return [
    // ... other bundles
    MarcinOrlowski\DiscoDevBar\DiscoDevBarBundle::class => ['dev' => true],
];
```

Install bundle assets:

```bash
php bin/console assets:install --symlink
```

## Configuration

Create a configuration file in your project root with widget configuration. The bundle will automatically
detect and load the first file found (in order of preference):

- `.disco-devbar.yaml` (recommended)
- `.disco-devbar.yml`

Example configuration:

```yaml
widgets:
  left:
    - icon: "fa-flag-checkered"
      text: "1.0"
      url: "https://github.com/user/repo/issues?q=milestone%3A1.0"
      target: "_blank"
      title: "Open Milestone Issues"

  right:
    - icon: "fa-globe"
      url: "/"
      title: "Go to Homepage"
    - icon: "fa-database"
      url: "http://localhost:8080"
      target: "_blank"
      title: "Open phpMyAdmin"
```

### Widget Properties

| Property |   Type   | Required | Description                                                                    |
|----------|:--------:|:--------:|--------------------------------------------------------------------------------|
| `icon`*  | `string` |          | Optional Font Awesome icon class (e.g., `fa-bug`).                             |
| `text`*  | `string` |          | Optional widget label to display (e.g., `Mailpit`).                            |
| `url`    | `string` | required | Link URL to redirect to once widget is clicked.                                |
| `target` | `string` |          | Link target (e.g., `_blank`). Default: no target                               |
| `title`  | `string` |          | Tooltip text. If not given, `url` is shown.                                    |
| `expand` |  `bool`  |          | Set to `true` to make widget expand and fill available space. Default `false`. |

*) Either `icon` or `text` must be provided or exception will be thrown.

## Usage

Include the devbar template in your base layout:

```twig
{% if app.environment == 'dev' %}
    {% include '@DiscoDevBar/devbar.html.twig' %}
{% endif %}
```

## Customization

### Custom CSS

The bundle includes default styling. To customize, override the CSS after importing bundle assets or
create your own styles targeting `.disco-devbar` classes.

### Custom Template

Override the default template by creating:
`templates/bundles/DiscoDevBarBundle/devbar.html.twig`

## License

- Written and copyrighted &copy;2025 by Marcin Orlowski <mail (#) marcinorlowski (.) com>
- DiscoDevBar is open-source software licensed under
  the [MIT license](http://opensource.org/licenses/MIT)

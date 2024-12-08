# This is my package filament-latex

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thethunderturner/filament-latex.svg?style=flat-square)](https://packagist.org/packages/thethunderturner/filament-latex)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/thethunderturner/filament-latex/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/thethunderturner/filament-latex/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/thethunderturner/filament-latex/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/thethunderturner/filament-latex/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/thethunderturner/filament-latex.svg?style=flat-square)](https://packagist.org/packages/thethunderturner/filament-latex)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

Before you start, make sure you have `textlive-full` or `textlive-base` installed on your system. At the moment the plugin is available only on Unix systems (Linux/MacOS). <br>
You can install `textlive` by running the following command:
```bash
sudo apt-get install texlive-full # for debian based systems
sudo pacman -S texlive-full # for arch based systems
brew install texlive-full # for MacOS
```
After you have installed `textlive`, find where the `pdflatex` binary is located by running:
```bash
which pdflatex
```
Copy and paste the path on the plugin configuration file. <br>
You can install the package via composer:
```bash
composer require thethunderturner/filament-latex
```

Publish the svg assets with:
```bash
php artisan vendor:publish --tag="filament-latex-svg"
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-latex-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-latex-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-latex-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentLatex = new TheThunderTurner\FilamentLatex();
echo $filamentLatex->echoPhrase('Hello, TheThunderTurner!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Matthaios Biskas](https://github.com/thethunderturner)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

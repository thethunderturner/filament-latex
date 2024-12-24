# Filament LaTeX

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thethunderturner/filament-latex.svg?style=flat-square)](https://packagist.org/packages/thethunderturner/filament-latex)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/thethunderturner/filament-latex/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/thethunderturner/filament-latex/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Fix PHP Code Styling](https://github.com/thethunderturner/filament-latex/actions/workflows/fix-php-code-styling.yml/badge.svg)](https://github.com/thethunderturner/filament-latex/actions/workflows/fix-php-code-styling.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/thethunderturner/filament-latex.svg?style=flat-square)](https://packagist.org/packages/thethunderturner/filament-latex)

## 🚀 Table of Contents
- [Demo](#demo)
- [Installation](#installation)
  - [Compiler Installation](#compiler-installation)
  - [Package Installation](#package-installation)
- [Usage](#package-usage)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [License](#license)

## Demo

Filament LaTeX is a powerful package that allows you to generate PDFs from LaTeX templates. The plugin is still in development, but the basic functionality is implemented.
<div style="display: flex; align-items: center; justify-content: center;">
    <img src="https://github.com/thethunderturner/filament-latex/blob/3.x/assets/filament-latex.png" alt="Filament LaTeX" style="margin-right: 10px; width: 45%;">
    <img src="https://github.com/thethunderturner/filament-latex/blob/3.x/assets/filament-latex-upload.png" alt="Filament LaTeX Upload" style="width: 45%;">
</div>

## Installation
> [!IMPORTANT]
> This branch is only compatible with Filament v3. If you are using Filament v4, please switch to branch 4.x.

### Compiler Installation

Before you start, make sure you have `texlive-full` or `texlive-base` installed on your system. You can install it on an Unix based system (Linux/MacOS) by running:
```bash
sudo apt-get install texlive-full # for debian based systems
sudo pacman -S texlive-full # for arch based systems
brew install texlive-full # for MacOS
```
If you are on Windows then please visit the [TeX Live website](https://tug.org/texlive/windows.html) and follow the instructions. \
After you have installed `texlive`, find where the `pdflatex` binary is located by running this in your console:
```bash
which pdflatex # for Unix based systems
where pdflatex # for Windows
```
Copy the path. You will later need to paste it in the plugin configuration file.

### Package Installation

You can install the package via composer:
```bash
composer require thethunderturner/filament-latex
```

With the install command, the package will automatically publish the migrations and the config file.
```bash
php artisan filament-latex:install
```

Optionally, you can publish them individually:

```bash
php artisan vendor:publish --tag="filament-latex-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-latex-config"
```
After publishing the path, make sure you replace the path of your `pdflatex` binary in the `config/filament-latex.php` file.

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-latex-views"
```

### Package Usage

You can use the package by adding it to the plugins list of your panel.
```php
->plugins([
    // ...
    FilamentLatexPlugin::make(),
]);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

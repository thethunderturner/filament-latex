# Changelog

All notable changes to `filament-latex` will be documented in this file.

## 1.1.1 - 2024-12-16

**Full Changelog**: https://github.com/thethunderturner/filament-latex/compare/v1.1.0...1.1.1

## v1.1.0 - 2024-12-15

### What's Changed

* Major feature: Adds file upload section by @thethunderturner in https://github.com/thethunderturner/filament-latex/pull/43

In short this release adds possibility to upload files
**Full Changelog**: https://github.com/thethunderturner/filament-latex/compare/1.0.0...v1.1.0

## v1.0.0 - 2024-12-12

This is the first big release for filament latex. You can generate different latex files, compile them and even download them. You can also preview the pdf! This is just a taste of what is possible, and more features are coming in the near future!

### What's Changed

* Feature/resources by @thethunderturner in https://github.com/thethunderturner/filament-latex/pull/1
* Feature/main test by @thethunderturner in https://github.com/thethunderturner/filament-latex/pull/2
* Feature: Textlive by @thethunderturner in https://github.com/thethunderturner/filament-latex/pull/3

### New Contributors

* @thethunderturner made their first contribution in https://github.com/thethunderturner/filament-latex/pull/1

**Full Changelog**: https://github.com/thethunderturner/filament-latex/commits/1.0.0

## 0.0.7 - 12/12/2024

- Remove useless page
- Moved the pdf compilation from the download action to the compile action
- latex now compiles
- you can download pdf
- now we use pdflatex
- no more live preview
- you can preview the pdf on the right

## 0.0.6 - 12/12/2024

- Added border around the editor and preview
- Added file upload component (with no functionality)
- Added rounded and not rounded corners for the file upload and latex containers
- Added noted to the NOTES.md
- Creating a record, automatically creates a default .tex file
- Fixed the author component in the form
- Save content in the DB
- code mirror uses content record instead of a template text
- Added download pdf button
- Connected 2 header actions similar to the inline grouped toggle buttons.

## 0.0.5 - 07-12-2024

- Research on other compilers that support more latex packages and also allow for pdf generation
- latex-pdf template file
- No longer using page, uses resource instead
- Added schema, config
- You can have multiple collaborators and 1 author (who created the document)
- Fixed github actions that were failing
- Fixed navigation icon that was crashing the github actions

## 0.0.4 - 05-12-2024

- Fixed UI bugs (flickering when typing)

## 0.0.3 - 05-12-2024

- Can now write latex with codemirror
- UI bugs (WIP)

## 0.0.2 - 05-12-2024

- Initial release
- Basic functionality

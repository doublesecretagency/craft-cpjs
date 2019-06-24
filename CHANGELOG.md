# Changelog

## 2.2.0 - 2019-06-24

### Added
- File path now includes proper support for [environmental values](https://docs.craftcms.com/v3/config/environments.html).

## 2.1.0 - 2018-01-01

### Added
- Custom JS now loads _after_ the default Craft JS.

### Changed
- Refactored to make better use of Asset Bundles.
- Refactored to load custom JS just before template loads.

## 2.0.1 - 2017-12-30

### Changed
- Updated minimum required version of Craft.
- Now references `hasCpSettings` from PHP instead of Composer.

## 2.0.0 - 2017-11-29

### Added
- Craft 3 compatibility.

## 1.1.0 - 2015-11-28

### Added
- Craft 2.5 compatibility.

## 1.0.5 - 2014-12-20

### Changed
- Formatted `additionalJs` field using [CodeMirror](http://codemirror.net/).

## 1.0.4 - 2014-08-22

### Changed
- Removed useless error message.

## 1.0.3 - 2014-08-10

### Added
- Formatted `additionalJs` field to nicely display code snippets.

## 1.0.2 - 2014-08-07

### Changed
- Improved error messaging.

## 1.0.1 - 2014-07-15

### Added
- Added cache busting for file-based JS.

## 1.0.0 - 2014-06-18

Initial release.

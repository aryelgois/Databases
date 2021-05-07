# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html)\*.

> \* Until 0.3.0, patch versions equal to 0 were omitted.


## [Unreleased]


## [0.7.2] - 2021-05-07

### Fixed
- Change require for [aryelgois/Medools] to lowercase


## [0.7.1] - 2018-06-01

### Fixed
- Fix database populate collation


## [0.7.0] - 2018-05-28

### Added
- Address sourcer script
- Address Makefile
- Global Makefile

### Changed
- Update dependencies
- Use `class` keyword in foreign classes
- Update Address documentation


## [0.6.0] - 2018-04-01

### Changed
- Update dependencies
- Update and rename [aryelgois/Medools] config file
- Sort Address source by State code

### Removed
- Implicit optional column in FullAddress from explicit list


## [0.5.0] - 2018-02-17

### Changed
- Update dependencies
- Update Address documentation
- Update Address source


## [0.4.0] - 2018-02-07

### Changed
- [aryelgois/yasql-php] version

### Fixed
- Escape backslashes
- Databases paths


## [0.3.2] - 2018-01-31

### Added
- Old FullAddress from [aryelgois/Medools], with auto stamp column

### Changed
- [aryelgois/Medools] version

### Fixed
- Vendor path
- Medools `DATABASE` constant


## [0.3.1] - 2018-01-06

### Fixed
- Composer keyword
- [aryelgois/yasql-php] version


## [0.3] - 2018-01-06

### Added
- Dependency [aryelgois/Medools]
- Configuration example for Medools
- Old Address Models from [aryelgois/Medools]
- Section about Medools on address documentation
- Composer keyword

### Changed
- Update README


## [0.2] - 2018-01-06

### Added
- Year 2018 in LICENSE

### Changed
- [aryelgois/yasql-php] version

### Fixed
- Databases config indentation
- Address source
- Refactor AddressPopulator
- DocBlocks
- [YASQL-PHP][aryelgois/yasql-php] composer scripts


## [0.1] - 2017-12-26

### Added
- Dependencies [aryelgois/yasql-php], [symfony/yaml]
- Databases config for [YASQL-PHP][aryelgois/yasql-php]

### Changed
- Convert address database to [YASQL][aryelgois/yasql]
- Convert address' brazilian source to [YAML]
- Rewrite Address to AddressPopulator
- README
- Address documentation
- Composer keywords

### Removed
- Whitespace
- Example

### Fixed
- DocBlocks


[Unreleased]: https://github.com/aryelgois/databases/compare/v0.7.2...develop
[0.7.2]: https://github.com/aryelgois/databases/compare/v0.7.1...v0.7.2
[0.7.1]: https://github.com/aryelgois/databases/compare/v0.7.0...v0.7.1
[0.7.0]: https://github.com/aryelgois/databases/compare/v0.6.0...v0.7.0
[0.6.0]: https://github.com/aryelgois/databases/compare/v0.5.0...v0.6.0
[0.5.0]: https://github.com/aryelgois/databases/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/aryelgois/databases/compare/v0.3.2...v0.4.0
[0.3.2]: https://github.com/aryelgois/databases/compare/v0.3.1...v0.3.2
[0.3.1]: https://github.com/aryelgois/databases/compare/v0.3...v0.3.1
[0.3]: https://github.com/aryelgois/databases/compare/v0.2...v0.3
[0.2]: https://github.com/aryelgois/databases/compare/v0.1...v0.2
[0.1]: https://github.com/aryelgois/databases/compare/e425e6a6b4887a6704e1aac64837f65e6bffca7f...v0.1

[aryelgois/Medools]: https://github.com/aryelgois/Medools
[aryelgois/yasql]: https://github.com/aryelgois/yasql
[aryelgois/yasql-php]: https://github.com/aryelgois/yasql-php
[symfony/yaml]: https://github.com/symfony/yaml

[YAML]: http://yaml.org/

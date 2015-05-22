# SmitePHP

A simple object-oriented approach to data in the Smite API (a game from Hi-Rez Studios).

For use within WordPress, consider using the [WP plugin from Hi-Rez](https://github.com/hirezstudios/smite-api-wp).

For more information about the SMITE API, check out the [official API documentation](https://docs.google.com/document/d/1OFS-3ocSx-1Rvg4afAnEHlT3917MAK_6eJTR6rzr-BM/).

## DevID and AuthKey Setup

A DevID and AuthKey are required in order to interact with the SMITE API.

To request a Developer ID and Authorization Key from Hi-Rez Studios, submit [this form](https://fs12.formsite.com/HiRez/form48/secure_index.html).

## Installation

```shell
$ composer require curse/smite-api
```

## Usage

```php
// Create api
$api = new Smite\API(DEV_ID, AUTH_KEY);

// returns objects by default
$api->preferFormat('array');
// will now return assoc arrays

// returns english language gods and item names by default
$api->useLanguage('es');
// use IETF language tag to select language

// get player info
$playerData = $api->request('/getplayer', $playerName);

// get info on silver 3 ladder in season 4
$ladderData = $api->request('/getleagueleaderboard', 'Conquest5v5', 'Silver3', 4);
```

## Contributing

1. Fork
2. `git clone`
3. `composer install`
4. Hack
5. Confirm (and write new) passing tests: `vendor/bin/phpunit tests`
6. Submit pull request

## License

Copyright 2015 Curse, Inc.

Free for you to use under LGPLv3. See [LICENSE](LICENSE) for an abundance words.

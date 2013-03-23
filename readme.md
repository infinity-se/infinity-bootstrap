### Infinity: Bootstrap ZF2 Module

Master: no-build

## Requirements

PHP 5.4+ (http://php.net/)

Composer (http://getcomposer.org/)


## Installation

Add the following to the repository and require arrays in your projects root
composer.json:

```json

    "repositories": [{
        "type": "package",
        "package": {
            "name": "jquery/jquery",
            "version": "1.9.1",
            "dist": {
                "url": "http://code.jquery.com/jquery-1.9.1.js",
                "type": "file"
            }
        }
    }],
    "require": {
        "jquery/jquery": "1.*",
        "infinity/infinity-bootstrap": "dev-master"
    }

```

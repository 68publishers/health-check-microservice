# Health check microservice

[![Total Downloads][ico-downloads]][link-downloads]
[![Latest Version on Packagist][ico-version]][link-packagist]

:heartpulse: Really simple [Nette](https://nette.org) application based on our package [68publishers/health-check](https://github.com/68publishers/health-check)

The application can be used as a standalone microservice or can be used directly from your main application.

## Standalone usage

Firstly simply download the package:

```bash
$ git clone https://github.com/68publishers/health-check-microservice.git
$ cd health-check-microservice
```

### Installation with included docker-compose

Install the application using the following script:

```bash
$ ./installer
```

Once the installation is successful you can edit the [ENV variables](#env-variables) in a file `.env`.

Then open a file `config/health_check_service_checkers.neon` and modify definitions of a service checkers according to own requirements.

Now open this URL in a browser `http://localhost:8888` respectively `http://localhost:8888/{HEALTH_CHECK_URL_PATH}`.

### Installation without Docker

Requirements:

- Webserver (Apache/Nginx)
- PHP 7.4
- Composer

```bash
$ composer install
$ cp .env.dist .env
$ cp config/health_check_service_checkers.neon.dist config/health_check_service_checkers.neon
```

Open the file `config/health_check_service_checkers.neon` and modify definitions of service checkers according to your own requirements.
You can pass parameters directly into the definition, of course. Usage of the ENV variable for service checkers is not necessary.

Also open the file `.env` where you can edit the [ENV variables](#env-variables). Variables for services like `postgres`, `redis` etc. can be removed if not used.

## Usage inside another application

Run following command in your application

```bash
$ composer require 68publishers/health-check-microservice
```

Create NEON file with service checker definitions like in the standalone usage and declare the ENV variables:

```bash
HEALTH_CHECK_URL_PATH=/health
HEALTH_CHECK_ARRAY_EXPORT_MODE=full
HEALTH_CHECK_TEMP_DIR={{PATH TO TEMP DIR IN THE MAIN APPLICATION}}
HEALTH_CHECK_LOG_DIR={{PATH TO LOG DIR IN THE MAIN APPLICATION}}
HEALTH_CHECK_SERVICE_CHECKERS_CONFIG={{PATH TO CONFIG FILE IN THE MAIN APPLICATION}}
```

Then modify `index.php` in the application:

```php
<?php

declare(strict_types=1);

use App\Bootstrap as AppBootstrap;
use SixtyEightPublishers\HealthCheckMicroservice\Bootstrap as HealthCheckBootstrap;
use Nette\Application\Application;

require __DIR__ . '/../vendor/autoload.php';

$configurator =  '/health' === $_SERVER['REQUEST_URI'] ? HealthCheckBootstrap::boot() : AppBootstrap::boot();

$configurator->createContainer()
	->getByType(Application::class)
	->run();
```

That's all, a health check endpoint will be accessible on the address `domain.com/health` :)
 
## ENV Variables

| Variable name | Type | Required | Default | Additional info |
| ------ | ------ | ------ | ------ | ------ |
| APP_DEBUG | Boolean | no | `1` | Enables dev/debug mode |
| TRUSTED_PROXIES | String\|CommaSeparatedList | no |  | Optional, IP or IPs separated by a comma. The range you can enter like 1.0.0.0/1 |
| HEALTH_CHECK_URL_PATH | String | no | `/` | Url path that is used as an endpoint e.g. `/` or `health` |
| HEALTH_CHECK_ARRAY_EXPORT_MODE | String | no | `simple` | `simple` or `full` - simplified or full response |
| HEALTH_CHECK_TEMP_DIR | String | no | `var` | Path to temp directory (relatively from the application root) |
| HEALTH_CHECK_LOG_DIR | String | no | `var/log` | Path to log directory (relatively from the application root) |
| HEALTH_CHECK_SERVICE_CHECKERS_CONFIG | String | no | `config/health_check_service_checkers.neon` | Path to a neon file with service checker definitions (relatively from the application root) |

## Contributing

Before committing any changes, don't forget to run

```bash
$ composer run php-cs-fixer
```

and

```bash
$ composer run tests
```

[ico-version]: https://img.shields.io/packagist/v/68publishers/health-check-microservice.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/68publishers/health-check-microservice.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/68publishers/health-check-microservice
[link-downloads]: https://packagist.org/packages/68publishers/health-check-microservice

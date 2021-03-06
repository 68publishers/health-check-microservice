<?php

declare(strict_types=1);

use SixtyEightPublishers\HealthCheckMicroservice\Bootstrap;
use Nette\Application\Application;

require __DIR__ . '/../vendor/autoload.php';

Bootstrap::boot()
	->createContainer()
	->getByType(Application::class)
	->run();

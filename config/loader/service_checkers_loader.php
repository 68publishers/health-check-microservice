<?php

declare(strict_types=1);

use Nette\DI\Config\Adapters\NeonAdapter;
use SixtyEightPublishers\HealthCheckMicroservice\Helper\RootDir;

$adapter = new NeonAdapter();
$serviceCheckers = $adapter->load(RootDir::path(env('HEALTH_CHECK_SERVICE_CHECKERS_CONFIG'))) ?? [];

return [
	'68publishers.health_check' => [
		'service_checkers' => $serviceCheckers,
	],
];

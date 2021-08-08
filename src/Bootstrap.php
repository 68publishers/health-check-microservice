<?php

declare(strict_types=1);

namespace SixtyEightPublishers\HealthCheckMicroservice;

use Tracy;
use Nette\StaticClass;
use Nette\Configurator;
use SixtyEightPublishers\Environment\Debug\EnvDetector;
use SixtyEightPublishers\Environment\Bootstrap\EnvBootstrap;
use SixtyEightPublishers\HealthCheckMicroservice\Helper\RootDir;

final class Bootstrap
{
	use StaticClass;

	/**
	 * @return \Nette\Configurator
	 */
	public static function boot(): Configurator
	{
		$configurator = new Configurator();

		EnvBootstrap::bootNetteConfigurator($configurator, [
			new EnvDetector(),
		]);

		if (class_exists(Tracy\Debugger::class)) {
			$configurator->enableTracy(RootDir::path(env('HEALTH_CHECK_LOG_DIR')));
		}

		$configurator->setTempDirectory(RootDir::path(env('HEALTH_CHECK_TEMP_DIR')));
		$configurator->addConfig(__DIR__ . '/../config/config.neon');
		$configurator->addConfig(__DIR__ . '/../config/loader/service_checkers_loader.php');

		return $configurator;
	}
}

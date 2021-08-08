<?php

declare(strict_types=1);

namespace SixtyEightPublishers\HealthCheckMicroservice\Helper;

use ReflectionClass;
use RuntimeException;
use Nette\StaticClass;
use ReflectionException;
use Composer\Autoload\ClassLoader;

final class RootDir
{
	use StaticClass;

	private static ?string $rootDir = NULL;

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public static function path(string $path): string
	{
		if (DIRECTORY_SEPARATOR !== $path[0]) {
			$path = DIRECTORY_SEPARATOR . $path;
		}

		return self::detect() . $path;
	}

	/**
	 * @return string
	 */
	public static function detect(): string
	{
		if (NULL !== self::$rootDir) {
			return self::$rootDir;
		}

		if (!class_exists(ClassLoader::class)) {
			throw new RuntimeException(sprintf(
				'Project root directory can\'t be detected because the class %s can\'t be found.',
				ClassLoader::class
			));
		}

		try {
			$reflection = new ReflectionClass(ClassLoader::class);

			return dirname($reflection->getFileName(), 3);
		} catch (ReflectionException $e) {
			throw new RuntimeException('Project root directory can\'t be detected.', 0, $e);
		}
	}
}

<?php

declare(strict_types=1);

namespace SixtyEightPublishers\HealthCheckMicroservice\Presenter;

use Nette\Http\IResponse as HttpResponse;
use SixtyEightPublishers\HealthCheck\HealthCheckerInterface;
use SixtyEightPublishers\HealthCheck\Bridge\Nette\UI\AbstractHealthCheckPresenter;

final class HealthCheckPresenter extends AbstractHealthCheckPresenter
{
	private string $arrayExportMode;

	/**
	 * @param string                                                   $arrayExportMode
	 * @param \SixtyEightPublishers\HealthCheck\HealthCheckerInterface $healthChecker
	 * @param \Nette\Http\IResponse                                    $response
	 */
	public function __construct(string $arrayExportMode, HealthCheckerInterface $healthChecker, HttpResponse $response)
	{
		parent::__construct($healthChecker, $response);

		$this->arrayExportMode = $arrayExportMode;
	}

	/**
	 * {@inheritDoc}
	 */
	protected function getArrayExportMode(): string
	{
		if (HealthCheckerInterface::ARRAY_EXPORT_MODE_FULL === $this->arrayExportMode) {
			return HealthCheckerInterface::ARRAY_EXPORT_MODE_FULL;
		}

		return HealthCheckerInterface::ARRAY_EXPORT_MODEL_SIMPLE;
	}
}

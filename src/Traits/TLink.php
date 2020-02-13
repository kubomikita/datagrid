<?php

declare(strict_types=1);

namespace Ublaboo\DataGrid\Traits;

use InvalidArgumentException;
use Nette;
use Nette\Application\UI\Component;
use Nette\Application\UI\InvalidLinkException;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;
use Ublaboo\DataGrid\Exception\DataGridHasToBeAttachedToPresenterComponentException;
use Ublaboo\DataGrid\Exception\DataGridLinkCreationException;
use UnexpectedValueException;

trait TLink
{

	/**
	 * @throws DataGridHasToBeAttachedToPresenterComponentException
	 * @throws InvalidArgumentException
	 * @throws DataGridLinkCreationException
	 * @throws UnexpectedValueException
	 */
	protected function createLink(
		DataGrid $grid,
		string $href,
		array $params
	): string
	{
		$targetComponent = $grid;

		$presenter = $grid->getPresenter();

		if (!$presenter instanceof Presenter) {
			throw new UnexpectedValueException(
				sprintf('%s needs instanceof %s', self::class, Presenter::class)
			);
		}

		if (strpos($href, ':') !== false) {
			return $presenter->link($href, $params);
		}

		for ($iteration = 0; $iteration < 10; $iteration++) {
			$targetComponent = $targetComponent->getParent();

			// Ak je multiplier v ceste snazi sa vytvarat link pre signal aj v nom, ale multiplier je final class
			if($targetComponent instanceof Nette\Application\UI\Multiplier){
				continue;
			}

			if (!$targetComponent instanceof Component) {
				throw $this->createHierarchyLookupException($grid, $href, $params);
			}

			try {
				$link = $targetComponent->link($href, $params);

			} catch (InvalidLinkException $e) {
				$link = false;
			} catch (Nette\InvalidArgumentException $e) {
				$link = false;
			}

			if (is_string($link)) {
				if (
					strpos($link, '#error') === 0 ||
					(strrpos($href, '!') !== false && strpos($link, '#') === 0) ||
					(in_array($presenter->invalidLinkMode, [Presenter::INVALID_LINK_WARNING, Presenter::INVALID_LINK_SILENT], true) && strpos($link, '#') === 0)
				) {
					continue; // Did not find signal handler
				}

				return $link; // Found signal handler!
			} else {
				continue; // Did not find signal handler
			}

			if ($targetComponent instanceof Presenter) {
				// Went the whole way up to the UI\Presenter and did not find any signal handler
				throw $this->createHierarchyLookupException($grid, $href, $params);
			}
		}

		// Went 10 steps up to the Presenter and did not find any signal handler
		throw $this->createHierarchyLookupException($grid, $href, $params);
	}


	private function createHierarchyLookupException(
		DataGrid $grid,
		string $href,
		array $params
	): DataGridLinkCreationException
	{
		$parent = $grid->getParent();
		$presenter = $grid->getPresenter();

		if ($parent === null || $presenter === null) {
			throw new UnexpectedValueException(
				sprintf('%s can not live withnout a parent component or presenter', self::class)
			);
		}

		$desiredHandler = get_class($parent) . '::handle' . ucfirst($href) . '()';

		return new DataGridLinkCreationException(
			'DataGrid could not create link "'
			. $href . '" - did not find any signal handler in componenet hierarchy from '
			. get_class($parent) . ' up to the '
			. get_class($presenter) . '. '
			. 'Try adding handler ' . $desiredHandler
		);
	}

}

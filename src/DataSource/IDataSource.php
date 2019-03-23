<?php declare(strict_types=1);

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\DataGrid\DataSource;

use Ublaboo\DataGrid\Utils\Sorting;

interface IDataSource
{

	/**
	 * Get count of data
	 */
	public function getCount(): int;

	/**
	 * Get the data
	 */
	public function getData(): array;

	/**
	 * Filter data
	 */
	public function filter(array $filters): self;

	/**
	 * Filter data - get one row
	 */
	public function filterOne(array $filter): self;

	/**
	 * Apply limit and offset on data
	 */
	public function limit(int $offset, int $limit): self;

	/**
	 * Sort data
	 */
	public function sort(Sorting $sorting): self;
}

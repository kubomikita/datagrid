<?php declare(strict_types=1);

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\DataGrid\Column;

use DateTime;
use Ublaboo\DataGrid\Exception\DataGridDateTimeHelperException;
use Ublaboo\DataGrid\Row;
use Ublaboo\DataGrid\Utils\DateTimeHelper;

class ColumnDateTime extends Column
{

	/**
	 * @var string
	 */
	protected $align = 'right';

	/**
	 * @var string
	 */
	protected $format = 'j. n. Y';


	/**
	 * @param  Row $row
	 */
	public function getColumnValue(Row $row): string
	{
		$value = parent::getColumnValue($row);

		if (!($value instanceof DateTime)) {
			/**
			 * Try to convert string to DateTime object
			 */
			try {
				$date = DateTimeHelper::tryConvertToDateTime($value);

				return $date->format($this->format);
			} catch (DataGridDateTimeHelperException $e) {
				/**
				 * Otherwise just return raw string
				 */
				return $value;
			}
		}

		return $value->format($this->format);
	}


	public function setFormat(string $format): self
	{
		$this->format = $format;

		return $this;
	}
}

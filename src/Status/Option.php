<?php

declare(strict_types=1);

namespace Ublaboo\DataGrid\Status;

use Ublaboo\DataGrid\Column\ColumnStatus;

class Option
{

	/**
	 * @var ColumnStatus
	 */
	protected $columnStatus;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var string
	 */
	protected $text;

	/**
	 * @var string|null
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $class = 'btn-success';

	/**
	 * @var string
	 */
	protected $classSecondary = 'btn btn-xs';

	/**
	 * @var string
	 */
	protected $classInDropdown = 'ajax dropdown-item';

	/**
	 * @var string|null
	 */
	protected $icon;

	/**
	 * @var string|null
	 */
	protected $iconSecondary;

	/**
	 * @param mixed $value
	 */
	public function __construct(ColumnStatus $columnStatus, $value, string $text)
	{
		$this->columnStatus = $columnStatus;
		$this->value = $value;
		$this->text = $text;
	}


	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}


	public function endOption(): ColumnStatus
	{
		return $this->columnStatus;
	}


	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}


	public function getTitle(): ?string
	{
		return $this->title;
	}


	public function setClass(string $class, ?string $classSecondary = null): self
	{
		$this->class = $class;

		if ($classSecondary !== null) {
			$this->classSecondary = $classSecondary;
		}

		return $this;
	}


	public function getClass(): ?string
	{
		return $this->class;
	}


	public function setClassSecondary(string $classSecondary): self
	{
		$this->classSecondary = $classSecondary;

		return $this;
	}


	public function getClassSecondary(): string
	{
		return $this->classSecondary;
	}


	public function setClassInDropdown(string $classInDropdown): self
	{
		$this->classInDropdown = $classInDropdown;

		return $this;
	}


	public function getClassInDropdown(): string
	{
		return $this->classInDropdown;
	}


	public function setIcon(string $icon): self
	{
		$this->icon = $icon;

		return $this;
	}


	public function getIcon(): ?string
	{
		return $this->icon;
	}


	public function setIconSecondary(string $iconSecondary): self
	{
		$this->iconSecondary = $iconSecondary;

		return $this;
	}


	public function getIconSecondary(): ?string
	{
		return $this->iconSecondary;
	}


	public function getText(): string
	{
		return $this->text;
	}
}

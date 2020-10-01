<?php

declare(strict_types=1);

/**
 * @copyright 2018, Maxence Lange <maxence@artificial-owl.com>
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @author Maxence Lange <maxence@artificial-owl.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCP\Dashboard\Model;

use JsonSerializable;

/**
 * Interface WidgetSetting
 *
 * Each setting that can be edited by a user should be defined in a
 * WidgetSetting.
 *
 * When using this framework, the settings interface is generated by the
 * Dashboard app.
 *
 * Each WidgetSetting must be generated and declared in the WidgetTemplate
 * during the setup of the widget in the IDashboardWidget using addSetting().
 *
 * @see IDashboardWidget::getWidgetTemplate
 * @see WidgetTemplate::addSetting
 *
 * @since 15.0.0
 *
 */
final class WidgetSetting implements JsonSerializable {
	public const TYPE_INPUT = 'input';
	public const TYPE_CHECKBOX = 'checkbox';


	/** @var string */
	private $name = '';

	/** @var string */
	private $title = '';

	/** @var string */
	private $type = '';

	/** @var string */
	private $placeholder = '';

	/** @var string */
	private $default = '';


	/**
	 * WidgetSetting constructor.
	 *
	 * @since 15.0.0
	 *
	 * @param string $type
	 */
	public function __construct(string $type = '') {
		$this->type = $type;
	}


	/**
	 * Set the name of the setting (full string, no space)
	 *
	 * @since 15.0.0
	 *
	 * @param string $name
	 *
	 * @return WidgetSetting
	 */
	public function setName(string $name): WidgetSetting {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the name of the setting
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}


	/**
	 * Set the title/display name of the setting.
	 *
	 * @since 15.0.0
	 *
	 * @param string $title
	 *
	 * @return WidgetSetting
	 */
	public function setTitle(string $title): WidgetSetting {
		$this->title = $title;

		return $this;
	}

	/**
	 * Get the title of the setting
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}


	/**
	 * Set the type of the setting (input, checkbox, ...)
	 *
	 * @since 15.0.0
	 *
	 * @param string $type
	 *
	 * @return WidgetSetting
	 */
	public function setType(string $type): WidgetSetting {
		$this->type = $type;

		return $this;
	}

	/**
	 * Get the type of the setting.
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}


	/**
	 * Set the placeholder (in case of type=input)
	 *
	 * @since 15.0.0
	 *
	 * @param string $text
	 *
	 * @return WidgetSetting
	 */
	public function setPlaceholder(string $text): WidgetSetting {
		$this->placeholder = $text;

		return $this;
	}

	/**
	 * Get the placeholder.
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getPlaceholder(): string {
		return $this->placeholder;
	}


	/**
	 * Set the default value of the setting.
	 *
	 * @since 15.0.0
	 *
	 * @param string $value
	 *
	 * @return WidgetSetting
	 */
	public function setDefault(string $value): WidgetSetting {
		$this->default = $value;

		return $this;
	}

	/**
	 * Get the default value.
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getDefault(): string {
		return $this->default;
	}


	/**
	 * @since 15.0.0
	 *
	 * @return array
	 */
	public function jsonSerialize() {
		return [
			'name' => $this->getName(),
			'title' => $this->getTitle(),
			'type' => $this->getTitle(),
			'default' => $this->getDefault(),
			'placeholder' => $this->getPlaceholder()
		];
	}
}

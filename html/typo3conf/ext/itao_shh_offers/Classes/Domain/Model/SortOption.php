<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Christian Hegner <christian.hegner@itao.de>, itao GmbH & Co. KG
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package itao_shh_offers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_ItaoShhOffers_Domain_Model_SortOption extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}
	
	/**
	 * field
	 * 
	 * @var string
	 */
	protected $field;
	
	/**
	 * Returns the field
	 *
	 * @return string $field
	 */
	public function getField() {
		return $this->field;
	}
	
	/**
	 * direction
	 * 
	 * @var string
	 */
	protected $direction;
	
	/**
	 * Returns the direction
	 *
	 * @return string $direction
	 */
	public function getDirection() {
		return $this->direction;
	}
}
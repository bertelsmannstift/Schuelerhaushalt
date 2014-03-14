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
class Tx_ItaoShhOffers_Domain_Model_FeUser extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * usergroup
	 * 
	 * @var int
	 */
	
	protected $usergroup;

	/**
	 * Returns the usergroup
	 *
	 * @return string $usergroup
	 */
	public function getUsergroup() {
		return $this->usergroup;
	}
	
	/**
	 * name
	 * 
	 * @var string
	 */
	
	protected $name;

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * firstName
	 * 
	 * @var string
	 */
	
	protected $firstName;

	/**
	 * Returns the firstName
	 *
	 * @return string $firstName
	 */
	public function getfirstName() {
		return $this->firstName;
	}
	/**
	 * lastName
	 * 
	 * @var string
	 */
	
	protected $lastName;

	/**
	 * Returns the lastName
	 *
	 * @return string $lastName
	 */
	public function getlastName() {
		return $this->lastName;
	}
	
}
?>
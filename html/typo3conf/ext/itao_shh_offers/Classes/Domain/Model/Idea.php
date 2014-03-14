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
class Tx_ItaoShhOffers_Domain_Model_Idea extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * class
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $class;

	/**
	 * offer
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_Offer
	 */
	protected $offer;

	/**
	 * feUser
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_FeUser
	 */
	protected $feUser;

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the class
	 *
	 * @return string $class
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * Sets the class
	 *
	 * @param string $class
	 * @return void
	 */
	public function setClass($class) {
		$this->class = $class;
	}

	/**
	 * Returns the feUser
	 *
	 * @return Tx_ItaoShhOffers_Domain_Model_FeUser $feUser
	 */
	public function getFeUser() {
		return $this->feUser;
	}

	/**
	 * Sets the feUser
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_FeUser $feUser
	 * @return void
	 */
	public function setFeUser(Tx_ItaoShhOffers_Domain_Model_FeUser $feUser) {
		$this->feUser = $feUser;
	}
	
	/**
	 * Returns the offer
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Offer $offer
	 * @return void
	 */
	public function getOffer() {
		return $this->offer;
	}
	
	/**
	 * Sets the offer
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Offer $offer
	 * @return void
	 */
	public function setOffer(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$this->offer = $offer;
	}

}
?>
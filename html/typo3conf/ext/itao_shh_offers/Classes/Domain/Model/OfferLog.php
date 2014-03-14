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
class Tx_ItaoShhOffers_Domain_Model_OfferLog extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * date
	 *
	 * @var DateTime
	 */
	protected $date;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * feUser
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_FeUser
	 */
	protected $feUser;

	/**
	 * cruserId
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_BeUser
	 */
	protected $cruserId;

	/**
	 * action
	 *
	 * @var integer
	 */
	protected $action;

	/**
	 * feGroups
	 *
	 * @var string
	 */
	protected $feGroups;
	
	/**
	 * Returns the date
	 *
	 * @return DateTime $date
	 */
	public function getDate() {
		return $this->date;
	}
	
	/**
	 * offer
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_Offer
	 */
	protected $offer;
	
	/**
	 * school
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_School
	 */
	protected $school;
	
	/**
	 * commune
	 *
	 * @var integer
	 */
	protected $commune;
	
	
	/**
	 * Returns the offer
	 *
	 * @return Tx_ItaoShhOffers_Domain_Model_Offer $offer
	 */
	public function getOffer() {
		return $this->offer;
	}

	/**
	 * Sets the date
	 *
	 * @param DateTime $date
	 * @return void
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
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
	 * Returns the cruserId
	 *
	 * @return Tx_ItaoShhOffers_Domain_Model_BeUser $cruserId
	 */
	public function getCruserId() {
		return $this->cruserId;
	}

	/**
	 * Sets the feUser
	 *
	 * @param integer $feUser
	 * @return void
	 */
	public function setFeUser($feUser) {
		$this->feUser = $feUser;
	}

	/**
	 * Returns the action
	 *
	 * @return integer $action
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * Sets the action
	 *
	 * @param integer $action
	 * @return void
	 */
	public function setAction($action) {
		$this->action = $action;
	}
	
	/**
	 * Sets the school
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_School $school
	 * @return void
	 */
	public function setSchool($school) {
		$this->school = $school;
	}
	
	/**
	 * Returns the school
	 *
	 * @return Tx_ItaoShhOffers_Domain_Model_School $school
	 */
	public function getSchool() {
		return $this->school;
	}
	
	/**
	 * Returns the commune
	 *
	 * @return integer $commune
	 */
	public function getCommune() {
		return $this->commune;
	}
	
	/**
	 * Sets the commune
	 *
	 * @param integer $commune
	 * @return void
	 */
	public function setCommune($commune) {
		$this->commune = $commune;
	}
	
	/**
	 * Returns the feGroups
	 *
	 * @return string $feGroups
	 */
	public function getFeGroups() {
		return $this->feGroups;
	}
	
	/**
	 * Sets the feGroups
	 *
	 * @param string $feGroups
	 * @return void
	 */
	public function setFeGroups($feGroups) {
		$this->feGroups = $feGroups;
	}

}
?>
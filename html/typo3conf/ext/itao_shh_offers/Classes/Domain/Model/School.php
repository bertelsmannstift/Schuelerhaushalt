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
class Tx_ItaoShhOffers_Domain_Model_School extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;
	
	/**
	 * Returns the title
	 *
	 * @var string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * refSchoolpage
	 *
	 * @var integer
	 */
	protected $refSchoolpage;
	
	/**
	 * refMyoffers
	 *
	 * @var integer
	 */
	protected $refMyoffers;
		
	
	/**
	 * Returns the refSchoolpage
	 *
	 * @var integer
	 */
	public function getRefSchoolpage() {
		return $this->refSchoolpage;
	}
	
	/**
	 * Returns the refMyoffers
	 *
	 * @var integer
	 */
	public function getRefMyoffers() {
		return $this->refMyoffers;
	}
	
	/**
	 * refStatus
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_Phase
	 */
	protected $refStatus;
	
	/**
	 * Returns the refStatus
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_Phase $refStatus
	 */
	public function getRefStatus() {
		return $this->refStatus;
	}
	
	/**
	 * refCommune
	 *
	 * @var integer
	 */
	protected $refCommune;
	
	/**
	 * Returns the refCommune
	 *
	 * @var integer
	 */
	public function getRefCommune() {
		return $this->refCommune;
	}
	
	
	/**
	 * refMpSchoolstartpage
	 *
	 * @var integer
	 */
	protected $refMpSchoolstartpage;
	
	/**
	 * Returns the refMpSchoolstartpage
	 *
	 * @var integer
	 */
	public function getRefMpSchoolstartpage() {
		return $this->refMpSchoolstartpage;
	}
	
	/**
	 * numberOfResultOffers
	 *
	 * @var integer
	 */
	protected $numberOfResultOffers;
	
	/**
	 * Returns the numberOfResultOffers
	 *
	 * @return integer $numberOfResultOffers
	 */
	public function getNumberOfResultOffers() {
		return $this->numberOfResultOffers;
	}
	
	/**
	 * offerAutomaticallyApproved
	 *
	 * @var boolean
	 */
	protected $offerAutomaticallyApproved;
	
	/**
	 * Returns the offerAutomaticallyApproved
	 *
	 * @return boolean $offerAutomaticallyApproved
	 */
	public function getOfferAutomaticallyApproved() {
		return $this->offerAutomaticallyApproved;
	}
	
	/**
	 * resultpage
	 *
	 * @var integer
	 */
	protected $resultpage;
	
	/**
	 * Returns the resultpage
	 *
	 * @var integer
	 */
	public function getResultpage() {
		return $this->resultpage;
	}
	
	/**
	 * refSortedoffers
	 *
	 * @var integer
	 */
	protected $refSortedoffers;
	
	/**
	 * Returns the refSortedoffers
	 *
	 * @var integer
	 */
	public function getRefSortedoffers() {
		return $this->refSortedoffers;
	}
}
?>
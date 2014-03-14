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
class Tx_ItaoShhOffers_Domain_Model_Commune extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * titel
	 *
	 * @var string
	 */
	protected $titel;
	
	/**
	 * Returns the titel
	 *
	 * @var string
	 */
	public function getTitel() {
		return $this->titel;
	}
	/**
	 * projectStart
	 *
	 * @var DateTime
	 */
	protected $projectStart;
	
	/**
	 * Returns the projectStart
	 *
	 * @var DateTime
	 */
	public function getProjectStart() {
		return $this->projectStart;
	}
	
	/**
	 * projectEnd
	 *
	 * @var DateTime
	 */
	protected $projectEnd;
	
	/**
	 * Returns the projectEnd
	 *
	 * @var DateTime
	 */
	public function getProjectEnd() {
		return $this->projectEnd;
	}
	
	/**
	 * refCommunepage
	 *
	 * @var integer
	 */
	protected $refCommunepage;
	
	/**
	 * Returns the refCommunepage
	 *
	 * @var integer
	 */
	public function getRefCommunepage() {
		return $this->refCommunepage;
	}
	
	/**
	 * isFinished
	 * 
	 * @var boolean 
	 */
	protected $isFinished;
	
	/**
	 * Returns the isFinished
	 * 
	 * @var boolean
	 */
	public function getIsFinished() {
		return $this->isFinished;
	}
	
	/**
	 * schools
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_School>
	 */
	protected $schools;
	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->schools = new Tx_Extbase_Persistence_ObjectStorage();
	}
	
	/**
	 * Adds a School
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_School $comment
	 * @return void
	 */
	public function addSchool(Tx_ItaoShhOffers_Domain_Model_School $comment) {
		$this->schools->attach($comment);
	}

	/**
	 * Removes a School
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_School $commentToRemove The School to be removed
	 * @return void
	 */
	public function removeSchool(Tx_ItaoShhOffers_Domain_Model_School $commentToRemove) {
		$this->schools->detach($commentToRemove);
	}

	/**
	 * Returns the schools
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_School> $schools
	 */
	public function getSchools() {
		return $this->schools;
	}

	/**
	 * Sets the schools
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_School> $schools
	 * @return void
	 */
	public function setSchools(Tx_Extbase_Persistence_ObjectStorage $schools) {
		$this->schools = $schools;
	}
	
	
}
?>
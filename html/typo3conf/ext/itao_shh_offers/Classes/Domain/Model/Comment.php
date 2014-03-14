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
class Tx_ItaoShhOffers_Domain_Model_Comment extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * text
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $text;

	/**
	 * date
	 *
	 * @var DateTime
	 */
	protected $date;

	/**
	 * log
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_CommentLog>
	 */
	protected $log;

	/**
	 * parent
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Comment>
	 */
	protected $parent;

	/**
	 * feUser
	 *
	 * @var integer
	 */
	protected $feUser;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->log = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->parent = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the text
	 *
	 * @return string $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Sets the text
	 *
	 * @param string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * Returns the date
	 *
	 * @return DateTime $date
	 */
	public function getDate() {
		return $this->date;
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
	 * Adds a CommentLog
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_CommentLog $log
	 * @return void
	 */
	public function addLog(Tx_ItaoShhOffers_Domain_Model_CommentLog $log) {
		$this->log->attach($log);
	}

	/**
	 * Removes a CommentLog
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_CommentLog $logToRemove The CommentLog to be removed
	 * @return void
	 */
	public function removeLog(Tx_ItaoShhOffers_Domain_Model_CommentLog $logToRemove) {
		$this->log->detach($logToRemove);
	}

	/**
	 * Returns the log
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_CommentLog> $log
	 */
	public function getLog() {
		return $this->log;
	}

	/**
	 * Sets the log
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_CommentLog> $log
	 * @return void
	 */
	public function setLog(Tx_Extbase_Persistence_ObjectStorage $log) {
		$this->log = $log;
	}

	/**
	 * Adds a Comment
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Comment $parent
	 * @return void
	 */
	public function addParent(Tx_ItaoShhOffers_Domain_Model_Comment $parent) {
		$this->parent->attach($parent);
	}

	/**
	 * Removes a Comment
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Comment $parentToRemove The Comment to be removed
	 * @return void
	 */
	public function removeParent(Tx_ItaoShhOffers_Domain_Model_Comment $parentToRemove) {
		$this->parent->detach($parentToRemove);
	}

	/**
	 * Returns the parent
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Comment> $parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Sets the parent
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Comment> $parent
	 * @return void
	 */
	public function setParent(Tx_Extbase_Persistence_ObjectStorage $parent) {
		$this->parent = $parent;
	}

	/**
	 * Returns the feUser
	 *
	 * @return integer $feUser
	 */
	public function getFeUser() {
		return $this->feUser;
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

}
?>
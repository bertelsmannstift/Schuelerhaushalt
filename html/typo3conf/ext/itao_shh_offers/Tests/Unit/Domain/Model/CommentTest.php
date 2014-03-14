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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_ItaoShhOffers_Domain_Model_Comment.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Vorschläge
 *
 * @author Christian Hegner <christian.hegner@itao.de>
 */
class Tx_ItaoShhOffers_Domain_Model_CommentTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_ItaoShhOffers_Domain_Model_Comment
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_ItaoShhOffers_Domain_Model_Comment();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTextReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTextForStringSetsText() { 
		$this->fixture->setText('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getText()
		);
	}
	
	/**
	 * @test
	 */
	public function getDateReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setDateForDateTimeSetsDate() { }
	
	/**
	 * @test
	 */
	public function getLogReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_CommentLog() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLog()
		);
	}

	/**
	 * @test
	 */
	public function setLogForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_CommentLogSetsLog() { 
		$log = new Tx_ItaoShhOffers_Domain_Model_CommentLog();
		$objectStorageHoldingExactlyOneLog = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLog->attach($log);
		$this->fixture->setLog($objectStorageHoldingExactlyOneLog);

		$this->assertSame(
			$objectStorageHoldingExactlyOneLog,
			$this->fixture->getLog()
		);
	}
	
	/**
	 * @test
	 */
	public function addLogToObjectStorageHoldingLog() {
		$log = new Tx_ItaoShhOffers_Domain_Model_CommentLog();
		$objectStorageHoldingExactlyOneLog = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLog->attach($log);
		$this->fixture->addLog($log);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneLog,
			$this->fixture->getLog()
		);
	}

	/**
	 * @test
	 */
	public function removeLogFromObjectStorageHoldingLog() {
		$log = new Tx_ItaoShhOffers_Domain_Model_CommentLog();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($log);
		$localObjectStorage->detach($log);
		$this->fixture->addLog($log);
		$this->fixture->removeLog($log);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getLog()
		);
	}
	
	/**
	 * @test
	 */
	public function getParentReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_Comment() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getParent()
		);
	}

	/**
	 * @test
	 */
	public function setParentForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_CommentSetsParent() { 
		$parent = new Tx_ItaoShhOffers_Domain_Model_Comment();
		$objectStorageHoldingExactlyOneParent = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneParent->attach($parent);
		$this->fixture->setParent($objectStorageHoldingExactlyOneParent);

		$this->assertSame(
			$objectStorageHoldingExactlyOneParent,
			$this->fixture->getParent()
		);
	}
	
	/**
	 * @test
	 */
	public function addParentToObjectStorageHoldingParent() {
		$parent = new Tx_ItaoShhOffers_Domain_Model_Comment();
		$objectStorageHoldingExactlyOneParent = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneParent->attach($parent);
		$this->fixture->addParent($parent);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneParent,
			$this->fixture->getParent()
		);
	}

	/**
	 * @test
	 */
	public function removeParentFromObjectStorageHoldingParent() {
		$parent = new Tx_ItaoShhOffers_Domain_Model_Comment();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($parent);
		$localObjectStorage->detach($parent);
		$this->fixture->addParent($parent);
		$this->fixture->removeParent($parent);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getParent()
		);
	}
	
	/**
	 * @test
	 */
	public function getFeUserReturnsInitialValueForTx_ItaoShhOffers_Domain_Model_FeUser() { }

	/**
	 * @test
	 */
	public function setFeUserForTx_ItaoShhOffers_Domain_Model_FeUserSetsFeUser() { }
	
}
?>
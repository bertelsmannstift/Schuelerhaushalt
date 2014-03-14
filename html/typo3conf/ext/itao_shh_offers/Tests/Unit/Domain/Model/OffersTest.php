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
 * Test case for class Tx_ItaoShhOffers_Domain_Model_Offers.
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
class Tx_ItaoShhOffers_Domain_Model_OffersTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_ItaoShhOffers_Domain_Model_Offers
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_ItaoShhOffers_Domain_Model_Offers();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getCostsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCostsForStringSetsCosts() { 
		$this->fixture->setCosts('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCosts()
		);
	}
	
	/**
	 * @test
	 */
	public function getCostsHelpReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getCostsHelp()
		);
	}

	/**
	 * @test
	 */
	public function setCostsHelpForBooleanSetsCostsHelp() { 
		$this->fixture->setCostsHelp(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getCostsHelp()
		);
	}
	
	/**
	 * @test
	 */
	public function getImagesReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImagesForStringSetsImages() { 
		$this->fixture->setImages('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImages()
		);
	}
	
	/**
	 * @test
	 */
	public function getSubmittedOnReturnsInitialValueForDate() { }

	/**
	 * @test
	 */
	public function setSubmittedOnForDateSetsSubmittedOn() { }
	
	/**
	 * @test
	 */
	public function getReleasedOnReturnsInitialValueForDate() { }

	/**
	 * @test
	 */
	public function setReleasedOnForDateSetsReleasedOn() { }
	
	/**
	 * @test
	 */
	public function getRejectedOnReturnsInitialValueForDate() { }

	/**
	 * @test
	 */
	public function setRejectedOnForDateSetsRejectedOn() { }
	
	/**
	 * @test
	 */
	public function getCommentedOnReturnsInitialValueForDate() { }

	/**
	 * @test
	 */
	public function setCommentedOnForDateSetsCommentedOn() { }
	
	/**
	 * @test
	 */
	public function getPromotedFromReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_Promoters() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPromotedFrom()
		);
	}

	/**
	 * @test
	 */
	public function setPromotedFromForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_PromotersSetsPromotedFrom() { 
		$promotedFrom = new Tx_ItaoShhOffers_Domain_Model_Promoters();
		$objectStorageHoldingExactlyOnePromotedFrom = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOnePromotedFrom->attach($promotedFrom);
		$this->fixture->setPromotedFrom($objectStorageHoldingExactlyOnePromotedFrom);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePromotedFrom,
			$this->fixture->getPromotedFrom()
		);
	}
	
	/**
	 * @test
	 */
	public function addPromotedFromToObjectStorageHoldingPromotedFrom() {
		$promotedFrom = new Tx_ItaoShhOffers_Domain_Model_Promoters();
		$objectStorageHoldingExactlyOnePromotedFrom = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOnePromotedFrom->attach($promotedFrom);
		$this->fixture->addPromotedFrom($promotedFrom);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePromotedFrom,
			$this->fixture->getPromotedFrom()
		);
	}

	/**
	 * @test
	 */
	public function removePromotedFromFromObjectStorageHoldingPromotedFrom() {
		$promotedFrom = new Tx_ItaoShhOffers_Domain_Model_Promoters();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($promotedFrom);
		$localObjectStorage->detach($promotedFrom);
		$this->fixture->addPromotedFrom($promotedFrom);
		$this->fixture->removePromotedFrom($promotedFrom);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPromotedFrom()
		);
	}
	
	/**
	 * @test
	 */
	public function getIdeaFromReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_Ideas() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getIdeaFrom()
		);
	}

	/**
	 * @test
	 */
	public function setIdeaFromForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_IdeasSetsIdeaFrom() { 
		$ideaFrom = new Tx_ItaoShhOffers_Domain_Model_Ideas();
		$objectStorageHoldingExactlyOneIdeaFrom = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneIdeaFrom->attach($ideaFrom);
		$this->fixture->setIdeaFrom($objectStorageHoldingExactlyOneIdeaFrom);

		$this->assertSame(
			$objectStorageHoldingExactlyOneIdeaFrom,
			$this->fixture->getIdeaFrom()
		);
	}
	
	/**
	 * @test
	 */
	public function addIdeaFromToObjectStorageHoldingIdeaFrom() {
		$ideaFrom = new Tx_ItaoShhOffers_Domain_Model_Ideas();
		$objectStorageHoldingExactlyOneIdeaFrom = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneIdeaFrom->attach($ideaFrom);
		$this->fixture->addIdeaFrom($ideaFrom);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneIdeaFrom,
			$this->fixture->getIdeaFrom()
		);
	}

	/**
	 * @test
	 */
	public function removeIdeaFromFromObjectStorageHoldingIdeaFrom() {
		$ideaFrom = new Tx_ItaoShhOffers_Domain_Model_Ideas();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($ideaFrom);
		$localObjectStorage->detach($ideaFrom);
		$this->fixture->addIdeaFrom($ideaFrom);
		$this->fixture->removeIdeaFrom($ideaFrom);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getIdeaFrom()
		);
	}
	
	/**
	 * @test
	 */
	public function getFeUserReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_FeUsers() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getFeUser()
		);
	}

	/**
	 * @test
	 */
	public function setFeUserForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_FeUsersSetsFeUser() { 
		$feUser = new Tx_ItaoShhOffers_Domain_Model_FeUsers();
		$objectStorageHoldingExactlyOneFeUser = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFeUser->attach($feUser);
		$this->fixture->setFeUser($objectStorageHoldingExactlyOneFeUser);

		$this->assertSame(
			$objectStorageHoldingExactlyOneFeUser,
			$this->fixture->getFeUser()
		);
	}
	
	/**
	 * @test
	 */
	public function addFeUserToObjectStorageHoldingFeUser() {
		$feUser = new Tx_ItaoShhOffers_Domain_Model_FeUsers();
		$objectStorageHoldingExactlyOneFeUser = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFeUser->attach($feUser);
		$this->fixture->addFeUser($feUser);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneFeUser,
			$this->fixture->getFeUser()
		);
	}

	/**
	 * @test
	 */
	public function removeFeUserFromObjectStorageHoldingFeUser() {
		$feUser = new Tx_ItaoShhOffers_Domain_Model_FeUsers();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($feUser);
		$localObjectStorage->detach($feUser);
		$this->fixture->addFeUser($feUser);
		$this->fixture->removeFeUser($feUser);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getFeUser()
		);
	}
	
}
?>
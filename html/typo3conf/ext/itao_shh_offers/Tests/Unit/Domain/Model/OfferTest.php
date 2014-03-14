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
 * Test case for class Tx_ItaoShhOffers_Domain_Model_Offer.
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
class Tx_ItaoShhOffers_Domain_Model_OfferTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_ItaoShhOffers_Domain_Model_Offer
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_ItaoShhOffers_Domain_Model_Offer();
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
	public function getPromotedFromReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_Promoter() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPromotedFrom()
		);
	}

	/**
	 * @test
	 */
	public function setPromotedFromForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_PromoterSetsPromotedFrom() { 
		$promotedFrom = new Tx_ItaoShhOffers_Domain_Model_Promoter();
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
		$promotedFrom = new Tx_ItaoShhOffers_Domain_Model_Promoter();
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
		$promotedFrom = new Tx_ItaoShhOffers_Domain_Model_Promoter();
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
	public function getIdeaFromReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_Idea() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getIdeaFrom()
		);
	}

	/**
	 * @test
	 */
	public function setIdeaFromForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_IdeaSetsIdeaFrom() { 
		$ideaFrom = new Tx_ItaoShhOffers_Domain_Model_Idea();
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
		$ideaFrom = new Tx_ItaoShhOffers_Domain_Model_Idea();
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
		$ideaFrom = new Tx_ItaoShhOffers_Domain_Model_Idea();
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
	public function getStatusReturnsInitialValueForTx_ItaoShhOffers_Domain_Model_Status() { }

	/**
	 * @test
	 */
	public function setStatusForTx_ItaoShhOffers_Domain_Model_StatusSetsStatus() { }
	
	/**
	 * @test
	 */
	public function getLikesDislikesReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_LikeDislike() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLikesDislikes()
		);
	}

	/**
	 * @test
	 */
	public function setLikesDislikesForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_LikeDislikeSetsLikesDislikes() { 
		$likesDislike = new Tx_ItaoShhOffers_Domain_Model_LikeDislike();
		$objectStorageHoldingExactlyOneLikesDislikes = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLikesDislikes->attach($likesDislike);
		$this->fixture->setLikesDislikes($objectStorageHoldingExactlyOneLikesDislikes);

		$this->assertSame(
			$objectStorageHoldingExactlyOneLikesDislikes,
			$this->fixture->getLikesDislikes()
		);
	}
	
	/**
	 * @test
	 */
	public function addLikesDislikeToObjectStorageHoldingLikesDislikes() {
		$likesDislike = new Tx_ItaoShhOffers_Domain_Model_LikeDislike();
		$objectStorageHoldingExactlyOneLikesDislike = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLikesDislike->attach($likesDislike);
		$this->fixture->addLikesDislike($likesDislike);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneLikesDislike,
			$this->fixture->getLikesDislikes()
		);
	}

	/**
	 * @test
	 */
	public function removeLikesDislikeFromObjectStorageHoldingLikesDislikes() {
		$likesDislike = new Tx_ItaoShhOffers_Domain_Model_LikeDislike();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($likesDislike);
		$localObjectStorage->detach($likesDislike);
		$this->fixture->addLikesDislike($likesDislike);
		$this->fixture->removeLikesDislike($likesDislike);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getLikesDislikes()
		);
	}
	
	/**
	 * @test
	 */
	public function getCommentsReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_Comment() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getComments()
		);
	}

	/**
	 * @test
	 */
	public function setCommentsForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_CommentSetsComments() { 
		$comment = new Tx_ItaoShhOffers_Domain_Model_Comment();
		$objectStorageHoldingExactlyOneComments = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneComments->attach($comment);
		$this->fixture->setComments($objectStorageHoldingExactlyOneComments);

		$this->assertSame(
			$objectStorageHoldingExactlyOneComments,
			$this->fixture->getComments()
		);
	}
	
	/**
	 * @test
	 */
	public function addCommentToObjectStorageHoldingComments() {
		$comment = new Tx_ItaoShhOffers_Domain_Model_Comment();
		$objectStorageHoldingExactlyOneComment = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneComment->attach($comment);
		$this->fixture->addComment($comment);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneComment,
			$this->fixture->getComments()
		);
	}

	/**
	 * @test
	 */
	public function removeCommentFromObjectStorageHoldingComments() {
		$comment = new Tx_ItaoShhOffers_Domain_Model_Comment();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($comment);
		$localObjectStorage->detach($comment);
		$this->fixture->addComment($comment);
		$this->fixture->removeComment($comment);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getComments()
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
	
	/**
	 * @test
	 */
	public function getLogReturnsInitialValueForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_OfferLog() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLog()
		);
	}

	/**
	 * @test
	 */
	public function setLogForObjectStorageContainingTx_ItaoShhOffers_Domain_Model_OfferLogSetsLog() { 
		$log = new Tx_ItaoShhOffers_Domain_Model_OfferLog();
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
		$log = new Tx_ItaoShhOffers_Domain_Model_OfferLog();
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
		$log = new Tx_ItaoShhOffers_Domain_Model_OfferLog();
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
	
}
?>
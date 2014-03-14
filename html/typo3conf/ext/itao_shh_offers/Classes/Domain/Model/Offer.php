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
class Tx_ItaoShhOffers_Domain_Model_Offer extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * description
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $description;

	/**
	 * costsStudent
	 *
	 * @var string
	 */
	protected $costsStudent;
	
	/**
	 * costs
	 *
	 * @var string
	 */
	protected $costs;

	/**
	 * costsHelp
	 *
	 * @var boolean
	 */
	protected $costsHelp = FALSE;
	
	/**
	 * edited
	 *
	 * @var boolean
	 */
	protected $edited = FALSE;
	
	/**
	 * costsEdited
	 *
	 * @var boolean
	 */
	protected $costsEdited = FALSE;

	/**
	 * images
	 *
	 * @var string
	 */
	protected $images;

	/**
	 * promotedFrom
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Promoter>
	 */
	protected $promotedFrom;

	/**
	 * ideaFrom
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Idea>
	 */
	protected $ideaFrom;

	/**
	 * status
	 *
	 * @var Tx_ItaoShhOffers_Domain_Model_Status
	 */
	protected $status;

	/**
	 * likesDislikes
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_LikeDislike>
	 */
	protected $likesDislikes;
	
	/**
	 * likes
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Like>
	 */
	protected $likes;
	
	/**
	 * dislikes
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Dislike>
	 */
	protected $dislikes;

	/**
	 * comments
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Comment>
	 */
	protected $comments;

//	/**
//	 * feUser
//	 *
//	 * @var Tx_ItaoShhOffers_Domain_Model_FeUser
//	 */
//	protected $feUser;
	
	/**
	 * feUser
	 *
	 * @var integer
	 */
	protected $feUser;
	
	/**
	 * internalId
	 *
	 * @var integer
	 */
	protected $internalId;
	
	
	
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
	 * crdate
	 *
	 * @var integer
	 */
	protected $crdate;

	/**
	 * log
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_OfferLog>
	 */
	protected $log;
//	
//	/**
//	 * lastLog
//	 *
//	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_OfferLog>
//	 */
//	protected $lastLog;

	/**
	 * numberOfLikes
	 * 
	 * @var integer 
	 */
	protected $numberOfLikes;
	
	/**
	 * numberOfDislikes
	 * 
	 * @var integer 
	 */
	protected $numberOfDislikes;
	
	/**
	 * votes
	 * 
	 * @var integer 
	 */
	protected $votes;
	
	/**
	 * childOffers
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Offer>
	 */
	protected $childOffers;
	
	/**
	 * newOffer
	 * 
	 * @var integer 
	 */
	protected $newOffer;
	
	
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
		$this->promotedFrom = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->ideaFrom = new Tx_Extbase_Persistence_ObjectStorage();
		
//		$this->likesDislikes = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->likes = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->dislikes = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->comments = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->log = new Tx_Extbase_Persistence_ObjectStorage();
	}

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
	 * Returns the costsStudent
	 *
	 * @return string $costsStudent
	 */
	public function getCostsStudent() {
		return $this->costsStudent;
	}
	
	/**
	 * Returns the Fixed
	 *
	 * @return string $costs
	 */
	public function getCosts() {
		return $this->costs;
	}

	/**
	 * Sets the costsStudent
	 *
	 * @param string $costsStudent
	 * @return void
	 */
	public function setCostsStudent($costsStudent) {
		$this->costsStudent = $costsStudent;
	}
	
	/**
	 * Sets the costs
	 *
	 * @param string $costs
	 * @return void
	 */
	public function setCosts($costs) {
		$this->costs = $costs;
	}

	/**
	 * Returns the costsHelp
	 *
	 * @return boolean $costsHelp
	 */
	public function getCostsHelp() {
		if($this->costsHelp){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Returns the edited
	 *
	 * @return boolean $edited
	 */
	public function getEdited() {
		if($this->edited){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Returns the costsEdited
	 *
	 * @return boolean $costsEdited
	 */
	public function getCostsEdited() {
		if($this->costsEdited){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Sets the costsHelp
	 *
	 * @param boolean $costsHelp
	 * @return void
	 */
	public function setCostsHelp($costsHelp) {
		$this->costsHelp = $costsHelp;
	}

	/**
	 * Sets the edited
	 *
	 * @param boolean $edited
	 * @return void
	 */
	public function setEdited($edited) {
		$this->edited = $edited;
	}
	
	/**
	 * Sets the costsEdited
	 *
	 * @param boolean $costsEdited
	 * @return void
	 */
	public function setCostsEdited($costsEdited) {
		$this->costsEdited = $costsEdited;
	}

	/**
	 * Returns the boolean state of costsHelp
	 *
	 * @return boolean
	 */
	public function isCostsHelp() {
		return $this->getCostsHelp();
	}
	
	/**
	 * Returns the boolean state of edited
	 *
	 * @return boolean
	 */
	public function isEdited() {
		return $this->getEdited();
	}
	
	/**
	 * Returns the boolean state of costsEdited
	 *
	 * @return boolean
	 */
	public function isCostsEdited() {
		return $this->getCostsEdited();
	}

	/**
	 * Returns the images
	 *
	 * @return string $images
	 */
	public function getImages() {
		if($this->images){
			return explode(',',$this->images);	
		} else {
			return FALSE;	
		}
	}

	/**
	 * Sets the images
	 *
	 * @param string $images
	 * @return void
	 */
	public function setImages($images) {
		$this->images = $images;
	}

	/**
	 * Adds a Promoter
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Promoter $promotedFrom
	 * @return void
	 */
	public function addPromotedFrom(Tx_ItaoShhOffers_Domain_Model_Promoter $promotedFrom) {
		$this->promotedFrom->attach($promotedFrom);
	}

	/**
	 * Removes a Promoter
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Promoter $promotedFromToRemove The Promoter to be removed
	 * @return void
	 */
	public function removePromotedFrom(Tx_ItaoShhOffers_Domain_Model_Promoter $promotedFromToRemove) {
		$this->promotedFrom->detach($promotedFromToRemove);
	}

	/**
	 * Returns the promotedFrom
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Promoter> $promotedFrom
	 */
	public function getPromotedFrom() {
		return $this->promotedFrom;
	}

	/**
	 * Sets the promotedFrom
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Promoter> $promotedFrom
	 * @return void
	 */
	public function setPromotedFrom(Tx_Extbase_Persistence_ObjectStorage $promotedFrom) {
		$this->promotedFrom = $promotedFrom;
	}

	/**
	 * Adds a Idea
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Idea $ideaFrom
	 * @return void
	 */
	public function addIdeaFrom(Tx_ItaoShhOffers_Domain_Model_Idea $ideaFrom) {
		$this->ideaFrom->attach($ideaFrom);
	}

	/**
	 * Removes a Idea
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Idea $ideaFromToRemove The Idea to be removed
	 * @return void
	 */
	public function removeIdeaFrom(Tx_ItaoShhOffers_Domain_Model_Idea $ideaFromToRemove) {
		$this->ideaFrom->detach($ideaFromToRemove);
	}

	/**
	 * Returns the ideaFrom
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Idea> $ideaFrom
	 */
	public function getIdeaFrom() {
		return $this->ideaFrom;
	}

	/**
	 * Sets the ideaFrom
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Idea> $ideaFrom
	 * @return void
	 */
	public function setIdeaFrom(Tx_Extbase_Persistence_ObjectStorage $ideaFrom) {
		$this->ideaFrom = $ideaFrom;
	}

	/**
	 * Returns the status
	 *
	 * @return Tx_ItaoShhOffers_Domain_Model_Status $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets the status
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Status $status
	 * @return void
	 */
	public function setStatus(Tx_ItaoShhOffers_Domain_Model_Status $status) {
		$this->status = $status;
	}

	/**
	 * Adds a LikeDislike
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_LikeDislike $likesDislike
	 * @return void
	 */
	public function addLikesDislike(Tx_ItaoShhOffers_Domain_Model_LikeDislike $likesDislike) {
		$this->likesDislikes->attach($likesDislike);
	}

	/**
	 * Removes a LikeDislike
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_LikeDislike $likesDislikeToRemove The LikeDislike to be removed
	 * @return void
	 */
	public function removeLikesDislike(Tx_ItaoShhOffers_Domain_Model_LikeDislike $likesDislikeToRemove) {
		$this->likesDislikes->detach($likesDislikeToRemove);
	}

	/**
	 * Returns the likesDislikes
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_LikeDislike> $likesDislikes
	 */
	public function getLikesDislikes() {
		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];
		foreach($this->likesDislikes as $key => $sorting){
			if($sorting->getFeUser() == $feUser){
				return $sorting;
			}
		}
		
		return FALSE;
	}
	
	/**
	 * Returns the actSorting
	 *
	 * @return integer
	 */
	public function getActSorting() {
		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];
		foreach($this->likes as $key => $sorting){
			if($sorting->getFeUser() == $feUser){
				return 1;
			}
		}
		
		foreach($this->dislikes as $key => $sorting){
			if($sorting->getFeUser() == $feUser){
				return 2;
			}
		}
		
		return FALSE;
	}
	
	/**
	 * returns the numberOfLikes
	 * 
	 * @return integer
	 */
	public function getNumberOfLikes(){
		$likes = 0;
		foreach($this->likesDislikes as $key => $sorting){
			if($sorting->getStatus() == 1){
				$likes++;
			}
		}
		return $likes;
	}
	
	/**
	 * returns the numberOfDislikes
	 * 
	 * @return integer
	 */
	public function getNumberOfDislikes(){
		$dislikes = 0;
		foreach($this->likesDislikes as $key => $sorting){
			if($sorting->getStatus() == 2){
				$dislikes++;
			}
		}
		return $dislikes;
	}
	
//	/**
//	 * returns the numberOfDislikes
//	 * 
//	 * @return integer
//	 */
//	public function getNumberOfDislikes(){
//		$dislikes = 0;
//		foreach($this->likesDislikes as $key => $sorting){
//			if($sorting->getStatus() == 2){
//				$dislikes++;
//			}
//		}
//		return $dislikes;
//	}
	
	/**
	 * Sets the likesDislikes
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_LikeDislike> $likesDislikes
	 * @return void
	 */
	public function setLikesDislikes(Tx_Extbase_Persistence_ObjectStorage $likesDislikes) {
		$this->likesDislikes = $likesDislikes;
	}

	/**
	 * Adds a Comment
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Comment $comment
	 * @return void
	 */
	public function addComment(Tx_ItaoShhOffers_Domain_Model_Comment $comment) {
		$this->comments->attach($comment);
	}

	/**
	 * Removes a Comment
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Comment $commentToRemove The Comment to be removed
	 * @return void
	 */
	public function removeComment(Tx_ItaoShhOffers_Domain_Model_Comment $commentToRemove) {
		$this->comments->detach($commentToRemove);
	}

	/**
	 * Returns the comments
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Comment> $comments
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * Sets the comments
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Comment> $comments
	 * @return void
	 */
	public function setComments(Tx_Extbase_Persistence_ObjectStorage $comments) {
		$this->comments = $comments;
	}

//	/**
//	 * Returns the feUser
//	 *
//	 * @return Tx_ItaoShhOffers_Domain_Model_FeUser $feUser
//	 */
//	public function getFeUser() {
//		return $this->feUser;
//	}
//
//	/**
//	 * Sets the feUser
//	 *
//	 * @param Tx_ItaoShhOffers_Domain_Model_FeUser $feUser
//	 * @return void
//	 */
//	public function setFeUser(Tx_ItaoShhOffers_Domain_Model_FeUser $feUser) {
//		$this->feUser = $feUser;
//	}

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
	
	/**
	 * Returns the internalId
	 *
	 * @return integer $internalId
	 */
	public function getInternalId() {
		return $this->internalId;
	}

	/**
	 * Sets the internalId
	 *
	 * @param integer $internalId
	 * @return void
	 */
	public function setInternalId($internalId) {
		$this->internalId = $internalId;
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
	 * Sets the school
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_School $school
	 * @return void
	 */
	public function setSchool(Tx_ItaoShhOffers_Domain_Model_School $school) {
		$this->school = $school;
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
	 * Adds a OfferLog
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_OfferLog $log
	 * @return void
	 */
	public function addLog(Tx_ItaoShhOffers_Domain_Model_OfferLog $log) {
		$this->log->attach($log);
	}

	/**
	 * Removes a OfferLog
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_OfferLog $logToRemove The OfferLog to be removed
	 * @return void
	 */
	public function removeLog(Tx_ItaoShhOffers_Domain_Model_OfferLog $logToRemove) {
		$this->log->detach($logToRemove);
	}

	/**
	 * Returns the log
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_OfferLog> $log
	 */
	public function getLog() {
//		$lastLog = end($this->log->toArray());
		
		return $this->log;
	}
	
	/**
	 * Returns the childOffers
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Offer> $childOffers
	 */
	public function getChildOffers() {
		return $this->childOffers;
	}
	
	/**
	 * Adds a ChildOffer
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Offer $childOffer
	 * @return void
	 */
	public function addChildOffers(Tx_ItaoShhOffers_Domain_Model_Offer $childOffer) {
		$this->childOffers->attach($childOffer);
	}
	
	/**
	 * Removes a ChildOffer
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Offer $childOffer
	 * @return void
	 */
	public function removeChildOffers(Tx_ItaoShhOffers_Domain_Model_Offer $childOffer) {
		$this->childOffers->detach($childOffer);
	}
	
	/**
	 * Sets the childOffers
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Offer> $childOffers
	 * @return void
	 */
	public function setChildOffers(Tx_Extbase_Persistence_ObjectStorage $childOffers) {
		$this->childOffers = $childOffers;
	}
	
	/**
	 * Returns the lastlog
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_OfferLog> $log
	 */
	public function getLastLog() {
//		$logArray = $this->log->toArray();
		$lastLog = end($this->log->toArray());
		return $lastLog;
	}

	/**
	 * Sets the log
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_OfferLog> $log
	 * @return void
	 */
	public function setLog(Tx_Extbase_Persistence_ObjectStorage $log) {
		$this->log = $log;
	}

	
	/**
	 * Adds a Like
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Like $like
	 * @return void
	 */
	public function addLikes(Tx_ItaoShhOffers_Domain_Model_Like $like) {
		$this->likes->attach($like);
	}
	
	/**
	 * Removes a Like
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Like $likeToRemove The like to be removed
	 * @return void
	 */
	public function removeLikes(Tx_ItaoShhOffers_Domain_Model_Like $likeToRemove) {
		$this->likes->detach($likeToRemove);
	}
	
	/**
	 * Returns the likes
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Like> $likes
	 */
	public function getLikes() {
		return $this->likes;
	}

	/**
	 * Sets the likes
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Like> $likes
	 * @return void
	 */
	public function setLikes(Tx_Extbase_Persistence_ObjectStorage $likes) {
		$this->likes = $likes;
	}
	
	/**
	 * Adds a Dislike
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Dislike $dislike
	 * @return void
	 */
	public function addDislikes(Tx_ItaoShhOffers_Domain_Model_Dislike $dislike) {
		$this->dislikes->attach($dislike);
	}
	
	/**
	 * Removes a Dislike
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Dislike $dislikeToRemove The dislike to be removed
	 * @return void
	 */
	public function removeDislikes(Tx_ItaoShhOffers_Domain_Model_Dislike $dislikeToRemove) {
		$this->dislikes->detach($dislikeToRemove);
	}
	
	/**
	 * Returns the dislikes
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Dislike> $dislikes
	 */
	public function getDislikes() {
		return $this->dislikes;
	}

	/**
	 * Sets the dislikes
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoShhOffers_Domain_Model_Dislike> $dislikes
	 * @return void
	 */
	public function setDislikes(Tx_Extbase_Persistence_ObjectStorage $dislikes) {
		$this->dislikes = $dislikes;
	}
	
	/**
	 * Returns the crdate
	 *
	 * @return integer $crdate
	 */
	public function getCrdate() {
		return $this->crdate;
	}
	
	/**
	 * Returns the votes
	 * 
	 * @return integer $votes
	 */
	function getVotes() {
		return $this->votes;
	}
	
	/**
	 * Returns the newOffer
	 *
	 * @return integer $newOffer
	 */
	public function getNewOffer() {
		return $this->newOffer;
	}

	/**
	 * Sets the newOffer
	 *
	 * @param integer $newOffer
	 * @return void
	 */
	public function setNewOffer($newOffer) {
		$this->newOffer = $newOffer;
	}		
	
}
?>
<?php

/* * *************************************************************
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
 * ************************************************************* */

/**
 *
 *
 * @package itao_shh_offers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_ItaoShhOffers_Controller_OfferController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * offerRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_OfferRepository
	 */
	protected $offerRepository;

	/**
	 * CommentRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_CommentRepository
	 */
	protected $commentRepository;

	/**
	 * IdeaRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_IdeaRepository
	 */
	protected $ideaRepository;

	/**
	 * LikeRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_LikeRepository
	 */
	protected $likeRepository;

	/**
	 * DislikeRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_DislikeRepository
	 */
	protected $DislikeRepository;

	/**
	 * PromoterRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_PromoterRepository
	 */
	protected $promoterRepository;

	/**
	 * StatusRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_StatusRepository
	 */
	protected $statusRepository;

	/**
	 * SchoolRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_SchoolRepository
	 */
	protected $schoolRepository;

	/**
	 * PageRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_PageRepository
	 */
	protected $pageRepository;

	/**
	 * OfferLogRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_OfferLogRepository
	 */
	protected $offerLogRepository;

	/**
	 * SortRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_SortRepository
	 */
	protected $sortRepository;

	/**
	 * FilterRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_FilterRepository
	 */
	protected $filterRepository;

	/**
	 * PhaseRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_PhaseRepository
	 */
	protected $phaseRepository;

	/**
	 * CommuneRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_CommuneRepository
	 */
	protected $communeRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->commentRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_CommentRepository');
		$this->ideaRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_IdeaRepository');
		$this->dislikeRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_DislikeRepository');
		$this->likeRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_LikeRepository');
		$this->promoterRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_PromoterRepository');
		$this->statusRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_StatusRepository');
		$this->pageRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_PageRepository');
		$this->schoolRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_SchoolRepository');
		$this->offerLogRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_OfferLogRepository');
		$this->sortRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_SortRepository');
		$this->filterRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_FilterRepository');
		$this->phaseRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_PhaseRepository');
		$this->communeRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_CommuneRepository');
	}

	/**
	 * injectOfferRepository
	 *
	 * @param Tx_ItaoShhOffers_Domain_Repository_OfferRepository $offerRepository
	 * @return void
	 */
	public function injectOfferRepository(Tx_ItaoShhOffers_Domain_Repository_OfferRepository $offerRepository) {
		$this->offerRepository = $offerRepository;
	}

	/**
	 * action show
	 *
	 * @param $offer
	 * @return void
	 */
	public function showAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$args = $this->request->getArguments();
		$rights = $this->getUserRights();

		$school = $offer->getSchool();
		$offerUid = $offer->getUid();
		$topOffers = $this->offerRepository->findTopXInSchool($school, 2, $school->getNumberOfResultOffers());

		$cycle = 0;
		$ranking = 0;
		foreach ($topOffers as $topOffer) {
			$cycle++;
			if ($offerUid == $topOffer->getUid()) {
				$ranking = $cycle;
			}
		}
		if ($school) {
			$phase = $school->getRefStatus();
		}

		// Offers which could be a ParentOffer
		$possibleParents = $this->offerRepository->findPossibleParents($school);

		if ($phase->getUid() == $this->settings['phases']['result']) {
			unset($rights['editOffer']);
			unset($rights['defineChildOffers']);
			$this->view->assign('ranking', $ranking);
		}

		$this->view->assign('actSorting', $args['actSorting']);
		$this->view->assign('offer', $offer);
		$this->view->assign('school', $school);
		$this->view->assign('possibleParents', $possibleParents);
		$this->view->assign('rights', $rights);
	}

	/**
	 * action becomeChildOf
	 * remove or add a Child to an Offer
	 *
	 * @param $offer Tx_ItaoShhOffers_Domain_Model_Offer
	 * @return void
	 */
	public function becomeChildOfAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$args = $this->request->getArguments();
		$childOffer = $this->offerRepository->findByUid($args['childOffer']);

		if ($args['removeChild']) {
			$offer->removeChildOffers($childOffer);
			$this->redirect('show', NULL, NULL, array('offer' => $offer), NULL, 0, 303);
		} else {
			$offer->addChildOffers($childOffer);
		}
	}

	/**
	 * Returns an Array with From-Informations
	 * 
	 * @param Array $ideaFrom
	 * @return Array
	 */
	public function getFromArray($ideaFrom) {
		$fromArray = array();
		$fromArray['names'] = explode(',', $ideaFrom['names']);
		$fromArray['classes'] = explode(',', $ideaFrom['classes']);

		$from = array();
		// build a new Array
		foreach ($fromArray['names'] as $key => $name) {
			$from[$key]['name'] = $name;
			$from[$key]['class'] = $fromArray['classes'][$key];
		}

		return $from;
	}

	/**
	 * action new
	 *
	 * @param $newOffer
	 * @dontvalidate $newOffer
	 * @return void
	 */
	public function newAction(Tx_ItaoShhOffers_Domain_Model_Offer $newOffer = NULL) {

		$args = $this->request->getArguments();
		if ($args['offer']) {
			$newOffer = $this->offerRepository->findByUid($args['offer']);
			if ($newOffer->getNewOffer()) {
				$this->view->assign('feedback', TRUE);
				$newOffer->setNewOffer(0);
			}
		}

		if ($newOffer == NULL) { // workaround for fluid bug ##5636
			$newOffer = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_Offer');
		}

		// get the commaseperatet strings for name and class
		$ideasFrom = $this->getFromArray($args['ideaFrom']);
		$promotedFrom = $this->getFromArray($args['promotedFrom']);


		// assign Data to View
		if ($ideasFrom) {
			$this->view->assign('ideasFrom', $ideasFrom);
		}

		if ($promotedFrom) {
			$this->view->assign('promotedFrom', $promotedFrom);
		}

		$this->getSchool($GLOBALS['TSFE']->id);
		$this->view->assign('school', $this->school);
		$this->view->assign('newOffer', $newOffer);
		$this->view->assign('rights', $this->getUserRights());
	}

	/**
	 * action preview
	 * 
	 * loads a Preview of an new Offer via JavaScript
	 * opens in Lightbox (iframe)
	 * 
	 * @param Array $args
	 * @return void
	 */
	public function previewAction() {
		$args = $this->request->getArguments();
		if ($args['feedback']) {
			$this->view->assign('feedback', TRUE);
			$this->view->assign('myOffersPageUid', $args['myOffersPageUid']);

			$this->getSchool($args['myOffersPageUid']);
			if ($this->school) {
				if ($this->school->getOfferAutomaticallyApproved()) {
					$this->view->assign('redirectToMyOffers', 1);
				}
			}
		}
	}

	/**
	 * action create
	 *
	 * @param $newOffer
	 * @return void
	 * @dontverifyrequesthash
	 */
	public function createAction(Tx_ItaoShhOffers_Domain_Model_Offer $newOffer) {
		// uploads?
		$imageString = '';
		$args = $this->request->getArguments();
		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];
		$images = $_FILES['tx_itaoshhoffers_offers']['name']['newOffer'];

		if ($images) {
			$basicFileFunctions = t3lib_div::makeInstance('t3lib_basicFileFunctions');
			foreach ($images as $key => $image) {
				if ($image) {
					$fileName = $basicFileFunctions->getUniqueName(
							$image, t3lib_div::getFileAbsFileName('uploads/tx_itaoshhoffers/')
					);
					t3lib_div::upload_copy_move(
							$_FILES['tx_itaoshhoffers_offers']['tmp_name']['newOffer'][$key], $fileName
					);
					$image = basename($fileName);

					if ($imageString != '') {
						$imageString.=',' . $image;
					} else {
						$imageString.=$image;
					}
				}
			}
			if ($imageString) {
				$newOffer->setImages($imageString);
			}
		}

		$newOffer->setPid($this->settings['storagePid']);
		$newOffer->setFeUser($feUser);

		//copy costs
		$newOffer->setCostsStudent($newOffer->getCosts());

		// Link with School
		// get School rekusiv
		$school = $newOffer->getSchool();
		$newOffer->setSchool($school);
		$newOffer->setCommune($school->getRefCommune());

		// Write Log
		$log = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_OfferLog');
		$log->setFeUser($feUser);
		$log->setDate(time());
		$log->setAction($this->settings['actions']['submitted']['uid']);
		$log->setSchool($school);
		$log->setCommune($school->getRefCommune());
		$log->setDescription('offer submitted');

		// Vorschlag direkt freigeben?
		if ($school->getOfferAutomaticallyApproved()) {
			// approve directly
			$newOffer->setStatus($this->statusRepository->findByUid(2));
		} else {
			// must approved by fe_user
			$newOffer->setStatus($this->statusRepository->findByUid(1));
			// Message shows free for all after approve
			$log->setFeGroups($this->settings['actions']['submitted']['groups']);
		}

		$newOffer->addLog($log);

		$lastOffer = $this->offerRepository->getLastOfferFromSchool($school->getUid());
		if ($lastOffer) {
			$newOffer->setInternalId($lastOffer->getInternalId() + 1);
		} else {
			$newOffer->setInternalId(1);
		}

		$this->offerRepository->add($newOffer);
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();

		// create IdeaFrom
		// get the commaseperatet strings for name and class
		$ideasFrom = $this->getFromArray($args['ideaFrom']);

		foreach ($ideasFrom as $key => $ideaFrom) {
			$newIdeaFrom = t3lib_div::makeInstance('tx_itaoshhoffers_domain_model_idea');
			$newIdeaFrom->setName($ideaFrom['name']);
			$newIdeaFrom->setClass($ideaFrom['class']);

			$newOffer->addIdeaFrom($newIdeaFrom);
		}

		// create IdeaFrom
		// get the commaseperatet strings for name and class
		$promotedFrom = $this->getFromArray($args['promotedFrom']);

		foreach ($promotedFrom as $key => $promoter) {
			if ($promoter['name'] != '' || $promoter['class'] != '') {
				$newPromotedFrom = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_Promoter');
				$newPromotedFrom->setName($promoter['name']);
				$newPromotedFrom->setClass($promoter['class']);

				$newOffer->addPromotedFrom($newPromotedFrom);
			}
		}

		if ($school) {
			if ($school->getOfferAutomaticallyApproved()) {
				$this->redirect(NULL, NULL, NULL, array('feedback' => TRUE, 'offer' => $newOffer), $school->getRefMyoffers(), 0, 303);
			} else {
				$this->redirect('new', NULL, NULL, array('feedback' => TRUE, 'offer' => $newOffer));
			}
		}
	}

	/**
	 * action schools
	 *
	 * @return void
	 */
	public function schoolsAction() {
		$commune = $GLOBALS['TSFE']->fe_user->user['tx_itaoshhmanager_ssh_ref_commune'];
		$schools = $this->schoolRepository->findByRefCommune($commune);

		$this->view->assign("schools", $schools);
		$this->view->assign("rights", $this->getUserRights());

		$actSchool = $_POST['tx_itaoshhoffers_offers']['school'];

		if ($actSchool == NULL) {
			// Schule finden (rekusiv)
			$this->getSchool($GLOBALS['TSFE']->id);
			if ($this->school) {
				$actSchool = $this->school->getUid();
			} else {
				$actSchool = 'ALL';
			}
		}
		$this->view->assign("actSchool", $actSchool);
	}

	/**
	 * action communes
	 *
	 * @return void
	 */
	public function communesAction() {
		$communes = $this->communeRepository->findAll();

		$this->view->assign("communes", $communes);
	}

	/**
	 * action newOffers
	 *
	 * @return void
	 */
	public function newOffersAction() {

		$args = $this->request->getArguments();

		$filter = $this->getFilterValues($args);
		$orderings = $this->getOrderings($args);

		switch ($this->settings['mode']) {
			case 'FIXED':
				$school = $this->settings['school'];
				break;
			case 'AUTO':
				$this->school;
				// Schule finden (rekusiv)
				$this->getSchool($GLOBALS['TSFE']->id);
				if ($this->school) {
					$school = $this->school->getUid();
				} else {
					$school = 0;
				}
				break;
			case 'DROPDOWN':
				if ($args['school']) {
					$school = $args['school'];
				} else {
					$school = 0;
				}

				break;
			default:
				$school = 0;
		}

		$filter['school'] = $school;

		if ($school) {
			$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];
			if ($school == 'ALL') {
				$commune = $GLOBALS['TSFE']->fe_user->user['tx_itaoshhmanager_ssh_ref_commune'];
				$offers = $this->offerRepository->findAllInCommune($commune, 2);
				$this->view->assign('allOffers', TRUE);
			} else if ($feUser) {
				$likedOffers = $this->offerRepository->findLiked($feUser, $this->school->getUid(), $filter, $orderings);
				$dislikedOffers = $this->offerRepository->findDisliked($feUser, $this->school->getUid(), $filter, $orderings);

				// Get Unsorted
				// Take All Sortet OfferIDs
				$sortedOfferUids = array();
				foreach ($likedOffers as $offer) {
					$sortedOfferUids[] = $offer->getUid();
				}
				foreach ($dislikedOffers as $offer) {
					$sortedOfferUids[] = $offer->getUid();
				}
				$offers = $this->offerRepository->findUnsorted($school, $sortedOfferUids, $filter, $orderings);
			} else {
				$offers = $this->offerRepository->getFilteredList($filter, $orderings);
			}

			if (!$orderings) {
				$offers = $offers->toArray();
				shuffle($offers);
			}

			$this->view->assign('offers', $offers);
			$userRights = $this->getUserRights();

			$this->view->assign('rights', $userRights);
		}
	}

	/**
	 * action approveOffers
	 * list new and denied Offers
	 * 
	 * @return void
	 */
	function approveOffersAction() {
		// Schule finden (rekusiv) - $this->school;
		$this->getSchool($GLOBALS['TSFE']->id);

		$newOffers = $this->offerRepository->findSchoolOffersByStatus($this->school, 1);
		$deniedOffers = $this->offerRepository->findSchoolOffersByStatus($this->school, 3);

		$this->view->assign('newOffers', $newOffers);
		$this->view->assign('deniedOffers', $deniedOffers);

		$userRights = $this->getUserRights();
		$this->view->assign('rights', $userRights);
	}

	/**
	 * get actFilters
	 * 
	 * @param Array $args
	 * @return Array
	 */
	function getFilterValues($args) {
		if ($args['filter']) {
			$filter = $args['filter'];
			$this->view->assign('filter', $filter);
		}

		$this->view->assign('actTab', $args['actTab']);

		// additionalFilter
		if ($filter['additional']) {
			$tempFilter = explode(';', $filter['additional']);
			$filter[$tempFilter[0]] = $tempFilter[1];
			unset($filter['additional']);
		}

		// Nur Freigegebene Vorschläge anzeigen
		$filter['status'] = 2;

		$this->view->assign('actTab', $args['actTab']);

		return $filter;
	}

	/**
	 * get actOrderings
	 * 
	 * @param Array $args
	 * @return Array
	 */
	function getOrderings($args) {
		// get Orderings
		if ($args['orderings']) {
			$orderings = explode(';', $args['orderings']);
			$this->view->assign('orderings', $args['orderings']);
		}
		return $orderings;
	}

	/**
	 * action communeOffers
	 * @param Array $args 
	 * @return void
	 */
	public function communeOffersAction($args = NULL) {

		if (!$args) {
			$args = $this->request->getArguments();
		}

		if ($args['markAsEdited']['offer']) {
			$this->markAsEdited($args);
		}

		$filter = $this->getFilterValues($args);
		$orderings = $this->getOrderings($args);

		// Get Schools to build the DropDown
		$commune = $GLOBALS['TSFE']->fe_user->user['tx_itaoshhmanager_ssh_ref_commune'];
		$schools = $this->schoolRepository->findByRefCommune($commune);

		$this->view->assign("schools", $schools);

		if ($filter['school']) {
			$this->view->assign('actSchool', $filter['school']);
			// Assign choosen School for the Dropdown
			if ($filter['school'] == 'ALL') {
				unset($filter['school']);
				$filter['commune'] = $commune;
				$filter['edited'] = "1";
				$editedOffers = $this->offerRepository->getFilteredList($filter, $orderings);
				$filter['edited'] = "0";
				$unEditedOffers = $this->offerRepository->getFilteredList($filter, $orderings);

				$this->view->assign('allOffers', TRUE);
			} else {
				$filter['edited'] = "1";
				$editedOffers = $this->offerRepository->getFilteredList($filter, $orderings);
				$filter['edited'] = "0";
				$unEditedOffers = $this->offerRepository->getFilteredList($filter, $orderings);
			}

			if (sizeof($editedOffers) > 0 || sizeof($unEditedOffers) > 0) {
				$this->view->assign('showTabs', TRUE);
			}

			// shuffle?
			if ($orderings[1] == 'RANDOM') {

				$editedOffersArray = $editedOffers->toArray();
				$unEditedOffersArray = $unEditedOffers->toArray();

				shuffle($editedOffersArray);
				shuffle($unEditedOffersArray);

				$this->view->assign('editedOffers', $editedOffersArray);
				$this->view->assign('unEditedOffers', $unEditedOffersArray);
			} else {
				$this->view->assign('editedOffers', $editedOffers);
				$this->view->assign('unEditedOffers', $unEditedOffers);
			}

			// rights
			$userRights = $this->getUserRights();
			$this->view->assign('rights', $userRights);
		}
	}

	/**
	 * Marks an Offer as Edited/Unedited
	 * Alternative for the Action
	 * 
	 * @param Array $args
	 */
	public function markAsEdited($args) {
		$offer = $this->offerRepository->findByUid($args['markAsEdited']['offer']);
		$offer->setEdited($args['markAsEdited']['mark']);
		unset($args['markAsEdited']);

		$this->redirect('communeOffers', NULL, NULL, $args, NULL, 0, 303);
	}

	/**
	 * action markAsEdited
	 * 
	 * @param $offer
	 * @return void
	 */
	public function markAsEditedAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$args = $this->request->getArguments();
		$offer->setEdited($args['mark']);

		if ($args['returnAction'] == 'show') {
			$this->redirect('show', NULL, NULL, array('offer' => $offer), NULL, 0, 303);
		} else {
			$this->redirect($args['returnAction'], NULL, NULL, array('school' => $args['school']), NULL, 0, 303);
		}
	}

	/**
	 * action setOfferStatusAction
	 * 
	 * @param $offer
	 * @return void
	 */
	public function setOfferStatusAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$args = $this->request->getArguments();
		$offer->setStatus($this->statusRepository->findByUid($args['status']));

		//define Log
		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];
		$log = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_OfferLog');
		$log->setFeUser($feUser);
		$log->setDate(time());

		if ($args['status'] == 2) {
			$log->setAction($this->settings['actions']['approved']['uid']);

			// submitted log for all groups
			$logForAll = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_OfferLog');
			$logForAll->setDate(time());
			$logForAll->setFeUser($feUser);
			$logForAll->setSchool($offer->getSchool());
			$logForAll->setCommune($offer->getCommune());
			$logForAll->setAction($this->settings['actions']['submitted']['uid']);
			$offer->addLog($logForAll);
		} else if ($args['status'] == 3) {
			$log->setAction($this->settings['actions']['rejected']['uid']);
		}

		$offer->addLog($log);

		if ($args['returnAction'] == 'show') {
			$this->redirect('show', NULL, NULL, array('offer' => $offer), NULL, 0, 303);
		} else {
			$this->redirect($args['returnAction'], NULL, NULL, array('school' => $args['school']), NULL, 0, 303);
		}
	}

	/**
	 * action sort
	 *
	 * @param $newOffer
	 * @return void
	 */
	public function sortAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$args = $this->request->getArguments();

		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];

		if ($args['status'] == 0) {
			if ($args['oldStatus'] == 1) {
				$like = $this->likeRepository->findOfferSorting($feUser, $offer->getUid());

				//remove Completly
				$this->likeRepository->deleteFromTable($like->getUid());
//				$offer->removeLikes($like);
			} else {
				$dislike = $this->dislikeRepository->findOfferSorting($feUser, $offer->getUid());

				//remove Completly
				$this->dislikeRepository->deleteFromTable($dislike->getUid());
//				$offer->removeDislikes($dislike);
			}
		} else {
			//delete Old
			if ($args['status'] == 1) {
				if ($args['oldStatus'] != 0) {
					$dislike = $this->dislikeRepository->findOfferSorting($feUser, $offer->getUid());
					$offer->removeDislikes($dislike);
				}

				$like = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_Like');
				$like->setFeUser($feUser);

				$offer->addLikes($like);
			} else {
				if ($args['oldStatus'] != 0) {
					$like = $this->likeRepository->findOfferSorting($feUser, $offer->getUid());
					$offer->removeLikes($like);
				}

				$dislike = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_Dislike');
				$dislike->setFeUser($feUser);

				$offer->addDislikes($dislike);
			}
		}

		if ($args['returnAction'] == 'show') {
			$this->redirect('show', NULL, NULL, array('offer' => $offer), NULL, 0, 303);
		} else {
			$this->redirect($args['returnAction'], NULL, NULL, $args, NULL, 0, 303);
		}
	}

	/**
	 * action sortedOffers
	 * 
	 * @param Array $args
	 * @return void
	 */
	public function sortedOffersAction($args = NULL) {

		if (!$args) {
			$args = $this->request->getArguments();
		}

		$filter = $this->getFilterValues($args);
		$orderings = $this->getOrderings($args);

		// Schule finden (rekusiv)
		$this->getSchool($GLOBALS['TSFE']->id);

		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];

		$likedOffers = $this->offerRepository->findLiked($feUser, $this->school->getUid(), $filter, $orderings);
		$dislikedOffers = $this->offerRepository->findDisliked($feUser, $this->school->getUid(), $filter, $orderings);

		// Get Unsorted
		// Take All Sortet OfferIDs
		$sortedOfferUids = array();
		foreach ($likedOffers as $offer) {
			$sortedOfferUids[] = $offer->getUid();
		}
		foreach ($dislikedOffers as $offer) {
			$sortedOfferUids[] = $offer->getUid();
		}

		$unsortedOffers = $this->offerRepository->findUnsorted($this->school->getUid(), $sortedOfferUids, $filter, $orderings);

		// count-Bug begin
		// Ansonsten zählt der count-ViewHelper im fluid-Template immer ALLE Vorschläge
		foreach ($likedOffers as $t) {/* do nothing */
		}
		foreach ($dislikedOffers as $t) {/* do nothing */
		}
		foreach ($unsortedOffers as $t) {/* do nothing */
		}
		// count-Bug end

		$userRights = $this->getUserRights();

		if ($orderings[1] == 'RANDOM') {

			$unsortedOffersArray = $unsortedOffers->toArray();
			$likedOffersArray = $likedOffers->toArray();
			$dislikedOffersArray = $dislikedOffers->toArray();
			shuffle($unsortedOffersArray);
			shuffle($likedOffersArray);
			shuffle($dislikedOffersArray);

			$this->view->assign('unsortedOffers', $unsortedOffersArray);
			$this->view->assign('likedOffers', $likedOffersArray);
			$this->view->assign('dislikedOffers', $dislikedOffersArray);
		} else {
			$this->view->assign('unsortedOffers', $unsortedOffers);
			$this->view->assign('likedOffers', $likedOffers);
			$this->view->assign('dislikedOffers', $dislikedOffers);
		}

		$this->view->assign('rights', $userRights);
		$this->view->assign('school', $this->school);
	}

	/**
	 * action myOffers
	 *
	 * @return void
	 */
	public function myOffersAction() {
		$args = $this->request->getArguments();

		if ($args['offer']) {
			$newOffer = $this->offerRepository->findByUid($args['offer']);
			if ($newOffer->getNewOffer()) {
				$this->view->assign('feedback', TRUE);
				$newOffer->setNewOffer(0);
			}
		}

		// Schule finden (rekusiv) - global: $this->school
		$this->getSchool($GLOBALS['TSFE']->id);
		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];

		// Set filter
		$filter = $this->getFilterValues($args);
		$filter['school'] = $this->school->getUid();
		$filter['fe_user'] = $feUser;
		$orderings = $this->getOrderings($args);

		// show all Status if offers musst be approved
		if (!$this->school->getOfferAutomaticallyApproved()) {
			// assign Submitted Offers
			$filter['status'] = 1;
			$submittedOffers = $this->offerRepository->getFilteredList($filter, $orderings);
			$this->view->assign('submittedOffers', $submittedOffers);

			// assign rejected Offers
			$filter['status'] = 3;
			$rejectedOffers = $this->offerRepository->getFilteredList($filter, $orderings);
			$this->view->assign('rejectedOffers', $rejectedOffers);

			$this->view->assign('showAllStatusOffers', TRUE);
		}

		// assign approved offers
		$filter['status'] = 2;
		$offers = $this->offerRepository->getFilteredList($filter, $orderings);

		$this->view->assign('offers', $offers);
		$this->view->assign('rights', $this->getUserRights());
	}

	/**
	 * action myOffersStatus
	 *
	 * @return void
	 */
	public function myOffersStatusAction() {
		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];
		$feUserGroups = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);

		$communeUid = NULL;
		$schoolUid = NULL;
		// Schule finden (rekusiv)
		$this->getSchool($GLOBALS['TSFE']->id);
		if ($this->school) {
			$schoolUid = $this->school->getUid();
		} else {
			// Kommentator - get Commune
			$this->getCommune($GLOBALS['TSFE']->id);
			$communeUid = $this->commune->getUid();
		}

		$logs = $this->offerLogRepository->findMyLogs($feUser, $feUserGroups, $schoolUid, $communeUid);

		$this->view->assign('logs', $logs);
		$this->view->assign('feUser', $feUser);
	}

	/**
	 * action addOfferData
	 * 
	 * @return void
	 */
	public function addOfferDataAction() {
		$args = $this->request->getArguments();
		$offer = $this->offerRepository->findByUid($args['offer']);

		$feUser = $GLOBALS['TSFE']->fe_user->user['uid'];

		// add Comment
		if ($args['comment']) {
			$newComment = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_Comment');
			$newComment->setText($args['comment']['text']);
			$newComment->setFeUser($feUser);
			$newComment->setDate(time());
			$offer->addComment($newComment);

			$log = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_OfferLog');
			$log->setAction($this->settings['actions']['commented']['uid']);
			$log->setFeUser($feUser);
			$log->setCommune($offer->getCommune());
			$log->setSchool($offer->getSchool());
			$log->setDate(time());
			$log->setDescription("comment was added");
			$offer->addLog($log);
		}

		// add Promoter
		if ($args['promotedFrom']) {

			$promotedFrom = $this->getFromArray($args['promotedFrom']);

			foreach ($promotedFrom as $key => $promoter) {
				$newPromotedFrom = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Model_Promoter');
				$newPromotedFrom->setName($promoter['name']);
				$newPromotedFrom->setClass($promoter['class']);
				$offer->addPromotedFrom($newPromotedFrom);
			}
		}

		$this->redirect('show', NULL, NULL, array('offer' => $offer), NULL, 0, 303);
	}

	/**
	 * Build Userspecific Rights-Array 
	 * 
	 * @return Array $rights
	 */
	public function getUserRights() {
		$feUserGroups = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);
		$rightsSettings = $this->settings['groups'];

		$rights = array();

		if ($feUserGroups[0]) {
			$rights['showLikes'] = TRUE;
			$rights['showCosts'] = TRUE;
		}

		if (in_array($rightsSettings['student'], $feUserGroups)) {	#Schüler
			$rights['student'] = TRUE;
			$rights['showLikes'] = TRUE;
			$rights['sort'] = TRUE;
		}

		if (in_array($rightsSettings['studentRepresentation'], $feUserGroups)) { #Schülerkoordinator
			$rights['editOffer'] = TRUE;
			$rights['edit'] = TRUE;
			$rights['print'] = TRUE;
			$rights['showStudents'] = TRUE;
			$rights['defineChildOffers'] = TRUE;
			$rights['sort'] = TRUE;
			$rights['editStatus'] = TRUE;
			$rights['showLikes'] = TRUE;
		}

		if (in_array($rightsSettings['localManagement'], $feUserGroups)) {  #Kommentator
			$rights['comment'] = TRUE;
			$rights['showAll'] = TRUE;
			$rights['editCosts'] = TRUE;
			$rights['edit'] = TRUE;
			$rights['localManagement'] = TRUE;
			$rights['showLikes'] = TRUE;
			$rights['markAsEdited'] = TRUE;
		}

		if (in_array($rightsSettings['studentManagement'], $feUserGroups)) {  #Koordinator Schule (Lehrer)
			$rights['comment'] = TRUE;
			$rights['edit'] = TRUE;
			$rights['print'] = TRUE;
			$rights['showStudents'] = TRUE;
			$rights['editOffer'] = TRUE;
			$rights['editStatus'] = TRUE;
			$rights['defineChildOffers'] = TRUE;
			$rights['editStatus'] = TRUE;
			$rights['showLikes'] = TRUE;
		}

		return $rights;
	}

	/**
	 * action schoolData
	 *
	 * @return void
	 */
	public function schoolDataAction() {
		// Globale Var für die schule definieren
		$this->school;
		// Schule finden (rekusiv)
		$this->getSchool($GLOBALS['TSFE']->id);

		if ($this->school) {
			switch ($this->settings['schoolData']) {
				case 'numberOfOffers' :
					$numberOfOffers = $this->offerRepository->countAllInSchool($this->school->getUid(), 2);

					$this->view->assign('numberOfOffers', $numberOfOffers);
					break;
				case 'nameOfSchool':
					$this->view->assign('nameOfSchool', $this->school->getTitle());
					break;
			}
		}
	}

	/**
	 * action directEntry
	 *
	 * @param Tx_ItaoShhOffers_Domain_Model_Commune $commune = NULL
	 * @return void
	 */
	public function directEntryAction($commune = NULL) {
//		// commune available?
//		$this->getCommune($GLOBALS['TSFE']->id);
//		
//
//		$communes = $this->communeRepository->findAll();
//		$this->view->assign('communes', $communes);
//
//		$showCommuneSelect = TRUE;
//		// found Commune
//		if ($this->commune) {
//			$schools = $this->schoolRepository->findByRefCommune($this->commune);
//			$showCommuneSelect = FALSE;
//			$this->view->assign('schools', $schools);
//		}
//
//		// just one Commune
//		if (sizeof($communes) == 1) {
//			$showCommuneSelect = FALSE;
//			$schools = $this->schoolRepository->findByRefCommune($communes[0]);
//		}
//
//		// select Commune
//		if ($commune) {
//			$this->view->assign('actCommune', $commune->getUid());
//
//			$schools = $this->schoolRepository->findByRefCommune($commune);
//
//			$this->view->assign('schools', $schools);
//		}
//
//		$this->view->assign('showCommuneSelect', $showCommuneSelect);
		
		$args = $this->request->getArguments();
		$schools = $this->schoolRepository->findAll();
		$this->view->assign('schools', $schools);
		
		// School selected? --> Redirect on Schoolpage
		if ($args['schoolPage']) {
			$this->redirect(NULL, NULL, NULL, NULL, $args['schoolPage'], 0, 303);
		}
	}

	/**
	 * action schoolsStatusBox
	 * 
	 * @return void
	 */
	public function schoolsStatusBoxAction() {
		$this->getCommune($GLOBALS['TSFE']->id);
		$schools = $this->schoolRepository->findByRefCommune($this->commune);

		$schoolArray = array();
		foreach ($schools as $key => $school) {
			$numberOfOffers = $this->offerRepository->countAllInSchool($school->getUid(), 2);
			$schoolArray[$key]['data'] = $school;
			$schoolArray[$key]['numberOfOffers'] = $numberOfOffers;
		}

		$this->view->assign("schools", $schoolArray);
	}

	/**
	 * action linkedSchoolsStatusBox
	 * 
	 * @return void
	 */
	public function linkedSchoolsStatusBoxAction() {
		$this->getCommune($GLOBALS['TSFE']->id);
		$schools = $this->schoolRepository->findByRefCommune($this->commune);

		$schoolArray = array();
		foreach ($schools as $key => $school) {
			$numberOfOffers = $this->offerRepository->countAllInSchool($school->getUid(), 2);
			$schoolArray[$key]['data'] = $school;
			$schoolArray[$key]['numberOfOffers'] = $numberOfOffers;
		}

		$this->view->assign("schools", $schoolArray);
	}

	/**
	 * Creates a Box with sort- and filterfunctions
	 */
	public function sortAndFilterAction() {

		$sortings = $this->sortRepository->findAll();
		$this->view->assign('sortings', $sortings);
		$filters = $this->filterRepository->findAll();
		$this->view->assign('filters', $filters);

		// act Vals
		$actOrderings = explode(';', $_GET['tx_itaoshhoffers_offers']['orderings']);
		$actAdditional = explode(';', $_GET['tx_itaoshhoffers_offers']['filter']['additional']);

		$this->view->assign('actOrderings', $actOrderings[2]);
		$this->view->assign('actAdditional', $actAdditional[2]);
	}

	/**
	 * find the School recusivly
	 * 
	 * @param type $pid
	 */
	public function getSchool($pid) {

		$school = $this->schoolRepository->findOneByRefSchoolpage($pid);

		if (!$school) {
			$page = $this->pageRepository->findByUid($pid);
			if ($page) {
				$pid = $page->getPid();
			}

			//abbrechen wenn die Rootseite erreicht wurde
			if ($pid == 0 or !$pid) {
				$this->school = FALSE;
			} else {
				$this->getSchool($pid);
			}
		} else {
			// Globale Schule setzen
			$this->school = $school;
		}
	}

	/**
	 * find the Commune recusivly
	 * 
	 * @param type $pid
	 */
	public function getCommune($pid) {

		$commune = $this->communeRepository->findOneByRefCommunepage($pid);

		if (!$commune) {
			$page = $this->pageRepository->findByUid($pid);
			if ($page) {
				$pid = $page->getPid();
			}

			//abbrechen wenn die Rootseite erreicht wurde
			if ($pid == 0 or !$pid) {
				$this->commune = FALSE;
			} else {
				$this->getCommune($pid);
			}
		} else {
			// Globale Schule setzen
			$this->commune = $commune;
		}
	}

	/**
	 * action edit
	 *
	 * @param $offer
	 * @return void
	 */
	public function editAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$this->view->assign('offer', $offer);
	}

	/**
	 * action update
	 *
	 * @param $offer
	 * @return void
	 */
	public function updateAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$this->offerRepository->update($offer);
//		$this->flashMessageContainer->add('Your Offer was updated.');
		$this->redirect('show', NULL, NULL, array('offer' => $offer), NULL, 0, 303);
	}

	/**
	 * action updateComment
	 * 
	 * @param $comment
	 * @return void 
	 */
	public function updateCommentAction(Tx_ItaoShhOffers_Domain_Model_Comment $comment) {
		$this->commentRepository->update($comment);
		$args = $this->request->getArguments();

		$offer = $this->offerRepository->findByUid($args['offerUid']);
		$this->redirect('show', NULL, NULL, array('offer' => $offer), NULL, 0, 303);
	}

	/**
	 * action delete
	 *
	 * @param $offer
	 * @return void
	 */
	public function deleteAction(Tx_ItaoShhOffers_Domain_Model_Offer $offer) {
		$this->offerRepository->remove($offer);
		$this->flashMessageContainer->add('Your Offer was removed.');
		$this->redirect('list');
	}

	/**
	 * action printSheet
	 *
	 * @param $school
	 * @return void
	 */
	public function printSheetAction(Tx_ItaoShhOffers_Domain_Model_School $school) {
		$offers = $this->offerRepository->findAllInSchool($school, 2);

		$this->view->assign('rights', $this->getUserRights());
		$this->view->assign('offers', $offers);
	}

	/**
	 * action printButton
	 *
	 * @return void
	 */
	public function printButtonAction() {
		$this->getSchool($GLOBALS['TSFE']->id);

		$this->view->assign('school', $this->school);
	}

	/**
	 * action phaseBox
	 *
	 * @return void
	 */
	public function phaseBoxAction() {
		$phases = $this->phaseRepository->findAll();
		$this->getSchool($GLOBALS['TSFE']->id);
		$this->view->assign('phases', $phases);
		$this->view->assign('school', $this->school);
	}

	public function redirectToCommunePageAction() {
		$commune = $this->communeRepository->findByUid($GLOBALS['TSFE']->fe_user->user['tx_itaoshhmanager_ssh_ref_commune']);
		if ($commune) {
			$this->redirect(NULL, NULL, NULL, NULL, $commune->getRefCommunepage(), 0, 303);
		}
	}

	/**
	 * action topOffers
	 * 
	 * @return void
	 */
	public function TopOffersAction() {
		$this->school;
		// Schule finden (rekusiv)
		$this->getSchool($GLOBALS['TSFE']->id);

		$offers = $this->offerRepository->findTopXInSchool($this->school, 2, $this->school->getNumberOfResultOffers());
		$this->view->assign('offers', $offers);
	}

	/**
	 * action offerLinks
	 * 
	 * @return void
	 */
	public function offerLinksAction() {
		$this->school;
		// Schule finden (rekusiv)
		$this->getSchool($GLOBALS['TSFE']->id);
//		print_r($this->school);
		$this->view->assign('school', $this->school);
		if (!$GLOBALS['TSFE']->fe_user->user) {
			$this->view->assign('loggedOut', TRUE);
			$this->view->assign('offersPage', $this->school->getRefSchoolpage() + 9);
		}
	}

}

?>
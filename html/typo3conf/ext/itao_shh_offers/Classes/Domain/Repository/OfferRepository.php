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
class Tx_ItaoShhOffers_Domain_Repository_OfferRepository extends Tx_Extbase_Persistence_Repository {
	/*
	 * define defaultorderings
	 * the newest Offers first
	 */

	protected $defaultOrderings = array(
		'internal_id' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
	);

	/**
	 * find All in Commune
	 * by status
	 * 
	 * @param type $commune
	 * @param type $status
	 * @return type
	 */
	function findAllInCommune($commune, $status) {
		$query = $this->createQuery();
		return $query->matching($query->logicalAnd($query->equals('commune', $commune), $query->equals('status', $status), $query->equals('parentOffer', 0)))
						->setOrderings(array('tstamp' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
						->execute();
	}

	/**
	 * Find all in commune
	 * by status and edited
	 * 
	 * @param type $commune
	 * @param type $status
	 * @param type $edited
	 * @return type
	 */
	function findInCommune($commune, $status, $edited, $sort = NULL) {
		$query = $this->createQuery();
		$query->matching(
				$query->logicalAnd(
						$query->equals('commune', $commune), $query->equals('status', $status), $query->equals('edited', $edited), $query->equals('parentOffer', 0)
				)
		);

		if ($sort) {
			if ($sort[1] == 'ASC') {
				$query->setOrderings(array($sort[0] => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
			} else {
				$query->setOrderings(array($sort[0] => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING));
			}
		}

		return $query->execute();
	}

	/**
	 * Find all in School by status
	 * 
	 * @param type $school
	 * @param type $status
	 * @return type
	 */
	function findAllInSchool($school, $status = NULL) {
		$query = $this->createQuery();
		if ($status) {
			$constraint = $query->logicalAnd($query->equals('school', $school), $query->equals('status', $status), $query->equals('parentOffer', 0));
		} else {
			$constraint = $query->equals('school', $school);
		}
		
		return $query->matching($constraint)
						->setOrderings(array('internal_id' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
						->execute();
	}

	/**
	 * Find all possible parents for the Select
	 * 
	 * @param type $school
	 * @return type
	 */
	function findPossibleParents($school){
		$query = $this->createQuery();
		
		$constraint = $query->logicalAnd($query->equals('school', $school), $query->equals('status', 2), $query->equals('parentOffer', 0));
		
		return $query->matching($constraint)
						->setOrderings(array('internal_id' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING))
						->execute();
	}
	/**
	 * Find top x in School by status
	 * 
	 * @param type $school
	 * @param type $status
	 * @param int $limit
	 * @return type
	 */
	function findTopXInSchool($school, $status, $limit = 5) {
		$query = $this->createQuery();
		return $query->matching(
							$query->logicalAnd(
								$query->equals('school', $school), 
								$query->equals('status', $status), 
								$query->equals('parentOffer', 0)
							)
						)
						->setOrderings(array('votes' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
						->setLimit($limit)
						->execute();
	}

	/**
	 * Counts the Offers in one School by its status
	 * 
	 * @param type $school
	 * @param type $status
	 * @return type
	 */
	function countAllInSchool($school, $status) {
		$query = $this->createQuery();
		return $query->matching($query->logicalAnd($query->equals('school', $school), $query->equals('status', $status), $query->equals('parentOffer', 0)))
						->count();
	}

	/**
	 * count all offers by the status
	 * 
	 * @param type $status
	 * @return type
	 */
	function countAllOffers($status) {
		$query = $this->createQuery();
		return $query->matching($query->logicalAnd($query->equals('status', $status), $query->equals('parentOffer', 0)))
						->count();
	}

	/**
	 * Find All Offers in School
	 * By status and edited
	 * 
	 * @param type $school
	 * @param type $status
	 * @param type $edited
	 * @param array $sort
	 * @return type
	 */
	function findInSchool($school, $status, $edited, $sort = NULL, $filter) {
		$query = $this->createQuery();
		$query->matching(
				$query->logicalAnd(
						$query->equals('school', $school), $query->equals('status', $status), $query->equals('edited', $edited), $query->equals('parentOffer', 0)
				)
		);


		return $query->execute();
	}

	/**
	 * get a filtered List of Offers
	 * 
	 * @param Array $filter
	 * @param Array $sorting
	 * @return Object
	 */
	function getFilteredList($filter, $orderings) {
		$query = $this->createQuery();
		$constraints = array();

		foreach ($filter as $field => $value) {
			if ($value != "") {
				if ($value == 'TRUE') {
					$constraints[] = $query->logicalNot($query->equals($field, ''));
				} else if ($value == 'FALSE') {
					$constraints[] = $query->equals($field, "");
				} else {
					$constraints[] = $query->equals($field, $value);
				}
			}
		}
		// No ChildOffers
		$constraints[] = $query->equals('parentOffer', 0);
		
		$query->matching(
				$query->logicalAnd($constraints)
		);
		
		if ($orderings && $orderings[1] != 'RANDOM') {
			if ($orderings[0] == 'title') {
				if ($orderings[1] == 'ASC') {
					$query->setOrderings(array($orderings[0] => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
				} else {
					$query->setOrderings(array($orderings[0] => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING));
				}
			} else {
				if ($orderings[1] == 'ASC') {
					$query->setOrderings(array($orderings[0] => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING, 'title' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
				} else {
					$query->setOrderings(array($orderings[0] => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING, 'title' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
				}
			}
		}

		return $query->execute();
	}

	/**
	 * Returns the last Created Offer from School
	 * 
	 * @param integer $school
	 */
	function getLastOfferFromSchool($school) {
		$query = $this->createQuery();
		return $query->matching($query->logicalAnd($query->equals('school', $school), $query->equals('parentOffer', 0)))
						->setOrderings(array('internal_id' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
						->execute()->getFirst();
	}

	/**
	 * find All Unsorted Offer of one User
	 * 
	 * @param type $schoolId
	 * @return Object
	 */
	function findUnsorted($schoolId, $sortedOfferUids, $filter, $orderings) {
		$query = $this->createQuery();
		$where = "deleted=0 AND hidden=0 AND status=2 AND parent_offer = 0 AND school = " . $schoolId;
		if (sizeof($sortedOfferUids) > 0) {
			$where .= " AND uid NOT IN (" . implode(',', $sortedOfferUids) . ")";
		}

		foreach ($filter as $field => $value) {
			if ($value != "") {
				if ($value == 'TRUE') {
					$where .= ' AND ' . $field . ' != ""';
				} else if ($value == 'FALSE') {
					$where .= ' AND ' . $field . ' = ""';
				} else {
					$where .= ' AND ' . $field . ' = ' . $value;
				}
			}
		}
		
		if ($orderings && $orderings[1] != 'RANDOM') {
			$orderBy = $orderings[0] . ' ' . $orderings[1] . ', title ASC';
		} else {
			$orderBy = 'internal_id DESC';
		}

		$statement = "	SELECT * FROM tx_itaoshhoffers_domain_model_offer
						WHERE " . $where . "
						ORDER BY " . $orderBy;

		return $query->statement($statement)->execute();
	}

	/**
	 * find all liked Offers of one User
	 * 
	 * @param type $feUserUid
	 * @param type $schoolId
	 * @return Object
	 */
	function findLiked($feUserUid, $schoolId, $filter, $orderings) {
		$query = $this->createQuery();

		$where = "offer.deleted = 0 AND
				  offer.hidden = 0 AND 
				  offer.parent_offer = 0 AND
				  offer.school = " . $schoolId . " AND 
				  liked.fe_user = " . $feUserUid;

//		$where = "offer.deleted = 0 AND
//				  offer.hidden = 0 AND
//				  offer.school = " . $schoolId;

		foreach ($filter as $field => $value) {
			if ($value != "") {
				if ($value == 'TRUE') {
					$where .= ' AND offer.' . $field . ' != ""';
				} else if ($value == 'FALSE') {
					$where .= ' AND offer.' . $field . ' = ""';
				} else {
					$where .= ' AND offer.' . $field . ' = ' . $value;
				}
			}
		}

		if ($orderings && $orderings[1] != 'RANDOM') {
			$orderBy = 'offer.' . $orderings[0] . ' ' . $orderings[1] . ', offer.title ASC';
		} else {
			$orderBy = 'offer.internal_id DESC';
		}

//		$res = mysql_query("SELECT offer FROM tx_itaoshhoffers_domain_model_like WHERE fe_user = " . $feUserUid);
//		while ($row = mysql_fetch_assoc($res)) {
//			$offerUids[] = $row['offer'];
//		}

//		$statement = "	SELECT *
//						FROM tx_itaoshhoffers_domain_model_offer offer
//						WHERE " . $where . " AND offer.uid IN (" . implode(',',$offerUids) . ")
//						ORDER BY " . $orderBy;


		$statement = "	SELECT offer.*
						FROM tx_itaoshhoffers_domain_model_offer offer 
						INNER JOIN tx_itaoshhoffers_domain_model_like liked ON offer.uid = liked.offer
						WHERE " . $where . "
						ORDER BY " . $orderBy;

		$offers = $query->statement($statement)->execute();

		if ($offers) {
			return $offers;
		} else {
			return FALSE;
		}
	}

	/**
	 * find all disliked Offers of one User
	 * 
	 * @param type $feUserUid
	 * @param type $schoolId
	 * @return Object
	 */
	function findDisliked($feUserUid, $schoolId, $filter, $orderings) {
		$query = $this->createQuery();

		$where = "offer.deleted = 0 AND
				  offer.hidden = 0 AND
				  offer.parent_offer = 0 AND
				  offer.school = " . $schoolId . " AND 
				  dislike.fe_user = " . $feUserUid;

//		$where = "offer.deleted = 0 AND
//				  offer.hidden = 0 AND
//				  offer.school = " . $schoolId;

		foreach ($filter as $field => $value) {
			if ($value != "") {
				if ($value == 'TRUE') {
					$where .= ' AND offer.' . $field . ' != ""';
				} else if ($value == 'FALSE') {
					$where .= ' AND offer.' . $field . ' = ""';
				} else {
					$where .= ' AND offer.' . $field . ' = ' . $value;
				}
			}
		}

		if ($orderings && $orderings[1] != 'RANDOM') {
			$orderBy = 'offer.' . $orderings[0] . ' ' . $orderings[1] . ', offer.title ASC';
		} else {
			$orderBy = 'offer.internal_id DESC';
		}

		$statement = "	SELECT offer.*
						FROM tx_itaoshhoffers_domain_model_offer offer 
						INNER JOIN tx_itaoshhoffers_domain_model_dislike dislike ON offer.uid = dislike.offer 
						WHERE " . $where . "
						ORDER BY " . $orderBy;

//		$res = mysql_query("SELECT offer FROM tx_itaoshhoffers_domain_model_dislike WHERE fe_user = " . $feUserUid);
//		while ($row = mysql_fetch_assoc($res)) {
//			$offerUids[] = $row['offer'];
//		}
//		
//		$statement = "	SELECT *
//						FROM tx_itaoshhoffers_domain_model_offer offer
//						WHERE " . $where . " AND offer.uid IN (" . implode(',',$offerUids) . ")
//						ORDER BY " . $orderBy;

		$offers = $query->statement($statement)->execute();

		if ($offers) {
			return $offers;
		} else {
			return FALSE;
		}
	}

	function findSchoolOffersByStatus($school, $status) {
		$query = $this->createQuery();

		return $query->matching($query->logicalAnd($query->equals('school', $school), $query->equals('status', $status)))
						->setOrderings(array('internal_id' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
						->execute();
	}

}

?>
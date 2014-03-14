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
class Tx_ItaoShhOffers_Domain_Repository_OfferLogRepository extends Tx_Extbase_Persistence_Repository {
	/**
     * Constructor of the repository.
     * Sets the respect storage page to false.
     * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
     */
    public function __construct(Tx_Extbase_Object_ObjectManagerInterface $objectManager = NULL) {
        parent::__construct($objectManager);
        $this->defaultQuerySettings = new Tx_Extbase_Persistence_Typo3QuerySettings();
        $this->defaultQuerySettings->setRespectStoragePage(FALSE);
    }
	
	public function findMyLogs($feUser, $feGroups = NULL, $school = NULL, $commune = NULL){
		$query = $this->createQuery();
		$from = "SELECT DISTINCT log.*
				 FROM  tx_itaoshhoffers_domain_model_offerlog log
				 INNER JOIN tx_itaoshhoffers_domain_model_offer offer ON log.offer = offer.uid";
		$where = " WHERE 
					log.deleted = 0 AND
					log.hidden = 0 AND
					log.offer = offer.uid";
		
		if($school) {
			$where.= " AND (offer.fe_user = " . $feUser . " OR log.school = " . $school . ")";
			
		} else if ($commune) {
			// Kommentator
			$where.= " AND (offer.fe_user = " . $feUser . " OR log.commune = " . $commune . ")";
		} else {
			$where.= " AND offer.fe_user = " . $feUser;
		}
		
		if($feGroups) {
			$groupOr = '';
			foreach($feGroups as $group) {
				$groupOr.= " concat (',',log.fe_groups,',') LIKE '%," . $group . ",%' OR ";
			}	
			$where.= ' AND (' . $groupOr . ' log.fe_groups = "")';
		}
		
		$orderBy = " ORDER BY log.date DESC";
		$limit = " LIMIT 10";
		
		$statement = $from . $where . $orderBy . $limit;	  

		return $query->statement($statement)->execute();
	}
}
?>
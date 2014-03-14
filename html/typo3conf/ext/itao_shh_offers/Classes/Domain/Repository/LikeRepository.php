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
class Tx_ItaoShhOffers_Domain_Repository_LikeRepository extends Tx_Extbase_Persistence_Repository {
	
	function findOfferSorting($feUserUid, $offerUid){
		$query = $this->createQuery();
		$statement = "	SELECT DISTINCT * 
						FROM tx_itaoshhoffers_domain_model_like
						WHERE offer = " . $offerUid . " 
						AND fe_user = " . $feUserUid;
		
		return $query->statement($statement)->execute()->getFirst();
	}
	
	function deleteFromTable($uid){
		mysql_query("DELETE FROM tx_itaoshhoffers_domain_model_like	WHERE uid = " . $uid);
	}
	
}
?>
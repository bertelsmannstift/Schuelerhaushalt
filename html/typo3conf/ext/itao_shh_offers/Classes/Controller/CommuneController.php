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
class Tx_ItaoShhOffers_Controller_CommuneController extends Tx_Extbase_MVC_Controller_ActionController {
	/**
	 * CommuneRepository
	 *
	 * @var Tx_ItaoShhOffers_Domain_Repository_CommuneRepository
	 */
	protected $communeRepository;
	
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
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->schoolRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_SchoolRepository');
		$this->pageRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_PageRepository');
		$this->communeRepository = t3lib_div::makeInstance('Tx_ItaoShhOffers_Domain_Repository_CommuneRepository');
	}
	
	/**
	 * injectOfferRepository
	 *
	 * @param Tx_ItaoShhOffers_Domain_Repository_OfferRepository $offerRepository
	 * @return void
	 */
	public function injectOfferRepository(Tx_ItaoShhOffers_Domain_Repository_CommuneRepository $communeRepository) {
		$this->communeRepository = $communeRepository;
	}
	
	/**
	 * action communeList
	 *
	 * @return void
	 */
	public function communeListAction() {
		$communes = $this->communeRepository->findAll();
		
		$this->view->assign("communes", $communes);
	}
}
<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 
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
 * Repository for Tx_ItaoDownload_Domain_Model_Category
 */
class Tx_ItaoDownload_Domain_Repository_CategoryRepository extends Tx_Extbase_Persistence_Repository {
	
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
}
?>
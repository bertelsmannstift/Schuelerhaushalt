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
 * Controller for the Category object
 */
class Tx_ItaoDownload_Controller_CategoryController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_ItaoDownload_Domain_Repository_CategoryRepository
	 */
	protected $categoryRepository;
	
	/**
	 * @var Tx_ItaoDownload_Domain_Repository_DownloadRepository
	 */
	protected $downloadRepository;
	
	/**
	 * @var string The baseURL from setup
	 */
	protected $baseUrl;
	

	/**
	 * @param Tx_ItaoDownload_Domain_Repository_CategoryRepository $categoryRepository
 	 * @return void
-	 */
	public function injectCategoryRepository(Tx_ItaoDownload_Domain_Repository_CategoryRepository $categoryRepository) {
		$this->categoryRepository = $categoryRepository;
		$this->downloadRepository = t3lib_div::makeInstance('Tx_ItaoDownload_Domain_Repository_DownloadRepository');
		$this->baseUrl = ($GLOBALS['TSFE']->config['config'] && $GLOBALS['TSFE']->config['config']['baseURL']) ? $GLOBALS['TSFE']->config['config']['baseURL'] : $this->settings['baseUrl'];
	}



	/**
	 * Displays all Categories
	 *
	 * @return void
	 */
	public function listAction() {
		if (strlen(trim($this->settings['showCategory']))>0) {
			foreach (t3lib_div::trimExplode(',',$this->settings['showCategory']) as $category) {
				$cat = $this->categoryRepository->findByUid($category);
				$tempDownload['title'] = $cat->getTitle();
				$tempDownload['data'] = $this->downloadRepository->findByCategoryUid(intval($category));
				if (count($tempDownload['data'])>0) 
					$downloads[] = $tempDownload;
			}
		}
		$this->view->assignMultiple(array('categories'=>$downloads,'url'=>$this->baseUrl));
	}


	/**
	 * Displays a single Category
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Category $category the Category to display
	 * @return string The rendered view
	 */
	public function showAction(Tx_ItaoDownload_Domain_Model_Category $category) {
		$this->view->assign('category', $category);
	}


	/**
	 * Displays a form for creating a new  Category
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Category $newCategory a fresh Category object which has not yet been added to the repository
	 * @return void
	 * @dontvalidate $newCategory
	 */
	public function newAction(Tx_ItaoDownload_Domain_Model_Category $newCategory = NULL) {
		$this->view->assign('newCategory', $newCategory);
	}


	/**
	 * Creates a new Category and forwards to the list action.
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Category $newCategory a fresh Category object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(Tx_ItaoDownload_Domain_Model_Category $newCategory) {
		$this->categoryRepository->add($newCategory);
		$this->flashMessageContainer->add('Your new Category was created.');
		
			
			if(!empty($_FILES)){
				$this->flashMessageContainer->add('File upload is not yet supported by the Persistence Manager. You have to implement it yourself.');
			}
			
		$this->redirect('list');
	}


	
	/**
	 * Displays a form for editing an existing Category
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Category $category the Category to display
	 * @return string A form to edit a Category 
	 */
	public function editAction(Tx_ItaoDownload_Domain_Model_Category $category) {
		$this->view->assign('category', $category);
	}



	/**
	 * Updates an existing Category and forwards to the list action afterwards.
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Category $category the Category to display
	 */
	public function updateAction(Tx_ItaoDownload_Domain_Model_Category $category) {
		$this->categoryRepository->update($category);
		$this->flashMessageContainer->add('Your Category was updated.');
		$this->redirect('list');
	}


			/**
	 * Deletes an existing Category
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Category $category the Category to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_ItaoDownload_Domain_Model_Category $category) {
		$this->categoryRepository->remove($category);
		$this->flashMessageContainer->add('Your Category was removed.');
		$this->redirect('list');
	}


}
?>
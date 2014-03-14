<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Peter Rauer <peter.rauer@itao.de>
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
 * Controller for the Download object
 */
class Tx_ItaoDownload_Controller_DownloadController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_ItaoDownload_Domain_Repository_DownloadRepository
	 */
	protected $ordering;
	
	/**
	 * @var Tx_ItaoDownload_Domain_Repository_CategoryRepository
	 */
	protected $categoryRepository;
	
	/**
	 * @var string The baseURL from setup
	 */
	protected $baseUrl;
	
	/**
	 * @param Tx_ItaoDownload_Domain_Repository_DownloadRepository $downloadRepository
 	 * @return void
-	 */
	public function injectDownloadRepository(Tx_ItaoDownload_Domain_Repository_DownloadRepository $downloadRepository) {
		$this->downloadRepository = $downloadRepository;
		$this->categoryRepository = t3lib_div::makeInstance('Tx_ItaoDownload_Domain_Repository_CategoryRepository');
		$this->baseUrl = ($GLOBALS['TSFE']->config['config'] && $GLOBALS['TSFE']->config['config']['baseURL']) ? $GLOBALS['TSFE']->config['config']['baseURL'] : $this->settings['baseUrl'];
	}

	/**
	 * Displays all downloads
	 *
	 * @param void
	 * @return void
	 */
	public function listAction() {
		if ($GLOBALS['TSFE'] && $GLOBALS['TSFE']->page['uid']>0) {
			// FE 
			$downloadsFE = $this->getDownloadsForFE();
			if (isset($downloadsFE) && isset($downloadsFE['data'])) {
				// box fields
				/*
				$boxTitle = $this->settings['displayMode'] == 1 && strlen(trim($this->settings['titleBoxDownload'])) > 0 ? trim($this->settings['titleBoxDownload']) : NULL; 
				$boxText = $this->settings['displayMode'] == 1 && strlen(trim($this->settings['textBoxDownload'])) > 0 ? trim($this->settings['textBoxDownload']) : NULL;
				*/
				
				$boxTitle = strlen(trim($this->settings['titleBoxDownload'])) > 0 ? trim($this->settings['titleBoxDownload']) : NULL;
				$boxText = $this->settings['displayMode'] == 1 && strlen(trim($this->settings['textBoxDownload'])) > 0 ? trim($this->settings['textBoxDownload']) : NULL;

				$linkText = strlen(trim($this->settings['linkTextDownload'])) > 0 ? trim($this->settings['linkTextDownload']) : NULL;
				if (isset($downloadsFE['data'][0])) {
					$cat = $downloadsFE['data'][0]->getCategory();
				} else {
					$downloadsFE['data'] = NULL;	
				}
				
				$this->view->assignMultiple(array($downloadsFE['mode']=>$downloadsFE['data'],'url'=>$this->baseUrl,'boxTitle'=>$boxTitle,'boxText'=>$boxText,'linkText'=>$linkText));
			}
		} else {
			// BE
			$orderValue = 'DESC';
			$arguments	= $this->request->getArguments();
			$field = $arguments['sortField'] ? $arguments['sortField'] : 'title';
			$order	=	$arguments['order'];
			if (isset($order)) {
 				if($order == 'ASC') {
 					$ordering	=	array($field => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING);
					$orderValue = 'DESC';
				}else {
					$ordering	=	array($field => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING);	
					$orderValue = 'ASC';	
				}
			
			//$ordering = array('title' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING);
			$downloads = $this->downloadRepository->sortByCol($ordering);
			} else {
				$downloads = $this->downloadRepository->findAll();
			}
			$this->view->assignMultiple(array('downloads'=>$downloads,'order'=>$orderValue,'url'=>$this->baseUrl));
		}
		
	}

	
	
	

	/**
	 * Displays a single Download
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Download $download the Download to display
	 * @return string The rendered view
	 */
	public function showAction(Tx_ItaoDownload_Domain_Model_Download $download) {
		$this->view->assign('download', $download);
	}


	/**
	 * Displays a form for creating a new  Download
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Download $newDownload a fresh Download object which has not yet been added to the repository
	 * @return void
	 * @dontvalidate $newDownload
	 */
	public function newAction(Tx_ItaoDownload_Domain_Model_Download $newDownload = NULL) {
		$this->view->assign('newDownload', $newDownload);
	}


	/**
	 * Creates a new Download and forwards to the list action.
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Download $newDownload a fresh Download object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(Tx_ItaoDownload_Domain_Model_Download $newDownload) {
		$this->downloadRepository->add($newDownload);
		$this->flashMessageContainer->add('Your new Download was created.');
		
			
			if(!empty($_FILES)){
				$this->flashMessageContainer->add('File upload is not yet supported by the Persistence Manager. You have to implement it yourself.');
			}
			
		$this->redirect('list');
	}


	
	/**
	 * Displays a form for editing an existing Download
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Download $download the Download to display
	 * @return string A form to edit a Download 
	 */
	public function editAction(Tx_ItaoDownload_Domain_Model_Download $download) {
		$categories = $this->categoryRepository->findAll();
		$this->view->assignMultiple(array('download'=>$download,'categories'=>$categories));
	}



	/**
	 * Updates an existing Download and forwards to the list action afterwards.
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Download $download the Download to display
	 */
	public function updateAction(Tx_ItaoDownload_Domain_Model_Download $download) {
		$this->downloadRepository->update($download);
		$this->flashMessageContainer->add('Your Download was updated.');
		$this->redirect('list');
	}


			/**
	 * Deletes an existing Download
	 *
	 * @param Tx_ItaoDownload_Domain_Model_Download $download the Download to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_ItaoDownload_Domain_Model_Download $download) {
		$this->downloadRepository->remove($download);
		$this->flashMessageContainer->add('Your Download was removed.');
		$this->redirect('list');
	}

	/**
	 * Gets the downloads for displaying them in the frontend.
	 * 
	 * @param void
	 * @return array
	 */
	private function getDownloadsForFE() {
		// Which mode (list or box)?
		$viewMode = $this->settings['displayMode'] == 0 ? 'download-list' : 'download-box';
		// What to display (categories or single downloads)?
		switch ($this->settings['displayType']) {
			case 0:
				// show downloads by categories
				$this->forward('list','Category');
				break;
			case 1:
				// show single downloads
				if (strlen(trim($this->settings['showDownload']))>0) {
					foreach (t3lib_div::trimExplode(',',$this->settings['showDownload']) as $download) {
						$downloads[] = $this->downloadRepository->findOneByUid(intval($download));
					}
				}
				break;
		}
		
		return array('mode'=>$viewMode,'data'=>$downloads);
	}
}
?>
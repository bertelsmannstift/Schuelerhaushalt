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
 * Download
 */
class Tx_ItaoDownload_Domain_Model_Download extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * file
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $file;

	/**
	 * shortDescription
	 *
	 * @var string
	 */
	protected $shortDescription;

	/**
	 * longDescription
	 *
	 * @var string
	 */
	protected $longDescription;

	/**
	 * category
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoDownload_Domain_Model_Category>
	 * @eager
	 */
	protected $category;

	/**
	 * uploadFolder
	 * 
	 * @var string
	 */
	protected $uploadFolder = 'uploads/tx_itao_download/';
	
	
	
	
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		* Do not modify this method!
		* It will be rewritten on each save in the kickstarter
		* You may modify the constructor of this class instead
		*/
		$this->category = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $file
	 * @return void
	 */
	public function setFile($file) {
		$this->file = $file;
	}

	/**
	 * @return string
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * @param string $shortDescription
	 * @return void
	 */
	public function setShortDescription($shortDescription) {
		$this->shortDescription = $shortDescription;
	}

	/**
	 * @return string
	 */
	public function getShortDescription() {
		return $this->shortDescription;
	}

	/**
	 * @param string $longDescription
	 * @return void
	 */
	public function setLongDescription($longDescription) {
		$this->longDescription = $longDescription;
	}

	/**
	 * @return string
	 */
	public function getLongDescription() {
		return $this->longDescription;
	}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoDownload_Domain_Model_Category> $category
	 * @return void
	 */
	public function setCategory(Tx_Extbase_Persistence_ObjectStorage $category) {
		$this->category = $category;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ItaoDownload_Domain_Model_Category>
	 */
	public function getCategory1() {
		return $this->category;
	}
	/**
	 * Gets the categories of the download.
	 * 
	 * @param void
	 * @return array
	 */
	public function getCategory() {
		return (isset($this->category) && $this->category->count()>0) ? $this->category->toArray() : NULL;
	}

	/**
	 * @param Tx_ItaoDownload_Domain_Model_Category the Category to be added
	 * @return void
	 */
	public function addCategory(Tx_ItaoDownload_Domain_Model_Category $category) {
		$this->category->attach($category);
	}

	/**
	 * @param Tx_ItaoDownload_Domain_Model_Category the Category to be removed
	 * @return void
	 */
	public function removeCategory(Tx_ItaoDownload_Domain_Model_Category $categoryToRemove) {
		$this->category->detach($categoryToRemove);
	}
	
	/**
	 * Gets the titles of the categories.
	 * 
	 * @param void
	 * @return string
	 */
	public function getCategoryTitles() {
		if (isset($this->category) && $this->category->count()>0) {
			foreach ($this->category->toArray() as $cat) 
				$titles .= $cat->getTitle() .', ';
		}
		return isset($titles) ? substr($titles,0,-2) : '';

	}
	
	/**
	 * Gets the path to the downloads.
	 * 
	 * @param void
	 * @return string
	 */
	public function getDownloadLinkPath() {
		return $this->uploadFolder;
	}
	
	/**
	 * Gets the type of downloadable file (e.g. PDF, DOC) 
	 * 
	 * @param boolean $toUpper		Should the return value containing upper values?
	 * @return string				The type of file to download.
	 */
	public function getFileType($toUpper=FALSE) {
		if (isset($this->file)) {
			$type = $toUpper ? strtoupper(substr($this->file, strrpos($this->file, ".") + 1)) : substr($this->file, strrpos($this->file, ".") + 1);
		}
		
		return isset($type) ? $type : '';
	}
	
	/**
	 * Gets the size of the downloadable file.
	 * 
	 * @param void
	 * @return string
	 */
	public function getFileSize() {
		$file = $this->uploadFolder.$this->file;
		$fileSize = '?';
		if (isset($this->file) && $this->isFileExisting($file)) {
			$fileSize = filesize($file);
			if($fileSize >= 1048576) {
				$fileSize = round(round($fileSize / 1048576 * 100) / 100) . " MB";
			} elseif($fileSize >= 1024) {
				$fileSize = round(round($fileSize / 1024 * 100) / 100) . " KB";
			} else {
				$fileSize = round($fileSize) . " B";
			}	
		}
		
		return $fileSize;
	}
	
	/**
	 * Checks if a file exists in file system.
	 * 
	 * @param string $file			The file with path to look for.
	 * @return boolean
	 */
	private function isFileExisting($file) {
		return (!file_exists($file) || !is_file($file)) ? FALSE : TRUE;
	}
}
?>
<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Armin Ruediger Vieweg <armin@v.ieweg.de>
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
 * Drag and drop class
 */
class tx_dragdrop {
	/** @var integer */
	protected $column = 0;

	/** @var array */
	protected $uidOrder = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->initialize();
	}

	/**
	 * Initializes the object
	 *
	 * @return void
	 */
	protected function initialize() {
		$this->setColumn(intval(t3lib_div::_POST('col')));
		$this->setUidOrder(t3lib_div::_POST('uidOrder'));
	}

	/**
	 * @return integer
	 */
	public function getColumn() {
		return $this->column;
	}

	/**
	 * @param integer $column
	 */
	public function setColumn($column) {
		$this->column = $column;
	}

	/**
	 * @return array
	 */
	public function getUidOrder() {
		return $this->uidOrder;
	}

	/**
	 * @param array $uidOrder
	 */
	public function setUidOrder($uidOrder = array()) {
		$order = array();
		foreach($uidOrder as $uid) {
			$order[] = array(
				'uid' => intval($uid),
				'sorting' => NULL
			);
		}
		$this->uidOrder = $order;
	}

	/**
	 * Changes the order of content elements
	 *
	 * @return void
	 */
	public function changeOrderAction() {
		$newOrder = $this->getUidOrder();
		$i = 100;
		foreach($newOrder as $index => $ordering) {
			$newOrder[$index]['colPos'] = $this->getColumn();
			$newOrder[$index]['sorting'] = $i;
			$i += 10;

			$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
				'tt_content',
				'uid=' . $ordering['uid'],
				$newOrder[$index]
			);
		}
	}
}
?>
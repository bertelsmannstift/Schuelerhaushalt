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

class ux_tx_cms_layout extends tx_cms_layout {
	/** @var integer */
	protected $i = 0;

	function tt_content_drawColHeader($colName, $editParams, $newParams) {
		if ($this->i === 0) {
			$GLOBALS['SOBE']->doc->getPageRenderer()->loadScriptaculous('effects,dragdrop');
			$GLOBALS['SOBE']->doc->getPageRenderer()->addCssFile('/typo3conf/ext/dragdrop/Resources/Public/CSS/dragdrop.css');
			$GLOBALS['SOBE']->doc->getPageRenderer()->addJsFile('/typo3conf/ext/dragdrop/Resources/Public/JavaScript/dragdrop.js');
		}
		return parent::tt_content_drawColHeader($colName, $editParams, $newParams);
	}
}
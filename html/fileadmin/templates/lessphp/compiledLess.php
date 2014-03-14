<?php

/**
 * Userfunction for TYPO3 to compile a .less file into valid CSS. Uses the less.php libary. Documentation can be found on http://leafo.net/lessphp/docs/
 *
 * @author Steffen Frosch <steffen.frosch@itao.de> | itao GmbH & Co KG - Schulstr. 10 - 33330 Gütersloh - http://www.itao.de/
 */
include "lessc.inc.php"; // the less.php class

class user_compiledLess {

    /**
     * @param type $path path to .less and .css files
     * @param type $lessFileName 
     * @return string returns the path&file name of the css file
     */
    public function makeCSS($content, $conf) {
        //ToDo: Add exceptions 
        $lessFile = $conf['styleRoot'].$conf['lessFileName'];
        $cssFile = str_replace("less", "css", $lessFile);
        if (file_exists($cssFile)) {
            lessc::ccompile($lessFile, $cssFile); // compile .less file to .css if neccesary
        } else {
            // css file doesn't exist
            $cssFileContent = lessc::cexecute($lessFile); //compile less
            file_put_contents($cssFile, $cssFileContent['compiled']); //write css file
        }
        
        $styleSheet = '<link rel="stylesheet" href="'.$cssFile.'" media="all"/>';
        return $styleSheet;
    }

}

?>

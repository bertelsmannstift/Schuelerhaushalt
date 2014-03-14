To fix this Error: "PHP Fatal error:  Call to undefined method t3lib_div::view_array() in /srv/www/web-856/html/typo3conf/ext/crawler/class.tx_crawler_lib.php on line 1723"
when running the crawler queue task, I replaced t3lib_div::view_array  with t3lib_utility_Debug::viewArray() in the aforementioned file.

In the 3.2.0 version this Bug is still not fixed, in a later release it might be.
See this Bug for more information: http://forge.typo3.org/issues/13629

Philipp Hanebrink (itao GmbH & Co. KG, 2. Oct. 2012)
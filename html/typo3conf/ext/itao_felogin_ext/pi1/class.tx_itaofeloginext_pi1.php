<?php

class tx_itaofeloginext_pi1
{
    function msg_in_utf8($params, &$Obj)
    {
		$msg = $params['message'];
		if(mb_detect_encoding($msg) != "UTF-8") {
			$params['message'] = utf8_encode($msg);
		}
 
        return $params;
    }
}

?>
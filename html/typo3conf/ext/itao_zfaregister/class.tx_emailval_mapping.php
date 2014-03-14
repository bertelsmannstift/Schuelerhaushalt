<?php 
class tx_emailval_mapping { 
	
	function returnFieldJS() {	
		return 'var email = value; 
                var verif = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,3}$/ 
                if (verif.exec(email) == null) 
                       alert(unescape("Das ist keine g%FCltige E-Mail-Adresse!")); 
                return value;';
		
		
		/*	
   	return ' 
					   	var atpos=value.indexOf("@");
							var dotpos=value.lastIndexOf(".");
							if (atpos < 1 || dotpos < atpos+2 || dotpos+2 >= value.length) {
							  alert(unescape("Das ist keine g%FCltige E-Mail-Adresse!"));
							  return "";
						  } else {
			            return value;
			        }
          ';
          */
  }
	
	
	function evaluateFieldValue($value, $is_in, &$set) {
		if (t3lib_div::validEmail($value)) {
  		$value = $value;
  	} else {
  		$value = $value.' ist keine E-Mail-Adresse';
  	}
	  # return $value.' [added by PHP]';
	}

	
} 
?>
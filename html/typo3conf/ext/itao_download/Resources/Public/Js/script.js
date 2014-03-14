
function checkDelete(url, message) {
	question = window.confirm(message);
    if(question) {
    	document.location.href = url; 
    }
}

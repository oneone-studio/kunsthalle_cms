var HTTP = 'http';
var DOMAIN = 'http://kunsthalle-cms.dv';

function setSlug(inp) {
	var str = inp.value.trim();
	str = str.toLowerCase();
	str = str.split(" ").join('-');
	inp.value = str;
}

function submitById(id) {
	if($('#'+id) != undefined) {
		$('#'+id)[0].submit();
	}
}

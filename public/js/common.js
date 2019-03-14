var HTTP = 'http';
var DOMAIN = 'http://kunsthalle-cms.dv';

function setSlug(inp) {
	var str = inp.value
	str = str.toLowerCase();
	str = str.split(' ').join('-');
	inp.value = str;
}

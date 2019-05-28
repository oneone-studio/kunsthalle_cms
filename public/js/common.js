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

function validateSlug(inp, page_id, page_type, lang) {
	var slug = inp.value.trim();
	// inp.style.backgroundColor = '#ffffff';
	inp.style.border = '1px solid lightgray';
	inp.style.color = '#000000';
	if(slug.trim().length > 0 && !isNaN(page_id)) {
		$.ajax({
		    type: 'GET',
		    url: '/content/pages/check-slug',
		    data: { 'page_id': page_id, 'slug': slug, 'page_type': page_type, 'lang': lang },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('validateSlug('+slug+', '+page_type+', '+lang+') success'); console.log(data);
		    			if(data.is_valid != undefined && data.is_valid == false) {
		    				inp.style.color = 'red';
		    				inp.style.border = '1px solid red';
		    				inp.select();
		    			}
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('editPageSliderImage failed..');
		    	    }
		});
	}
}
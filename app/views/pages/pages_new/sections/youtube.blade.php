<div id="youtube_block" class="form-group edit-section" style="margin-top:20px;display:none;">
  <form method="POST" action="/youtube/save" accept-charset="UTF-8"><input name="_token" type="hidden">
    <label for="youtube" style="float:left;">Youtube</label>
    <div style="clear:both;height:10px;"></div>
    <div style="float:left;margin-top:6px;margin-right:8px;">Link:</div>
    <input placeholder="" style="width:780px;float:left;" name="url" type="text" id="youtube_url">

	<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
        <input class="btn btn-primary" style="position:relative;top:10px;left:37px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save">
    </div>
    <div style="clear:both;"></div>
    <img id="youtube_preview" src="#" style="max-width:100px;max-height:100px;position:relative;left:38px;border:none; display:none;">

    {{ Form::hidden('page_id', $page->id) }}
    {{ Form::hidden('menu_item_id', $menu_item_id) }}
    {{ Form::hidden('cs_id', $cs_id) }}
    {{ Form::hidden('youtube_id', 0, ['id' => 'youtube_id']) }}
  </form>  
</div>

<script>
function editYoutube(id, yUrl) {
	$('#youtube_id').val(id);
	$.ajax({
	    type: 'GET',
	    url: '/get-youtube',
	    data: { 'id': id, 'page_id': $('#page_id').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editYoutube success..');
	    			console.log(data);
	    			$('#youtube_preview').attr('src', 'https://i1.ytimg.com/vi/'+yUrl+'/default.jpg');
	    			$('#youtube_preview').show();
	    			$('#youtube_block').show();
	    			$("body").scrollTop(400);
	    			$('#youtube_url').focus();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editYoutube failed..');
	    	    }
	});
}
</script>
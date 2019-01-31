<div id="audio_block" class="form-group edit-section" style="margin-top:-20px;display:none;">
  <form method="POST" action="/audio/save" accept-charset="UTF-8"><input name="_token" type="hidden">
    <div class="edit-blk-top">
        <label for="audio" class="edit-hdr eh50">Audio</label>
        <div class="edit-icon-div"> <img src="/images/audio1.png" class="edit-icon edit-audio-icon"></div>
    </div>
    <div style="clear:both;height:10px;"></div>
    <div style="float:left;margin-top:6px;margin-right:8px;">Link:</div>
    <input placeholder="" style="width:600px;float:left;" name="url" type="text" id="audio_url">

	<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
        <input class="btn btn-primary" style="position:relative;top:10px;left:38px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save">
    </div>
    <div style="clear:both;"></div>
    <div id="audio_preview" style="width:345px;position:relative;left:38px;"></div>

    {{ Form::hidden('page_id', $page->id) }}
    {{ Form::hidden('menu_item_id', $menu_item_id) }}
    {{ Form::hidden('cs_id', $cs_id) }}
    {{ Form::hidden('audio_id', 0, ['id' => 'audio_id']) }}
  </form>  
</div>

<script>
function editAudio(id, aUrl) {
    scrollToMenu();
    $('#audio_id').val(id);
    $.ajax({
        type: 'GET',
        url: '/get-audio',
        data: { 'id': id, 'page_id': $('#page_id').val() },
        dataType: 'json',
        success:function(data) { 
                    console.log('editYoutube success..');
                    console.log(data);
                    $('#audio_preview').html('<iframe width="345" height="120" src="https://voicerepublic.com/embed/talks/'+aUrl+'" frameborder="0" scrolling="no" allowfullscreen></iframe>');
                    $('#audio_preview').show();
                    $('#audio_block').show();
                    $("body").scrollTop(400);
                    $('#audio_url').focus();
                },
        error:  function(jqXHR, textStatus, errorThrown) {
                    console.log('editYoutube failed..');
                }
    });
}
</script>
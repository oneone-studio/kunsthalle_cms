<div id="audio_block" class="form-group edit-section" style="margin-top:-20px;display:none;">
  <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
  <form id="audio_form" method="POST" action="/audio/save" accept-charset="UTF-8"><input name="_token" type="hidden">
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
    {{ Form::hidden('audio_id', 0, ['id' => 'audio_id']) }}
  </form>  
</div>

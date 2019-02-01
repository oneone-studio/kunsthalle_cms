<div id="youtube_block" class="form-group edit-section" style="margin-top:-20px;display:none;">
  <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
  <form method="POST" action="/youtube/save" accept-charset="UTF-8"><input name="_token" type="hidden">
	<div class="edit-blk-top">
	    <label for="youtube" class="edit-hdr eh60">Youtube</label>
	    <div class="edit-icon-div"> <img src="/images/youtube.png" class="edit-icon-20 edit-youtube-icon"></div>
    </div>
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

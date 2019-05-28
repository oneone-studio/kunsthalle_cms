<div style="width:130px; float:left;">Grid Image <a href="javascript:resetGridImageForm({{$image_grid->id}})" style="color:blue; display:inline; margin-left:5px; font-size:11px;">new</a>
</div>
<div id="image_pane" style="width:50%; float:left; display:inline;">
    <input type="file" name="grid_image" id="grid_image_{{$image_grid->id}}" style="vertical-align:top; margin-bottom:5px;"
      onchange="showGridImagePreview({{$image_grid->id}})">
    <br>
    <div style="clear:both;"></div>
    <div style="display:block;width:100%; height:120px; float:left; clear:both;">
	    <div id="preview_lbl_{{$image_grid->id}}" style="display:block;">Preview</div>
	    <div style="width:110px; height:100px; border:1px dashed #d2d2d2; display:inline-block; margin-bottom:5px;"><img 
	    id="preview_{{$image_grid->id}}" style="display:none; max-width:100px; max-height:100px; color:#e9e9e9; float:left;"></div>
    </div>
    <br>
    <div style="min-width:600px; position:relative; top:9px; clear:both;">
    <div style="width:130px; float:left;">URL</div>
    <input name="url" id="url_{{$image_grid->id}}" style="width:100%; height:40px;">
    </div>
    <br>
    <div style="width:100%; float:left; display:block">
	    <button id="grid_image_save_btn" class="button-success pure-button button-small" 
	    	onclick="saveGridImage(event, {{$image_grid->id}})" style="float:left;height:30px; padding:3px 15px 5px 15px;">Save Image</button>
	    <button id="cancel_grid_btn_{{$image_grid->id}}" class="button-error pure-button button-small" 
	      onclick="return hideGridImageForm({{$image_grid->id}})" style="float:left; margin-left:3px;height:30px; padding:3px 15px 5px 15px;">Cancel</button>
	</div>
    <input name="grid_image_id" id="grid_image_id_{{$image_grid->id}}" type="hidden">
</div>
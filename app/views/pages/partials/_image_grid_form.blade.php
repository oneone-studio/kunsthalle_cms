<div id="image_grid_lbl_{{$image_grid->id}}" 
  style="width:100%; font-size:12px;float:left;">Image Grid<a href="javascript:showGridImageForm({{$image_grid->id}})" 
  class="form-link" style="margin-left:5px;font-weight:normal;font-size:12px;">(Add Image)</a>
   <a href="javascript:deleteImageGrid({{$image_grid->id}})" title="Delete" type="button" 
	class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:2px;"><span class="glyphicon glyphicon-trash"></span></a> 
</div>
<div style="width:100%; display:block; float:left; margin:10px 0px 15px 0px;">
	<input name='url' id="image_grid_inp_{{$image_grid->id}}" value="{{ $image_grid->title }}" class="no-display"
	style="width:340px; float:left;">
</div>
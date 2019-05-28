<div id="slider_lbl_{{$slider->id}}" 
	 style="width:100%; font-size:12px;float:left;">Image Slider<a href="javascript:showSliderImageForm({{$slider->id}}, true)" class="form-link"
	 style="margin-left:5px;font-weight:normal;font-size:12px;">(Add Image)</a>
	  <a href="javascript:deleteImageSlider({{$slider->id}})" title="Delete" type="button" class="icon-fixed-width icon-trash" 
	  	style="margin-left:5px; vertical-align:bottom; position:relative;top:2px;"><span class="glyphicon glyphicon-trash"></span></a> 
</div>
<div style="width:100%; display:block; float:left; margin:10px 0px 15px 0px;">
 <input name='title' id="slider_inp_{{$slider->id}}" value="{{ $slider->title }}" class="no-display" style="width:340px; float:left;">
 <select name="sort_order" id="slider_sort_order_{{$slider->id}}" style="width:50px; float:left; display:none; margin-left:3px; margin-top:3px;">
<?php 
      for($c=1; $c<=$sort_limit; $c++) { 
   		$sel = '';
   		if($slider->sort_order == $c) { $sel = ' selected="selected"'; } ?>
   			<option value="<?php echo $c;?>" <?php echo $sel;?> ><?php echo $c; ?> </option>
<?php } ?>
 </select>
</div>
<div style="width:130px; float:left;">Slider Image <a href="javascript:resetPageSliderImageForm({{$slider->id}})" style="color:blue; display:inline; margin-left:5px; font-size:11px;">new</a>
</div>
<div id="image_pane_{{$slider->id}}" style="width:50%; float:left; display:inline;">
    <input type="file" name="gallery_image" id="gallery_image_{{$slider->id}}" style="vertical-align:top; margin-bottom:5px;"
      onchange="showPageSliderImagePreview({{$slider->id}})">
    <br>
    <div style="clear:both;"></div>
    <div style="display:block;width:100%; height:120px; float:left; clear:both;">
	    <div id="preview_lbl_{{$slider->id}}" style="display:block;">Preview</div>
	    <div style="width:110px; height:100px; border:1px dashed #d2d2d2; display:inline-block; margin-bottom:5px;"><img id="preview_{{$slider->id}}" style="display:none; max-width:100px; max-height:100px; color:#e9e9e9; float:left;"></div>
    </div>
    <br>
    <div style="min-width:600px; position:relative; top:9px; clear:both;">
    	<textarea name="image_detail_de" id="_image_detail_de_{{$slider->id}}" class="tm_editor" 
       style="width:100%; height:40px;"></textarea>
    	<div class="inp-de">DE</div><br/>
    	<div style="clear:both;margin-top:20px;"></div>
    	<textarea name="image_detail_en" id="_image_detail_en_{{$slider->id}}" class="tm_editor" 
       style="width:100%; height:40px;"></textarea>
    	<div class="inp-en">EN</div><br/>
    </div>
    <div style="clear:both;margin-top:20px;"></div>
    <div style="float:left;margin-top:6px;margin-right:8px;">Order:</div>
    <input type="number" style="width:80px;float:left;" name="sort_order" type="text" id="sl_img_order_{{$slider->id}}">
    <br>
    <div style="width:100%; float:left; display:block">
	    <input type="button" id="gallery_image_save_btn" class="button-success pure-button button-small" onclick="savePageSliderImage(event, {{$slider->id}})" style="float:left;" value="Save Image" />
	    <input type="button" id="cancel_slider_btn_{{$slider->id}}" class="button-error pure-button button-small" 
	      onclick="hideSliderImageForm( {{$slider->id}})" style="float:left; margin-left:3px;padding-top:2px" value="Cancel" />
	</div>
    <input name="image_id" id="image_id_{{$slider->id}}" type="hidden">
    <input name="image_detail_de" id="image_detail_de_{{$slider->id}}" type="hidden">
    <input name="image_detail_en" id="image_detail_en_{{$slider->id}}" type="hidden">
</div>
<div id="slider_image_{{$sl_image->id}}" class="slider_image_list_blk">
    						<a href="javascript:deletePageSliderImage({{$sl_image->id}})" title="Delete" type="button" 
    						class="icon-fixed-width icon-trash" class="slider_image_del_list_blk"><span class="glyphicon glyphicon-trash"></span></a>
    						<a href="javascript:editPageSliderImage({{$slider->id}}, {{$sl_image->id}})"><img id="slider_img_{{$sl_image->id}}" src="{{$DOMAIN}}/files/sliders/{{$sl_image->filename}}" style="max-width:90px; max-height:60px;"></a></div>
	<!-- ////////////////////   IMAGE SLIDER   ////////////////////// -->
	<?php $display = 'display:none;'; 
		  if($action == 'new_slider') { $display = ''; }
	?>

	<div id="page_image_slider" class="form-group edit-section" style="margin:20px 0px; <?php echo $display;?>">
       <div style="width:100%; clear:both; margin-bottom:15px;">
         <div id="page_image_slider_pane" style="width:100%;">
		  {{ Form::open(array('route' => 'page_image_sliders.store', 'method' => 'post')) }}

			{{ Form::label('slider_title', 'Image Slider') }}

		    <div id="slider_title"></div>
		    {{ Form::submit('Create New Slider', array('id' => 'save_image_slider_btn',
		    	'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
		    {{ Form::button('Cancel', array('id' => 'cancel_slider_btn', 'onclick' => 'cancelPageImageSlider()', 'class' => 'button-error pure-button button-small', 		'style' => 'height:30px;margin-top:1px; padding:3px 15px 5px 15px')) }}

		    {{ Form::hidden('page_id', $page->id) }}
		    {{ Form::hidden('cs_id', $cs_id) }}
		    {{ Form::hidden('menu_item_id', $menu_item_id) }}

		  {{ Form::close() }}

		</div>  

	    
	    <!-- <a href="javascript:showNewSliderForm()" style="font-size:11px; font-weight:normal;">Image Slider</a><br> -->
        @if(count($page->page_image_sliders) > 0)
            <?php $slider_cnt = 0; 
            	  $display = 'display:none;';	
            ?>
	        <ul style="width:580px; list-style:none; margin-left:0; margin-top:10px; padding-left:0;">
		    	@foreach($page->page_image_sliders as $slider)
		    	    <?php 
		    	    // echo '<h3 style="color:red;">SL: '. $slider->id . '</h3>';
		    	    ++$slider_cnt;	
		    	    if($action == 'new_slider' && $slider_cnt == count($page->page_image_sliders)) { $display = ''; }					    	          
		    	    ?>

		    		<li id="slider_blk_{{$slider->id}}" class="slider-blk" style="width:580px; <?php echo $display;?>">
		    		  <form id="image_slider_form_<?php echo $slider->id;?>" method="post" action="">
		    		   <div id="slider_lbl_{{$slider->id}}" 
		    		  	  style="width:100%; font-size:12px;float:left;">Image Slider<a href="javascript:showSliderImageForm({{$slider->id}})" class="form-link"
		    		  	    style="margin-left:5px;font-weight:normal;font-size:12px;">(Add Image)</a>
		    		  	   <a href="javascript:deleteImageSlider({{$slider->id}})" title="Delete" type="button" 
	    						class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:2px;"><span class="glyphicon glyphicon-trash"></span></a> 
		    		   </div>
		    		   <div style="width:100%; display:block; float:left; margin:10px 0px 15px 0px;">
		    		     <input name='title' id="slider_inp_{{$slider->id}}" value="{{ $slider->title }}" class="no-display"
		    			 style="width:340px; float:left;">
		    			 <select name="sort_order" id="slider_sort_order_{{$slider->id}}" style="width:50px; float:left; display:none; margin-left:3px; margin-top:3px;">
		    			   <?php for($c=1; $c<=$sort_limit; $c++) { 
		    			   			$sel = '';
		    			   			if($slider->sort_order == $c) { $sel = ' selected="selected"'; }
		    			   	?>
		    			   			<option value="<?php echo $c;?>" <?php echo $sel;?> ><?php echo $c; ?> </option>
		    			   <?php } ?>
		    			 </select>
		    		   </div>	
		    		  </form>
		    		</li>
		    		<li id="slider_pane_{{$slider->id}}" class="no-display" style="padding:10px 0px;">
		    		  <div style="width:100%; clear:both;">
		    		  	<button id="slider_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
		    		  </div>
		    		  <div id="slider_image_form_blk_<?php echo $slider->id;?>" style="width:100%; background:#f7f7f7; display:none; clear:both;">
					   <form id="slider_image_form_<?php echo $slider->id;?>" enctype="multipart/form-data" method="post" action="">

					    <div style="width:130px; float:left;">Slider Image <a href="javascript:resetPageSliderImageForm()" style="color:blue; display:inline; margin-left:5px; font-size:11px;">new</a></div>
					    <div id="image_pane" style="width:50%; float:left; display:inline;">
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
						    <textarea name="_image_detail_{{$slider->id}}" id="_image_detail_{{$slider->id}}" class="tm_editor" 
						       style="width:100%; height:40px;"></textarea>
						    </div>
						    <div style="clear:both;margin-top:20px;"></div>
						    <div style="float:left;margin-top:6px;margin-right:8px;">Order:</div>
						    <input type="number" style="width:80px;float:left;" name="sort_order" type="text" id="sl_img_order_{{$slider->id}}">
						    <br>
						    <div style="width:100%; float:left; display:block">
							    <button id="gallery_image_save_btn" class="button-success pure-button button-small" onclick="savePageSliderImage(event, {{$slider->id}})" style="float:left;">Save Image</button>
							    <button id="cancel_slider_btn_{{$slider->id}}" class="button-error pure-button button-small" 
							      onclick="hideSliderImageForm( {{$slider->id}})" style="float:left; margin-left:3px;">Cancel</button>
							</div>
						    <input name="image_id" id="image_id_{{$slider->id}}" type="hidden">
						    <input name="image_detail" id="image_detail_{{$slider->id}}" type="hidden">
					    </div>
						<!-- <div id="slide_image_list" class="form-group nl2"></div> -->
					    {{ Form::hidden('id', $page->id) }}
					    {{ Form::hidden('cs_id', $cs_id) }}
					    {{ Form::hidden('slider_id', $slider->id) }}
					    {{ Form::hidden('slider_image_id', 0)}}
					  
					  </form>
					 </div>
	    			</li>

	    			<li id="slider_image_list_blk_{{$slider->id}}" class="slider-images-blk" style="padding:10px 0px; {{$display}}">
	    			   <div id="slider_image_list_{{$slider->id}}" style="width:100%; margin-top:5px; display:block; clear:both;">
	    				<a href="javascript:reloadPage()" style="font-size:11px;color:blue;margin:10px 0;">Refresh</a><br>
	    				@if($slider->page_slider_images)
	    					@foreach($slider->page_slider_images as $sl_image)
	    						<div id="slider_image_{{$sl_image->id}}" style="width:90%; font-family:georgia; font-size:14px; 
	    							font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">
	    						<a href="javascript:deletePageSliderImage({{$sl_image->id}})" title="Delete" type="button" 
	    						class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:6px;"><span class="glyphicon glyphicon-trash"></span></a>
	    						<a href="javascript:editPageSliderImage({{$slider->id}}, {{$sl_image->id}})"><img src="{{$DOMAIN}}/files/sliders/{{$sl_image->filename}}" style="max-width:90px; max-height:60px;"></a></div>
	    					@endforeach
	    				@endif
	    			   </div>
	    			</li>

	    	@endforeach
	    </ul>
	 @endif
	</div>
</div>

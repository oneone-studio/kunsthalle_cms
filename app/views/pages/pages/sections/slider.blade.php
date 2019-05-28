<!-- ////////////////////   IMAGE SLIDER   ////////////////////// -->
<?php $display = 'display:none;'; 
	  if($action == 'new_slider') { $display = ''; }
?>
<div id="page_image_slider_block" class="form-group edit-section" style="margin:-20px 0px; <?php echo $display;?>">
   <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
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
	    		   	 @include('pages.partials._image_slider_form')
	    		  </form>
	    		</li>
	    		<li id="slider_pane_{{$slider->id}}" class="no-display" style="padding:10px 0px;">
	    		  <div style="width:100%; clear:both;">
	    		  	<button id="slider_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
	    		  </div>
	    		  <div id="slider_image_form_blk_<?php echo $slider->id;?>" style="width:100%; background:#f7f7f7; display:none; clear:both;">
				   <form id="slider_image_form_<?php echo $slider->id;?>" enctype="multipart/form-data" method="post" action="">
				    @include('pages.partials._slider_image_form')
					
				    {{ Form::hidden('id', $page->id) }}
				    {{ Form::hidden('cs_id', $cs_id) }}
				    {{ Form::hidden('slider_id', $slider->id) }}
				    <input type="hidden" name='slider_image_id' id="slider_image_id_{{$slider->id}}" value="0">				 
				  </form>
				 </div>
    			</li>

    			<li id="slider_image_list_blk_{{$slider->id}}" class="slider-images-blk" style="padding:10px 0px; {{$display}}">
    			   <div id="slider_image_list_{{$slider->id}}" style="width:100%; margin-top:5px; display:block; clear:both;">
    				<a href="javascript:reloadPage()" style="font-size:11px;color:blue;margin:10px 0;">Refresh</a><br>
    				@if($slider->page_slider_images)
    					@foreach($slider->page_slider_images as $sl_image)
    						@include('pages.partials._slider_image_list')
    					@endforeach
    				@endif
    			   </div>
    			</li>

    	@endforeach
    </ul>
 @endif
</div>
</div>
<div style="clear:both;"></div>
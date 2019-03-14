<!-- ////////////////////   IMAGE GRID   ////////////////////// -->
<?php $display = 'display:none;';
	  if($action == 'image_grid') { $display = ''; $cur_block_id = 'image_grid_block'; }
?>
<div id="image_grid_block" class="form-group edit-section" style="margin:20px 0px; <?php echo $display;?>">
    <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
    <div style="width:100%; clear:both; margin-bottom:15px;">
     <div id="igp" style="width:100%;">
	  {{ Form::open(array('route' => 'exb_image_grid.store', 'method' => 'post')) }}

		<div class="edit-blk-top">
			<label class="edit-hdr eh90">Image Grid </label>
			<div class="edit-icon-div"> <img src="/images/new_image.png" class="edit-icon edit-imagegrid-icon"></div>
		</div>	
	    <div id="grid_title"></div>
	    {{ Form::submit('Create Image Grid', array('id' => 'save_image_grid_btn',
	    	'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
	    {{ Form::button('Cancel', array('id' => 'cancel_grid_btn', 'onclick' => 'cancelImageGrid()', 'class' => 'button-error pure-button button-small', 		'style' => 'height:30px;margin-top:1px; padding:3px 15px 5px 15px')) }}

	    {{ Form::hidden('page_id', $page->id) }}
	  {{ Form::close() }}
	</div>  
    @if(count($page->image_grids) > 0)
        <?php $grid_cnt = 0; $display = 'display:none;';	
        ?>
        <ul class="image_grid_ul">
	    	@foreach($page->image_grids as $image_grid)
	    	    <?php 
	    	    ++$grid_cnt;	
	    	    if($action == 'image_grid' && $grid_cnt == count($page->image_grids)) { $display = ''; }					    	          
	    	    ?>
	    		<li id="image_grid_blk_{{$image_grid->id}}" class="image-grid-blk" style="width:580px; position:relative;top:25px; <?php echo $display;?>">
	    		  <form id="image_grid_form_{{$image_grid->id}}" method="post" action="">
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
	    		  </form>
	    		</li>
	    		<li id="image_grid_block_{{$image_grid->id}}" class="no-display" style="padding:10px 0px;">
	    		  <div style="width:100%; clear:both;">
	    		  	<button id="grid_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
	    		  </div>
	    		  <div id="grid_image_form_blk_{{$image_grid->id}}" style="width:100%; background:#f7f7f7; display:none; clear:both;">
				   <form id="grid_image_form_{{$image_grid->id}}" enctype="multipart/form-data" method="post" action="">

				    <div style="width:130px; float:left;">Grid Image <a href="javascript:resetGridImageForm()" style="color:blue; display:inline; margin-left:5px; font-size:11px;">new</a></div>
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
					    <!-- <div style="clear:both;margin-top:20px;"></div>
					    <div style="float:left;margin-top:6px;margin-right:8px;">Order:</div>
					    <input type="number" style="width:80px;float:left;" name="sort_order" type="text" id="sl_img_order_{{$image_grid->id}}"> -->
					    <br>
					    <div style="width:100%; float:left; display:block">
						    <button id="grid_image_save_btn" class="button-success pure-button button-small" 
						    	onclick="saveGridImage(event, {{$image_grid->id}})" style="float:left;height:30px; padding:3px 15px 5px 15px;">Save Image</button>
						    <button id="cancel_grid_btn_{{$image_grid->id}}" class="button-error pure-button button-small" 
						      onclick="return hideGridImageForm({{$image_grid->id}})" style="float:left; margin-left:3px;height:30px; padding:3px 15px 5px 15px;">Cancel</button>
						</div>
					    <input name="grid_image_id" id="grid_image_id_{{$image_grid->id}}" type="hidden">
				    </div>
				    {{ Form::hidden('page_id', $page->id) }}
				    {{ Form::hidden('image_grid_id', $image_grid->id)}}				  
				  </form>
				 </div>
    			</li>

    			<li id="grid_image_list_blk_{{$image_grid->id}}" class="grid-images-blk grid-image-list-blk">
    			   <div id="grid_image_list_{{$image_grid->id}}" class="grid-image-list">
    				<a href="javascript:reloadPage()" class="image-grid-refresh">Refresh</a><br>
    				@if($image_grid->grid_images)
    					@foreach($image_grid->grid_images as $grd_image)
    						<div id="grid_image_li_{{$grd_image->id}}" class="grid-image-li">
    						<a href="javascript:deleteGridImage({{$grd_image->id}})" title="Delete" type="button" 
    						class="icon-fixed-width icon-trash trash"><span class="glyphicon glyphicon-trash"></span></a>
    						<a href="javascript:editGridImage({{$image_grid->id}}, {{$grd_image->id}})"><img src="{{$DOMAIN}}/files/grid_image/{{$grd_image->filename}}" class="grid-img"></a></div>
    					@endforeach
    				@endif
    			   </div>
    			</li>

    	@endforeach
    </ul>
 @endif
</div>
</div>

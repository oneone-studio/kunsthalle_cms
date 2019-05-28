<!-- ////////////////////   IMAGE GRID   ////////////////////// -->
<?php $display = 'display:none;'; 
	  // if($action == 'image_grid') { $display = ''; $cur_block_id = 'image_grid_block'; }
?>
<div id="image_grid_block" class="form-group edit-section" style="margin:20px 0px; <?php echo $display;?>">
	<div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
    <div style="width:100%; clear:both; margin-bottom:15px;">
     <div id="igp" style="width:100%;">
	  {{ Form::open(array('route' => 'image_grid.store', 'method' => 'post')) }}

		<div class="edit-blk-top">
			<label class="edit-hdr eh90">Image Grid </label>
			<div class="edit-icon-div"> <img src="/images/new_image.png" class="edit-icon edit-imagegrid-icon"></div>
		</div>	
	    <div id="grid_title"></div>
	    {{ Form::submit('Create Image Grid', array('id' => 'save_image_grid_btn',
	    	'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
	    {{ Form::button('Cancel', array('id' => 'cancel_grid_btn', 'onclick' => 'cancelImageGrid()', 'class' => 'button-error pure-button button-small', 		'style' => 'height:30px;margin-top:1px; padding:3px 15px 5px 15px')) }}

	    {{ Form::hidden('page_id', $page->id) }}
	    {{ Form::hidden('cs_id', $cs_id) }}
	    {{ Form::hidden('menu_item_id', $menu_item_id) }}
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
	    		<li id="image_grid_blk_{{$image_grid->id}}" class="image-grid-blk" style="width:580px; <?php echo $display;?>">
	    		  <form id="image_grid_form_{{$image_grid->id}}" method="post" action="">
	    		   @include('pages.partials._image_grid_form')	
	    		  </form>
	    		</li>
	    		<li id="image_grid_block_{{$image_grid->id}}" class="no-displayz" style="padding:10px 0px; <?php echo $display;?>">
	    		  <div style="width:100%; clear:both;">
	    		  	<button id="grid_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
	    		  </div>
	    		  <div id="grid_image_form_blk_{{$image_grid->id}}" style="width:100%; background:#f7f7f7; display:none; clear:both;">
				   <form id="grid_image_form_{{$image_grid->id}}" enctype="multipart/form-data" method="post" action="">
				    @include('pages.partials._grid_image_form')

				    {{ Form::hidden('page_id', $page->id) }}
				    {{ Form::hidden('cs_id', $cs_id) }}
				    {{ Form::hidden('menu_item_id', $menu_item_id) }}
				    {{ Form::hidden('image_grid_id', $image_grid->id)}}				  
				  </form>
				 </div>
    			</li>

    			<li id="grid_image_list_blk_{{$image_grid->id}}" class="grid-images-blk grid-image-list-blk">
    			   <div id="grid_image_list_{{$image_grid->id}}" class="grid-image-list">
    				<a href="javascript:reloadPage()" class="image-grid-refresh">Refresh</a><br>
    				@if($image_grid->grid_images)
    					@foreach($image_grid->grid_images as $grd_image)
    						@include('pages.partials._grid_images')
    					@endforeach
    				@endif
    			   </div>
    			</li>

    	@endforeach
    </ul>
 @endif
</div>
</div>

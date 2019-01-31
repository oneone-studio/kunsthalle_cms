<!-- ////////////////////   IMAGE GRID   ////////////////////// -->
<?php $display = 'display:none;'; 
	  if($action == 'image_grid') { $display = ''; }
?>
<div id="image_grid_pane" class="form-group edit-section" style="margin:20px 0px; <?php echo $display;?>">
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
	    		   <div id="image_grid_lbl_{{$image_grid->id}}" 
	    		  	  style="width:100%; font-size:12px;float:left;">Image Grid<a href="javascript:showGridImageForm({{$image_grid->id}})" class="form-link"
	    		  	    style="margin-left:5px;font-weight:normal;font-size:12px;">(Add Image)</a>
	    		  	   <a href="javascript:deleteImageGrid({{$image_grid->id}})" title="Delete" type="button" 
    						class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:2px;"><span class="glyphicon glyphicon-trash"></span></a> 
	    		   </div>
	    		   <div style="width:100%; display:block; float:left; margin:10px 0px 15px 0px;">
	    		     <input name='url' id="image_grid_inp_{{$image_grid->id}}" value="{{ $image_grid->title }}" class="no-display"
	    			 style="width:340px; float:left;">
	    		   </div>	
	    		  </form>
	    		</li>
	    		<li id="image_grid_pane_{{$image_grid->id}}" class="no-displayz" style="padding:10px 0px; <?php echo $display;?>">
	    		  <div style="width:100%; clear:both;">
	    		  	<button id="grid_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
	    		  </div>
	    		  <div id="grid_image_form_blk_{{$image_grid->id}}" style="width:100%; background:#f7f7f7; display:none; clear:both;">
				   <form id="grid_image_form_{{$image_grid->id}}" enctype="multipart/form-data" method="post" action="">

				    <div style="width:130px; float:left;">Grid Image <a href="javascript:resetGridImageForm({$image_grid->id}})" style="color:blue; display:inline; margin-left:5px; font-size:11px;">new</a></div>
				    <div id="image_paneZz" style="width:50%; float:left; display:inline;">
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
						    	onclick="saveGridImage(event, {{$image_grid->id}})" style="float:left;height:30px; padding:3px 15px 5px 15px">Save Image</button>
						    <button id="cancel_grid_btn_{{$image_grid->id}}" class="button-error pure-button button-small" 
						      onclick="return hideGridImageForm({{$image_grid->id}})" style="float:left; margin-left:3px;height:30px; padding:3px 15px 5px 15px">Cancel</button>
						</div>
					    <input name="grid_image_id" id="grid_image_id_{{$image_grid->id}}" type="hidden">
				    </div>
				    {{ Form::hidden('page_id', $page->id) }}
				    {{ Form::hidden('cs_id', $cs_id) }}
				    {{ Form::hidden('menu_item_id', $menu_item_id) }}
				    {{ Form::hidden('image_grid_id', $image_grid->id)}}				  
				  </form>
				 </div>
    			</li>

    			<li id="grid_image_list_blk_{{$image_grid->id}}" class="grid-images-blk" style="padding:10px 0px; {{$display}}">
    			   <div id="grid_image_list_{{$image_grid->id}}" style="width:100%; margin-top:5px; display:block; clear:both;">
    				<a href="javascript:reloadPage()" style="font-size:11px;color:blue;margin:10px 0;">Refresh</a><br>
    				@if($image_grid->grid_images)
    					@foreach($image_grid->grid_images as $grd_image)
    						<div id="grid_image_li_{{$grd_image->id}}" style="width:90%; font-family:georgia; font-size:14px; 
    							font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">
    						<a href="javascript:deleteGridImage({{$grd_image->id}})" title="Delete" type="button" 
    						class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:6px;"><span class="glyphicon glyphicon-trash"></span></a>
    						<a href="javascript:editGridImage({{$image_grid->id}}, {{$grd_image->id}})"><img src="{{$DOMAIN}}/files/grid_image/{{$grd_image->filename}}" style="max-width:90px; max-height:60px;"></a></div>
    					@endforeach
    				@endif
    			   </div>
    			</li>

    	@endforeach
    </ul>
 @endif
</div>
</div>
<script>
function hideImageGridForm(id) {
	$('#image_grid_pane_'+id).addClass('no-display');
	$('#grid_image_form_blk_'+id).hide();
}

function editGridImage(image_grid_id, id) {
	scrollToMenu();
	$('#grid_image_id_'+image_grid_id).val(id);
	showSliderImageForm(image_grid_id);

	$('#grid_image_save_btn').attr('onclick', 'updateGridImage(event, '+image_grid_id+')');
	$.ajax({
	    type: 'GET',
	    url: '/get-grid-image',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editGridImage success..'+ "\n\n");
	    			console.log(data);
	    			showGridImageForm(image_grid_id);
	    			$('#url_'+image_grid_id).val(data.image.url);
	    			$('#preview_lbl_'+image_grid_id).hide('');
	    			$('#preview_'+image_grid_id).prop('src', DOMAIN + data.image.path + data.image.filename);
	    			$('#preview_'+image_grid_id).show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editGridImage failed.. ');
	    	    }
	});
}

function hideGridImageForm() {
	$('.edit-section').hide();
	return false;
}

function saveGridImage(event, id) {
	event.preventDefault();
	var frm = document.getElementById('grid_image_form_'+id);
	var formData = new FormData(frm);
	console.log(formData);
	$.ajax({
	    type: 'POST',
	    url: '/save-grid-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('saveGridImage Success..'+ "\n\n");
	    			console.log(data);
	    			$('#grid_image_form_'+id)[0].reset();
	    			$('#preview_'+id).hide();
	    			hideNewSliderImageForm();
	    			$('#grid_image').val('');
	    			var list = '<div style="width:100%; display:block; clear:both;">';
	    			var list2 = '';
	    			var img = null;
	    			for(i=0; i<data.images.length; i++) {
	    				img = data.images[i];
	    				list += '<div id="grid_image_'+img.id+'" style="width:90%; font-family:georgia; font-size:14px;' +
					'font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">' +
					'<a href="javascript:deleteGridImage('+img.id+')" title="Delete" type="button" ' +
					' class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:6px;"><span class="glyphicon glyphicon-trash"></span></a>' +
					'<a href="javascript:editGridImage('+id+', '+img.id+')"><img src="'+DOMAIN+'/files/grid_image/'+img.filename+
						'" style="max-width:90px; max-height:60px;"></a></div>';
	    			}
	    			list += '</div>';
	    			$('#grid_image_list_'+id).html(list);
	    			var html = '';
	    			if(data.images.length > 0) {
	    				img = data.images[data.images.length-1];
	    				html = '<div style="width:60px; float:left; border:1px solid #d9d9d9;margin-right:5px;">'+
					  			 '<img src="/files/grid_image/'+img.filename+'" style="max-width:60px;border:none;">'+
					  		   '</div>';
					  	$('#image_grid_val_'+id).append(html);	   
	    			}


				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('saveGridImage Failed.. ');
	    	    }
	});
}

function deleteGridImage(id) {
	// if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-grid-image',
		    data: { 'id' : id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deleteGridImage success..');
		    			var list = $('#image_list');
		    			$('#grid_image_blk_item_'+id).hide();
		    			$('#grid_image_li_'+id).hide();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deleteGridImage Failed.. ');
		    	    }
		});
	// }
}

function updateGridImage(event, id) {
	event.preventDefault();
	var frm = document.getElementById('grid_image_form_'+id);
	var formData = new FormData(frm);
	console.log(formData);
	$.ajax({
	    type: 'POST',
	    url: '/update-grid-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    	console.log("updateGridImage success..");
	    	console.log(data);
			hideNewSliderImageForm();
			$('#preview_'+id).hide();
			$('#image_id').val('');
			// setTextareaContent('_image_detail_'+id, '');
			$('#gi_'+id).prop('src', DOMAIN + '/images/grid/' + data.item.image);
			// $('#desc_'+id).html(data.item.detail.substr(0, 10) + '...');
			$('#grid_image_save_btn').attr('onclick', 'saveGridImage(event, '+lastSliderId+')');

			$('#grid_image_form_'+id)[0].reset();
			$("#grid_image_status_msg").removeClass('btn-danger').removeClass('btn-info').addClass('btn-success');
			$("#grid_image_status_msg").html('Image detail updated..');
			$('#grid_image_status_msg').hide().delay(20).fadeIn('slow');
			$('#grid_image_status_msg').hide().delay(5000).fadeOut(2500);
			return;
		},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('updateGridImage failed..');
	    	    }
	});
}

var cur_image_grid_id = 0;

function editImageGrid(id) {
	scrollToMenu();
	resetCurBlockId();
	$('.edit-section').hide();
	$('.image_grid_ul').show();
	$('.image-grid-blk').hide();
	$('.grid-images-blk').hide();
	if(cur_image_grid_id > 0) {
		$('#image_grid_blk_'+cur_image_grid_id).hide();
		$('#grid_image_list_blk_'+cur_image_grid_id).hide();
	}
	cur_image_grid_id = id;
	$('#image_grid_blk_'+id).show();
	$('#image_grid_pane_'+id).removeClass('no-display').show();
	$('#grid_image_list_blk_'+id).show();
	$('#image_grid_pane').show();
}

var lastImageGridId = 0;
function showGridImageForm(id) {
	if(lastImageGridId > 0 && $('#image_grid_pane_'+lastImageGridId)) {
		$('#image_grid_pane_'+lastImageGridId).addClass('no-display');
	}
	image_grid_pane_ = id;
	$('#image_grid_blk_'+id).show();
	$('#image_grid_pane_'+id).removeClass('no-display').show();
	$('#grid_image_form_blk_'+id).removeClass('no-display').show();
	$('#image_grid_pane').removeClass('no-display').show();
}

function showGridImagePreview(id) {
	var frm = document.getElementById('grid_image_form_'+id);
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/grid-image-preview',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('showGridImagePreview success..');
	    			console.log(data);
	    			$('#preview_lbl_'+id).hide('');
	    			$('#preview_'+id).prop('src', DOMAIN + data.preivew);
	    			$('#preview_'+id).show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('showGridImagePreview failed..');
	    	    }
	});
}

function resetGridImageForm(id) {
	$('#grid_image_form_'+id)[0].reset();
}

function reloadPage() {
	location.reload();
}

</script>


@extends('layouts.default')


@section('content')


	<?php
	  // echo '<pre>'; print_r($exhibition); exit;

	  /*	
		$event_ids = [];
		foreach($exhibition->k_events as $e) {
			$event_ids[] = $e->id;
		}		
		// echo 'INFO: '; print_r($event_ids); exit;
		/**/
	?>
    <div class="page_content">
      <h3>Exhibition</h3>
      <p>
		<ul style="list-style:none;">
		{{ Form::open(array('route' => 'exhibition.update', 'method' => 'post', 'files' => true)) }}
		    
		<!-- {{ Form::model($exhibition, array('route' => array('exhibitions.edit', $exhibition->id))) }} -->
		    
			<div class="form-group" class="nl">
			    <label for="title">{{ Form::label('title', 'Title (de):') }}</label>
			    {{ Form::textarea('title_de', $exhibition->title_de, ['style' => 'width:800px; height:40px;', 'placeholder' => 'de']) }}<br>
			    <label for="title">{{ Form::label('title', 'Title (en):') }}</label>
			    {{ Form::textarea('title_en', $exhibition->title_en, ['style' => 'width:800px; height:40px;', 'placeholder' => 'en']) }}
			</div>
			<div class="form-group">
			    <label for="subtitle">{{ Form::label('subtitle', 'Subtitle (de):') }}</label>
			    {{ Form::textarea('subtitle_de', $exhibition->subtitle_de, ['style' => 'width:800px; height:50px;', 'placeholder' => 'de']) }}<br>
			    <label for="subtitle">{{ Form::label('subtitle', 'Subtitle (de):') }}</label>
			    {{ Form::textarea('subtitle_en', $exhibition->subtitle_en, ['style' => 'width:800px; height:50px;', 'placeholder' => 'en']) }}
			</div>

			<div class="form-group" class="nl">
			    <label for="exampleInputEmail1">{{ Form::label('content_de', 'Content (de)') }}</label>
			    {{ Form::textarea('content_de', $exhibition->content_de, ['style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'de']) }}<br>
			    <label for="exampleInputEmail1">{{ Form::label('content_de', 'Content (en)') }}</label>			    
			    {{ Form::textarea('content_en', $exhibition->content_en, ['style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'en']) }}
			</div>
<!-- 			<div class="form-group" class="nl">
			    <label for="exampleInputEmail1">{{ Form::label('gallery_id', 'gallery_id:') }}</label>
			    {{ Form::number('gallery_id', 0) }}
			</div> -->
<!-- 			<div class="form-group" class="nl">
			    <label for="exampleInputEmail1">{{ Form::label('meta_tag', 'meta_tag:') }}</label>
			    {{ Form::text('meta_tag') }}
			</div>
 -->			<div class="form-group" class="nl">
			    <label for="start_date">{{ Form::label('start_date', 'Start date:') }}</label>
			    {{ Form::text('start_date') }}
			</div>
			<div class="form-group" class="nl">
			    <label for="end_date">{{ Form::label('end_date', 'End date:') }}</label>
			    {{ Form::text('end_date') }}
			</div>

			<div class="form-group">
			    <label for="cluster">{{ Form::label('cluster', 'Cluster:') }}</label>
			    <select name="cluster" data-placeholder="Choose a cluster" class="chosen-select" style="width:300px;" tabindex="4">
			        <option value=""></option>
        	<?php foreach($clusters as $cl): 
        			 $selected = '';
        			 if(isset($exhibition->cluster->id) && $exhibition->cluster->id == $cl->id) {
        			 	$selected = ' selected="selected"';
        			 }
        	?>
			        <option value="<?php echo $cl->id;?>" <?php echo $selected;?>><?php echo $cl->id . ' - '.$cl->title_en; ?> </option>
        	<?php endforeach; ?>
			    </select>
			</div>

			<div class="form-group nl2">
			    <div style="width:130px; float:left;">Gallery Image <a href="javascript:resetGalleryImageForm()" style="color:blue; display:inline; margin-left:5px; font-size:11px;">new</a></div>
			    <div id="image_pane" style="width:50%; float:left; display:inline;">
				    {{ Form::file('gallery_image', ['id' => 'gallery_image', 'style' => 'vertical-align:top; margin-bottom:5px;', 'onchange' => 'showGalleryImagePreview()']) }}
				    <br>
				    {{ Form::textarea('_image_detail', null, ['id' => '_image_detail', 'class' => 'tm_editor', 'placeholder' => 'Description', 'style' => "width:100%; height:40px;"]) }}
				    <br>
				    <div style="width:100%; float:left; clear:both;">
					    <div style="width:110px; height:100px; border:1px dashed #d2d2d2; display:inline-block; margin-bottom:5px;"><img id="preview" style="display:none; max-width:100px; max-height:100px; color:#e9e9e9; float:left;"><span id="preview_lbl">Preview</span></div>
				    </div>
					    <input type="button" id="gallery_image_save_btn" value="Save Image" class="btn btn-default" onclick="uploadGalleryImage()" style="float:left;">
					<button id="gallery_image_msg" class="pure-button" style="display:none; float:right;"></button>
				    
				    <input name="image_id" id="image_id" type="hidden">
				    <input name="image_detail" id="image_detail" type="hidden">
			    </div>
				<!-- <input type="button" class="btn btn-primary" value="Upload Image" onclick="toggleEventImageInput()"> -->
				<div style="width:40%; clear:both; margin-bottom:30px;" class="nl2">
				  <ul id="image_list" style="list-style:none; padding-left:0; margin-left:0;">	
			<?php foreach($exhibition->gallery_images as $img): ?>
					 <li id="li_<?php echo $img->id;?>" style="margin-top:10px; padding-bottom:5px; border-bottom:1px solid #e4e4e4;">
					 	 <a href="javascript:deleteGalleryImage(<?php echo $img->id;?>)" class="close" style="float:left; color:#333; margin-right:15px; font-size:12px;">x</a>
					     <input type="checkbox" name="gallery_image[]" value="<?php echo $img->id;?>" style="display:none;">
					     <a href="javascript:editGalleryImage(<?php echo $img->id;?>)"><img id="gi_<?php echo $img->id;?>" src="/images/gallery/<?php echo $img->image; ?>" 
					 	 style="max-height:30px; border:none;clear:both; cursor:pointer;""></a>
<!-- 					 	 <div id="desc_< ?php echo $img->id;?>" style="cursor:pointer; width:150px; float:right; text-align:left; font-weight:normal; color:#222; font-size:11px;" onclick="editGalleryImage(< ?php echo $img->id;?>)">< ?php echo substr($img->detail, 0, 10) . '...';?></div>					 	 
 -->					 </li>
			<?php endforeach; ?>    
				  </ul>
				</div>
			</div>


			    <li>
		            {{ Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'padding:1px 15px 3px 15px')) }}
		        </li>
		    </ul>

			    {{ Form::hidden('gallery_id', $exhibition->gallery_id) }}
			    {{ Form::hidden('id', $exhibition->id) }}

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

<script>
var DOMAIN = 'http://<?php echo $_SERVER['SERVER_NAME'];?>';

function showGalleryImagePreview() {
	var formData = new FormData($('form')[0]);
	$.ajax({
	    type: 'POST',
	    url: '/exhibitions/upload',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('showGalleryImagePreview success..'+ "\n\n");
	    			console.log(data);
	    			$('#preview_lbl').hide('');
	    			$('#preview').prop('src', DOMAIN + data.preivew);
	    			$('#preview').show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function uploadGalleryImage() {
	$('#image_detail').val(tinyMCE.get('_image_detail').getContent());
	var formData = new FormData($('form')[0]);
	$.ajax({
	    type: 'POST',
	    url: '/exhibitions/save-gallery-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('Success..'+ "\n\n");
	    			var list = $('#image_list');
	    			$('#gallery_image').val('');
	    			$('#image_detail').val('');
	    			list.append('<li id="li_'+data.item.id+'" style="margin-top:10px; padding-bottom:5px; border-bottom:1px solid #e4e4e4;">'+
						'<a href="javascript:deleteGalleryImage('+ data.item.id +')" class="close" style="float:left; color:#333; margin-right:15px; font-size:12px;">x</a>' +
						'<input type="checkbox" name="gallery_image[]" value="'+ data.item.id +'" style="display:none">' + 
						'<a href="javascript:editGalleryImage('+data.item.id+')">' +
				        '<img id="gi_'+data.item.id+'" src="/images/gallery/'+ data.item.image + '" style="max-height:30px; border:none;clear:both;"></a>' +
				        // '<div id="desc_'+data.item.id+'" style="cursor:pointer; width:150px; float:right; text-align:left; font-weight:normal; color:#222; font-size:11px;" onclick="editGalleryImage('+data.item.id+')">'+ data.item.detail.substr(0, 10) + '..</div>' + 
				        '</li>');
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function deleteGalleryImage(id) {
	$.ajax({
	    type: 'GET',
	    url: '/exhibitions/delete-gallery-image',
	    data: { 'id' : id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('Success..'+ "\n\n");
 	    			$('#preview').hide();
 	    			tinyMCE.get('_image_detail').setContent('');
	    			var list = $('#image_list');
	    			$('#gallery_image').val('');
	    			$('#li_'+id).css('display', 'none');
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function editGalleryImage(id) {
	$('#gallery_image_save_btn').attr('onclick', 'updateGalleryImage('+id+')');
	$.ajax({
	    type: 'GET',
	    url: '/exhibitions/edit-gallery-image',
	    data: { 'id' : id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editGalleryImage success..'+ "\n\n");
	    			console.log(data);
	    			$('#image_id').val(id);
	    			$('#preview_lbl').hide('');
	    			$('#preview').prop('src', DOMAIN + '/images/gallery/' + data.item.image);
	    			$('#preview').show();
	    			tinyMCE.get('_image_detail').setContent(data.item.detail);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function updateGalleryImage(id) {
	$('#image_detail').val(tinyMCE.get('_image_detail').getContent()); //$("#_image_detail").val());
	var formData = new FormData($('form')[0]);

	$.ajax({
	    type: 'POST',
	    url: '/exhibitions/update-gallery-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
 	    			$('#preview').hide();
 	    			tinyMCE.get('_image_detail').setContent('');
					$('#gallery_image_save_btn').attr('onclick', 'uploadGalleryImage()');
					$('#gi_'+id).prop('src', DOMAIN + '/images/gallery/' + data.item.image);

					$("#gallery_image_msg").removeClass('btn-danger').removeClass('btn-info').addClass('btn-success');
					$("#gallery_image_msg").html('Gallery image updated..');
					$('#gallery_image_msg').hide().delay(20).fadeIn('slow');
	    			$('#gallery_image_msg').hide().delay(5000).fadeOut(2500);	    			

				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function resetGalleryImageForm() {
	$('#preview_lbl').show('');
	$('#preview').hide();
	$('#image_id').val('');
	tinyMCE.get('_image_detail').setContent('');
	$('#gallery_image_save_btn').attr('onclick', 'uploadGalleryImage()');
	$('#gallery_image').focus();
}

function toggleGalleryImageInput() {
	if($('#image_pane').css('display') == 'none') {
		$('#image_pane').css('display', 'inline');
	} else {
		$('#image_pane').css('display', 'none');
	}
}


</script>

@stop
@extends('layouts.default')

@section('content')
    <div class="page_content">
    	<div style="width:100%; clear:both;">
			<!-- <div class="form-group" style="text-align:right;">
			    <a href="/content/contents/{{$cs_id}}">Add Content </a> 
			    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; color:#888;">|</div>
			    <a href="/content/image-galleries/{{$cs_id}}">Add Image Gallery </a>
			</div>
	    </div> -->
      <h4>Page: {{$content_section->title_de}}
      		<a href="/content/pages/{{$menu_item_id}}/{{$cs_id}}" class="link" style="margin-left:2px;">back</a>
      </h4>
      <p>
		<div style="list-style:none;">
			{{ Form::model($page, array('route' => array('pages.update', $page->id))) }}		  

				<div class="form-group">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('title_de', $page->title_de, ['placeholder' => 'Title [de]', 'style' => 'width:300px;']) }}
				    {{ Form::text('title_en', $page->title_en, ['placeholder' => 'Title [en]', 'style' => 'width:300px;']) }}
				</div>    
				<div class="form-group"> 
				    {{ Form::label('calendar', 'Calendar') }}
				    <select name="cluster_id" id="cluster_id" class="chosen-select" style="width:650px;">
				      @if($cluster_match == false) <option value="0">None </option> @endif
				      @foreach($clusters as $cl) 
				      	 <?php $selected = ''; 
				      	 	if(isset($page->cluster) && ($cl->id == $page->cluster_id)) { $selected = ' selected="selected"'; }
				      	 ?>
				      	 <option value="{{$cl->id}}" <?php echo $selected;?> >{{$cl->title_de}} </option>
				      @endforeach
				      @if($cluster_match == true) <option value="0">None </option> @endif
				    </select>
				</div>		
				<div class="form-group"> 
				    {{ Form::label('contacts', 'Contacts') }}
				    <select name="contacts[]" id="contacts" class="chosen-select" multiple style="width:650px;">
				      @foreach($rel_contacts as $c) 
				      	 <option value="{{$c->id}}" selected="selected">{{$c->first_name .' '. $c->last_name}}</option>
				      @endforeach
				      @foreach($contacts as $c) 
				      	 <option value="{{$c->id}}" >{{$c->first_name .' '. $c->last_name}}</option>
				      @endforeach
				    </select>
				</div>		

			    <!-- <a href="javascript:deletePage({{$cs_id}}, {{$page->id}})" class="icon-fixed-width icon-trash" style="margin-left:20px;"></a> -->
				<div class="form-group">
				    <label for="exampleInputEmail1"></label>
				     {{ Form::submit('Save Page', array('id' => 'save_page_btn', 'class' => 'pure-button button-small')) }}					     
				     <a href="javascript:deletePage({{$cs_id}}, {{$menu_item_id}}, {{$page->id}})" class='button-error pure-button button-small' style="color:#fff; text-decoration:none;margin-top:2px;">Delete Page</a>
				</div>            
			    {{ Form::hidden('id', $page->id) }}
			    {{ Form::hidden('cs_id', $cs_id) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id) }}

			{{ Form::close() }}		


				<!-- ////////////////////   IMAGE SLIDER   ////////////////////// -->
				<?php $display = 'display:none;'; 
					  if($action == 'new_slider') { $display = ''; }
				?>

				<div id="page_image_slider" class="form-group" style="margin:20px 0px; <?php echo $display;?>">
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
					    		  	  style="width:100%; font-size:12px;float:left;">Image Slider<a href="javascript:showSliderImageForm({{$slider->id}}, true)" class="form-link"
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
									    <br>
									    <div style="width:100%; float:left; display:blockk">
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
				    				@if($slider->page_slider_images)
				    					@foreach($slider->page_slider_images as $sl_image)
				    						<div id="slider_image_{{$sl_image->id}}" style="width:90%; font-family:georgia; font-size:14px; 
				    							font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">
				    						<a href="javascript:deletePageSliderImage({{$sl_image->id}})" title="Delete" type="button" 
				    						class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:6px;"><span class="glyphicon glyphicon-trash"></span></a>
				    						<a href="javascript:editPageSliderImage({{$slider->id}}, {{$sl_image->id}})"><img id="si_{{$sl_image->id}}" src="{{$DOMAIN}}/files/sliders/{{$sl_image->filename}}" style="max-width:90px; max-height:60px;"></a></div>
				    					@endforeach
				    				@endif
				    			   </div>
				    			</li>

				    	@endforeach
				    </ul>
				 @endif
				</div>
			</div>
	    </div>

			@if($errors->any())
			    <ul>{{ implode('', $errors->all('<li class="error">:message</li>')) }}</ul>
			@endif
      </p> 
    </div>

    <input type="hidden" id="cs_id" value="{{$cs_id}}">
    <input type="hidden" id="page_id" value="{{$page->id}}">

<script>
var lastSliderId = 0;
var pageContentId = 0;
var contentSortOrder = 0;

function showContentInput() {
	tinyMCE.get('content_de').setContent('');
	tinyMCE.get('content_en').setContent('');
	
	$('#page_image_pane').hide();
	$('#image_gallery').hide();
	$('#page_content').removeClass('no-display').show();
	// $('#save_content_btn').attr('onclick', 'saveContent()');
	$('#sort_order').hide();
	$('#gallery_image_save_btn').hide();
	$('#save_content_btn').removeClass('no-display').show();
	$('#page_image_slider').hide();
}

function hideContentInput() {
	$('#page_content').hide();
}

function editSection(sec, id) {
	$.ajax({
	    type: 'GET',
	    url: '/get-page-section',
	    data: { 'id': id, 'page_id': $('#page_id').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editSection success..');
	    			console.log(data);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editSection failed..');
	    	    }
	});
}

function editPageContent(id) {
	$("body").scrollTop(10);
	pageContentId = id;
	$('#pc_id').val(id);
	showContentInput();
	$('#sort_order').show();
	$.ajax({
	    type: 'GET',
	    url: '/get-page-content',
	    data: { 'id': id, 'page_id': $('#page_id').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editPageContent success..'+ "\n\n");
	    			console.log(data);
	    			tinyMCE.get('content_de').setContent(data.item.content_de);	
	    			tinyMCE.get('content_en').setContent(data.item.content_en);	
	    			contentSortOrder = data.item.sort_order;
	    			$('#sort_order').val(contentSortOrder);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editPageContent failed..');
	    	    }
	});
}

var h2Id = 0;
var h2textId = 0;

function editH2(id) {
	h2Id = id;
	$('#h2_id').val(id);
	$("body").scrollTop(10); //$('#h2_de').click();
	toggleInput('h2');
	$('#sort_order').show();
	$.ajax({
	    type: 'GET',
	    url: '/get-h2',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editH2 success..'+ "\n\n");
	    			console.log(data);
	    			// $('#save_content_btn').attr('onclick', 'updatePageContent(event)');
	    			$('#h2_de').val(data.h2.headline_de);
	    			$('#h2_en').val(data.h2.headline_en);
	    			// $('#content_title_en').val(data.h2.title_en);
	    			// contentSortOrder = data.h2.sort_order;
	    			// $('#sort_order').val(contentSortOrder);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editH2 failed..');
	    	    }
	});
	return;
}

function saveH2(id) {
	$('#sort_order').show();
	$.ajax({
	    type: 'POST',
	    url: '/save-h2',
	    data: { 'id': id, 'h2': $('#h2').val(), 'page_id': $('#page_id').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('saveH2 success..');
	    			console.log(data);
	    			// $('#save_content_btn').attr('onclick', 'updatePageContent(event)');
	    			$('#h2_de').val(data.h2.headline_de);
	    			$('#h2_en').val(data.h2.headline_en);
	    			// $('#content_title_en').val(data.h2.title_en);
	    			// contentSortOrder = data.h2.sort_order;
	    			// $('#sort_order').val(contentSortOrder);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('saveH2 failed..');
	    	    }
	});
}

function editH2text(id) {
	h2textId = id;
	$('#h2text_id').val(id);
	$("body").scrollTop(10);
	toggleInput('h2text');
	$('#sort_order').show();
	$.ajax({
	    type: 'GET',
	    url: '/get-h2text',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editH2text success..');
	    			console.log(data);
	    			$('#h2text_h2de').val(data.item.headline_de);
	    			$('#h2text_h2en').val(data.item.headline_en);
	    			$('#anchor_title_de').val(data.item.anchor_title_de);
	    			$('#anchor_title_en').val(data.item.anchor_title_en);
					tinyMCE.get('intro_de').setContent(data.item.intro_de);
					tinyMCE.get('intro_en').setContent(data.item.intro_en);
	    			// contentSortOrder = data.h2.sort_order;
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editH2text failed..');
	    	    }
	});
	return;
}

function deleteImageSlider(id) {
	if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-slider',
		    data: { 'id': id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deleteImageSlider success..');
		    			$('#slider_blk_'+id).hide();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deleteImageSlider failed..');
		    	    }
		});
	} else {
		return false;
	}	
}

function deleteTeaser(id) {
	// if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-teaser',
		    data: { 'id': id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deleteTeaser success..');
		    			$('#teaser_form')[0].reset();
		    			$('#teaser_caption').val('');
		    			$('#teaser_preview').hide();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deleteTeaser failed..');
		    	    }
		});
	// } else {
	// 	return false;
	// }	
}

function saveH2text(id) {
	// $('#sort_order').show();
	$.ajax({
	    type: 'POST',
	    url: '/save-h2text',
	    data: { 'id': id, 'h2text': $('#h2text_h2').val(), 'page_id': $('#page_id').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('saveH2text success..');
	    			console.log(data);
	    			$('#h2text_h2de').val(data.item.headline_de);
	    			$('#h2text_h2en').val(data.item.headline_en);
					tinyMCE.get('intro_de').setContent(data.item.intro_de);
					tinyMCE.get('intro_en').setContent(data.item.intro_en);
	    			// $('#sort_order').val(contentSortOrder);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('saveH2text failed..');
	    	    }
	});
}
function resetBannerForm() {
	$('#banner_form')[0].reset();
	$('#banner_preview').hide();
	$('#banner_id').val(0);
}

function updatePageContent(event) {
	var menu_item_id = $('#menu_item_id').val();
	var cs_id = $('#cs_id').val();
	var page_id = $('#page_id').val();
	// if(!isNaN($('#id').val())) {
	// var page_id = $('#id').val();
	event.preventDefault();
	var subtitle_de = tinyMCE.get('content_subtitle_de').getContent();
	var subtitle_en = tinyMCE.get('content_subtitle_en').getContent();
	var content_de = tinyMCE.get('content_de').getContent();
	var content_en = tinyMCE.get('content_en').getContent();
	var formData = { 'id': pageContentId, 'page_id': $('#page_id').val(), 'cs_id': $('#cs_id').val(), 'content_de': content_de, 'content_en': content_en, 'sort_order': $('#sort_order').val(), 'title_de': $('#content_title_de').val(), 'title_en': $('#content_title_en').val(), 'subtitle_de': subtitle_de, 'subtitle_en': subtitle_en };
	$.ajax({
	    type: 'POST',
	    url: '/update-page-content',
	    data: formData,
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('updatePageContent success..'+ "\n\n");
	    			console.log(data);
					$("#page_content_msg").removeClass('btn-danger').removeClass('btn-info').addClass('btn-success');
					$("#page_content_msg").html('Page content updated..');
					$('#page_content_msg').hide().delay(20).fadeIn('slow');
	    			$('#page_content_msg').hide().delay(5000).fadeOut(2500);	    			

	    			$('#content_val_'+pageContentId).html($('#content_title_de').val());	
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('updatePageContent failed.. ');
	    	    }
	});
	// }
}

function saveContent() {
	if(!isNaN($('#id').val())) {
		var page_id = $('#id').val();
		var content_de = tinyMCE.get('content_de').getContent();
		var content_en = tinyMCE.get('content_en').getContent();
		var formData = { 'id': page_id, 'content_de': content_de, 'content_en': content_en };

		$.ajax({
		    type: 'POST',
		    url: '/store-page-content',
		    data: formData,
		    dataType: 'json',
		    // processData: false,
	        // contentType: false,
		    success:function(data) { 
		    			console.log('saveContent success..'+ "\n\n");
		    			console.log(data);
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('saveContent failed.. ');
		    	    }
		});
	}
}

function deletePageContent(page_id, id) {
	if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-page-content',
		    data: { 'page_id': page_id, 'id' : id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deletePageSliderImage success..'+ "\n\n");
		    			var list = $('#image_list');
		    			$('#page_content_blk_'+id).hide();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deletePageSliderImage Failed.. ');
		    	    }
		});
	}
}

function showSliderSection() {
	$('#page_content').hide();
	$('#page_image_slider').show();
}

function showSliderImageForm(id) {
	if(lastSliderId > 0 && $('#slider_pane_'+lastSliderId)) {
		$('#slider_pane_'+lastSliderId).addClass('no-display');
	}
	lastSliderId = id;
	$('#slider_image_form_blk_'+id).show();
	$('#slider_pane_'+id).removeClass('no-display');
	$('#slider_image_form_'+id).removeClass('no-display');
	$('#slider_image_id').val(id);
	$('#page_content').hide();
	// $('#save_page_btn').hide();
	$('#page_image_slider').removeClass('no-display').show();
}

function hideSliderImageForm(id) {
	// event.preventDefault();
	$('#slider_pane_'+id).addClass('no-display');
	$('#slider_image_form_blk_'+id).hide();
}

/* Image handling
*/

function showPageSliderImagePreview(id) {
	var frm = document.getElementById('slider_image_form_'+id);
	var formData = new FormData(frm); //$('#slider_image_form'));
	// var formData = new FormData($('form')[2]);
	// console.log(formData); return;
	$.ajax({
	    type: 'POST',
	    url: '/page-slider-image-preview',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('showPageSliderImagePreview success..'+ "\n\n");
	    			console.log(data);
	    			$('#preview_lbl_'+id).hide('');
	    			$('#preview_'+id).prop('src', DOMAIN + data.preivew);
	    			$('#preview_'+id).show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

var DOMAIN = 'http://<?php echo $_SERVER['SERVER_NAME'];?>';

function showNewSliderForm() {
	$.ajax({
	    type: 'GET',
	    url: '/create-slider',
	    data: {'id': $('#page_id').val()},
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('showNewSliderForm success..');
	    			console.log(data);
	    			$('#slider_title').html(data.item.title);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('showNewSliderForm failed.. ');
	    	    }
	});
	$('#page_image_slider_pane').show();
}

function editImageSlider(id) {
	hideNewSliderImageForm();
	if(lastSliderId > 0) {
		$('#slider_lbl_'+lastSliderId).removeClass('no-display').show();
		$('#slider_inp_'+lastSliderId).hide();
		$('#edit_slider_btns_'+lastSliderId).hide();
		$('#slider_sort_order_'+lastSliderId).hide();
	}
	if($('#slider_inp_'+id)) {
		$('#slider_lbl_'+id).hide();
		$('#slider_inp_'+id).removeClass('no-display').show();
		$('#slider_inp_'+id).focus();
		$('#edit_slider_btns_'+id).show();
		$('#slider_sort_order_'+id).show();
	}
	lastSliderId = id;
}

function cancelEditSlider(event, id) {
	event.preventDefault();
	if($('#slider_inp_'+id)) {
		$('#slider_lbl_'+id).removeClass('no-display').show();
		$('#slider_inp_'+id).hide();
		$('#edit_slider_btns_'+id).hide();
		$('#slider_sort_order_'+id).hide();
		if(lastSliderId != id) {
			$('#slider_lbl_'+lastSliderId).removeClass('no-display').show();
			$('#slider_inp_'+lastSliderId).hide();
			$('#edit_slider_btns_'+lastSliderId).hide();
			$('#slider_sort_order_'+lastSliderId).hide();
		}
	}
}

var cur_slider_id = 0;

function openAndEditImageSlider(id) {
	$("body").scrollTop(570);
	$('.slider-blk').hide();
	$('.slider-images-blk').hide();
	if(cur_slider_id > 0) {
		$('#slider_blk_'+cur_slider_id).hide();
		$('#slider_image_list_blk_'+cur_slider_id).hide();
	}
	cur_slider_id = id;
	showSliderSection();
	$('#slider_blk_'+id).show();
	$('#slider_image_list_blk_'+id).show();
	hideSliderImageForm(id);
	// editImageSlider(id);
}

function updatePageImageSlider(event, page_id, id) {
	event.preventDefault();
	var formData = { 'page_id': page_id, 
					 'id': id, 
					 'cs_id': $('#cs_id').val(), 
					 'title': $('#slider_inp_'+id).val(), 
					 'sort_order':$('#slider_sort_order_'+id).val() 
				   };
	$.ajax({
	    type: 'POST',
	    url: '/update-page-image-slider',
	    data: formData,
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('updatePageImageSlider success..'+ "\n\n");
	    			console.log(data);
	    			document.location.reload();
	    			// $('#slider_lbl_'+id).html($('#slider_inp_'+id).val());
	    			$('#slider_lbl_'+id).removeClass('no-display').show();
	    			$('#slider_inp_'+id).hide();
					$('#edit_slider_btns_'+id).hide();
					$('#slider_sort_order_'+id).hide();
	    			var list = '';
	    			var contents = data.sections;      //page.page_contents;
	    			for(var i in contents) {
	    				if(contents[i].type == 'content') {
		    				list += '<div id="page_content_'+contents[i].id+'" style="width:90%;float:left;font-family:georgia; font-size:14px; font-weight:normal; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">' + 
		    					'<p style="font-size:11px;font-family:arial; color:#333;">[HTML / Content]</p>' +
		    					contents[i].content_de + '</div>' +
		    				'<div style="width:8%; float:left;">' +
								'<a href="javascript:editPageContent('+contents[i].id+')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>' +
								'<a href="javascript:deletePageContent('+contents[i].id+')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>' +
							'</div>';
	    				}
	    				if(contents[i].type == 'h2') {
		    				list += '<div id="h2_'+contents[i].id+'" style="width:90%;float:left;font-family:georgia; font-size:16px; font-weight:normal; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">' + 
		    					'<p style="font-size:11px;font-family:arial; color:#333;">[Headline H2]</p>' +
		    					contents[i].headline + '</div>' +
		    				'<div style="width:8%; float:left;">' +
								'<a href="javascript:editSection(\'h2\','+contents[i].id+')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>' +
								'<a href="javascript:deleteSection(\'h2\','+contents[i].id+')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>' +
							'</div>';
	    				}
	    				if(contents[i].type == 'h2text') {
		    				list += '<div id="h2_'+contents[i].id+'" style="width:90%;float:left;font-family:georgia; font-size:16px; font-weight:normal; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">' + 
		    					'<p style="font-size:11px;font-family:arial; color:#333;">[Headline H2]</p>' +
		    					contents[i].headline + '</div>' +
		    				'<div style="width:8%; float:left;">' +
								'<a href="javascript:editSection(\'h2text\','+contents[i].id+')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>' +
								'<a href="javascript:deleteSection(\'h2text\','+contents[i].id+')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>' +
							'</div>';
	    				}
	    				if(contents[i].type == 'gallery' || contents[i].type == 'slider') {
		    				list += '<div id="page_content_'+contents[i].id+'" style="width:90%;float:left;font-family:georgia; font-size:14px; font-weight:normal; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">' + 
		    					'<p style="font-size:11px;font-family:arial; color:#333;">[Image Gallery]</p>' +
		    					contents[i].title + '</div>' +
		    				'<div style="width:8%; float:left;">' +
								'<a href="javascript:editSection(\'slider\','+contents[i].id+')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>' +
								'<a href="javascript:deleteSection(\'slider\','+contents[i].id+')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>' +
							'</div>';
	    				}
	    			}
	    			$('#content_list_pane').html(list);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('updatePageImageSlider failed.. ');
	    	    }
	});
}

function cancelPageImageSlider() {
	$('#page_image_slider').hide();
}

function showNewSliderImageForm() {
	if(lastSliderId > 0) {
		$('#cancel_slider_btn_'+lastSliderId).click();
	}
	$('#page_image_slider_pane').show();
}

function hideNewSliderImageForm() {
	$('#page_image_slider_pane').hide();
}

function editPageSliderImage(slider_id, id) {
	$("body").scrollTop(10);
	$('#image_id_'+slider_id).val(id);
	showSliderImageForm(slider_id);

	$('#gallery_image_save_btn').attr('onclick', 'updatePageSliderImage(event, '+slider_id+','+id+')');
	$.ajax({
	    type: 'GET',
	    url: '/get-page-slider-image',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editPageSliderImage success..'+ "\n\n");
	    			console.log(data);
	    			$('#preview_lbl_'+slider_id).hide('');
	    			$('#preview_'+slider_id).prop('src', DOMAIN +'/files/'+ data.image.path + data.image.filename);
	    			$('#preview_'+slider_id).show();
	    			// alert(tinyMCE.get('_image_detail_'+slider_id).getContent());
	    			tinyMCE.get('_image_detail_'+slider_id).setContent(data.image.detail);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editPageSliderImage failed.. ');
	    	    }
	});
}

function savePageSliderImage(event, id) {
	event.preventDefault();
	$('#image_detail_'+id).val(tinyMCE.get('_image_detail_'+id).getContent());
	var frm = document.getElementById('slider_image_form_'+id);
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/save-page-slider-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('savePageSliderImage Success..'+ "\n\n");
	    			console.log(data);
	    			$('#slider_image_form_'+id)[0].reset();
	    			$('#preview_'+id).hide();
	    			hideNewSliderImageForm();
	    			$('#gallery_image').val('');
	    			$('#image_detail').val('');
	    			var list = '<div style="width:100%; display:block; clear:both;">';
	    			var list2 = '';
	    			var img = null;
	    			for(i=0; i<data.images.length; i++) {
	    				img = data.images[i];
	    				list += '<div id="slider_image_'+img.id+'" style="width:90%; font-family:georgia; font-size:14px;' +
					'font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">' +
					'<a href="javascript:deletePageSliderImage('+img.id+')" title="Delete" type="button" ' +
					' class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:6px;"><span class="glyphicon glyphicon-trash"></span></a>' +
					'<a href="javascript:editPageSliderImage('+id+', '+img.id+')"><img id="si_'+img.id+'" src="'+DOMAIN+'/files/sliders/'+img.filename+
						'" style="max-width:90px; max-height:60px;"></a></div>';
	    			}
	    			list += '</div>';
// console.log(list);	    			
	    			$('#slider_image_list_'+id).html(list);
	    			var html = '';
	    			if(data.images.length > 0) {
	    				img = data.images[data.images.length-1];
	    				html = '<div style="width:60px; float:left; border:1px solid #d9d9d9;margin-right:5px;">'+
					  			 '<img src="/files/sliders/'+img.filename+'" style="max-width:60px;border:none;">'+
					  		   '</div>';
					  	$('#slider_val_'+id).append(html);	   
	    			}


				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('savePageSliderImage Failed.. ');
	    	    }
	});
}

function deletePageSliderImage(id) {
	// if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-page-slider-image',
		    data: { 'id' : id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deletePageSliderImage success..');
		    			var list = $('#image_list');
		    			$('#slider_image_'+id).hide();
		    			$('#slider_image_blk_'+id).hide();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deletePageSliderImage Failed.. ');
		    	    }
		});
	// }
}

function updatePageSliderImage(event, slider_id, id) {
	event.preventDefault();
	$('#image_detail_'+id).val(tinyMCE.get('_image_detail_'+id).getContent());
	var frm = document.getElementById('slider_image_form_'+id);
	var formData = new FormData(frm);
	console.log(formData);
	$.ajax({
	    type: 'POST',
	    url: '/update-page-slider-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    	console.log("updatePageSliderImage success..");
	    	console.log(data);
			hideNewSliderImageForm();
			$('#preview_'+id).hide();
			$('#image_id').val('');
			// setTextareaContent('_image_detail_'+id, '');
			$('#si_'+id).prop('src', DOMAIN + '/files/sliders/' + data.item.image);
			$('#desc_'+id).html(data.item.detail.substr(0, 10) + '...');
			$('#gallery_image_save_btn').attr('onclick', 'savePageSliderImage(event, '+lastSliderId+')');

			$("#slider_image_status_msg").removeClass('btn-danger').removeClass('btn-info').addClass('btn-success');
			$("#slider_image_status_msg").html('Image detail updated..');
			$('#slider_image_status_msg').hide().delay(20).fadeIn('slow');
			$('#slider_image_status_msg').hide().delay(5000).fadeOut(2500);
			return;
		},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function resetPageSliderImageForm() {
	$('#preview_lbl').show('');
	$('#preview_'+lastSliderId).hide();
	$('#image_id').val('');
	tinyMCE.get('_image_detail_'+lastSliderId).setContent('');
	$('#gallery_image_save_btn').attr('onclick', 'savePageSliderImage(event, '+lastSliderId+')');
	$('#gallery_image').focus();
}


function showPageImageSection() {
	$('#page_image_pane').show();
}

function hidePageImageSection() {
	$('#page_image_pane').hide();	
}

function hideImageSection() {
	$('#image_pane').hide();	
}

function editBanner(id) {
	$('#banner_id').val(id);
	$.ajax({
	    type: 'GET',
	    url: '/get-banner',
	    data: {'id': id},
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editBanner success..');
	    			console.log(data);
	    			$('#banner_preview').prop('src', DOMAIN +'/files/pages/'+ data.banner.image);
	    			$('#banner_preview').show();
	    			$('#banner_caption').val(data.banner.caption);
	    			var txt = data.banner.banner_text;
	    			$('#line_1').val(txt.line_1);
	    			$('#font_1').val(txt.font_1);
	    			$('#size_1').val(txt.size_1);
	    			$('#line_2').val(txt.line_2);
	    			$('#font_2').val(txt.font_2);
	    			$('#size_2').val(txt.size_2);
	    			$('#line_3').val(txt.line_3);
	    			$('#font_3').val(txt.font_3);
	    			$('#size_3').val(txt.size_3);
	    			$('#line_4').val(txt.line_4);
	    			$('#font_4').val(txt.font_4);
	    			$('#size_4').val(txt.size_4);
	    			// alert(txt.position);
	    			if(txt.position == 'top') { $('#position').prop('selectedIndex', 0); }
	    			if(txt.position == 'mid') { $('#position').prop('selectedIndex', 1); }
	    			if(txt.position == 'bottom') { $('#position').prop('selectedIndex', 2); }
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editBanner failed.. ');
	    	    }
	});	
}

function deleteBanner(tsr_id) {
	// var frm = document.getElementById('banner_form');
	$.ajax({
	    type: 'GET',
	    url: '/delete-banner',
	    data: { 'banner_id': tsr_id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('deleteBanner success..'+ "\n\n");
	    			$('#banner_preview').hide();
	    			$('#tsr_'+tsr_id).hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deleteBanner failed.. ');
	    	    }
	});	
}

function editImage(id) {
	$('#image_id').val(id);
	toggleInput('image');
	$.ajax({
	    type: 'GET',
	    url: '/get-image',
	    data: {'id': id},
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editImage success..');
	    			console.log(data);
	    			$('#image_preview').prop('src', DOMAIN +'/files/image/'+ data.image.filename);
	    			$('#image_preview').show();
	    			tinyMCE.get('image_caption_de').setContent(data.image.caption_de);
	    			tinyMCE.get('image_caption_en').setContent(data.image.caption_en);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editImage failed.. ');
	    	    }
	});	
}

function uploadPageImage() {
	var frm = document.getElementById('banner_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/upload-page-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadPageImage success..'+ "\n\n");
	    			console.log(data);
	    			$('#banner_preview').prop('src', DOMAIN + data.preivew);
	    			$('#banner_preview').show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadPageImage failed.. ');
	    	    }
	});	
}

function uploadTeaser() {
	var frm = document.getElementById('teaser_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/upload-teaser',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadTeaser success..'+ "\n\n");
	    			console.log(data);
	    			$('#teaser_preview').prop('src', DOMAIN + data.preivew);
	    			$('#teaser_preview').show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadPageImage failed.. ');
	    		}
	});	
}

function uploadDLFile() {
	var frm = document.getElementById('download_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/upload-download-file',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadDLFile success..'+ "\n\n");
	    			console.log(data);
	    			var file = $('#download_file').val();
	    			file = file.substr(file.lastIndexOf("\\")+1, file.length);
	    			if((file.indexOf('.png') > -1) || (file.indexOf('.jpg') > -1) || (file.indexOf('.gif') > -1)) {
		    			$('#download_preview').prop('src', DOMAIN + data.preivew);
		    			$('#download_preview').show();
	    			}
	    			// $('#download_item').html('Item: '+ file);

				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadDLFile failed.. ');
	    	    }
	});	
}

function savePageImage(event) {
	event.preventDefault();
	var frm = document.getElementById('banner_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/save-page-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
 	    			$('#banner_preview').show();
					$("#page_image_status_msg").removeClass('btn-danger').removeClass('btn-info').addClass('btn-success');
					$("#page_image_status_msg").html('Page image updated..');
					$('#page_image_status_msg').hide().delay(20).fadeIn('slow');
	    			$('#page_image_status_msg').hide().delay(5000).fadeOut(2500);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function uploadSponsorLogo(grp_id) {
	var frm = document.getElementById('sponsor_form_'+grp_id);
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/upload-sponsor-logo',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadSponsorLogo success..');
	    			console.log(data);
	    			$('#sponsor_preview_'+grp_id).prop('src', DOMAIN + data.preivew);
	    			$('#sponsor_preview_'+grp_id).show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadSponsorLogo failed.. ');
	    	    }
	});	
}

function uploadImage() {
	var frm = document.getElementById('image_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/upload-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadImage success..');
	    			console.log(data);
	    			$('#image_preview').prop('src', DOMAIN + data.preivew);
	    			$('#image_preview').show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadImage failed.. ');
	    	    }
	});	
}

function deleteImageSlider__(menu_item_id, cs_id, page_id, ps_id, gallery_id, type) {
	if(confirm('Are you sure you want to delete slider (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-page-image-slider',
		    data: { 'page_id': page_id, 'menu_item_id': menu_item_id, 'cs_id': cs_id, 'ps_id':ps_id, 'gallery_id': gallery_id, 'type': type },
		    dataType: 'json',
		    success:function(data) { 
		    			document.location.reload();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deletePageImage failed.. ');
		    	    }
		});	
	}
}

function deletePageImage(id) {
	$.ajax({
	    type: 'GET',
	    url: '/delete-page-image',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			$('#banner_preview').hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deletePageImage failed.. ');
	    	    }
	});	
}

var cur_input = '';

function toggleInput(type) {
	if(cur_input == type) {
		$('#page_image_pane').hide();
		$('#image_pane').hide();
		$('#page_image_slider').hide();
		$('#page_content').hide();
		$('#h2_block').hide();
		$('#h2text_block').hide();
		$('#page_image_slider').hide();
		cur_input = '';
		return;
	} else {
		cur_input = type;
	}
	if(type == 'h2') {
		$('#page_image_pane').hide();
		$('#image_pane').hide();
		$('#page_image_slider').hide();
		$('#page_content').hide();
		$('#h2_block').show();
		$('#h2text_block').hide();
	}
	if(type == 'h2text') {
		$('#page_image_pane').hide();
		$('#image_pane').hide();
		$('#page_image_slider').hide();
		$('#page_content').hide();
		$('#h2_block').hide();
		$('#h2text_block').show();
	}
	if(type == 'banner') {
		$('#page_image_slider').hide();
		$('#image_pane').hide();
		$('#page_content').hide();
		$('#h2_block').hide();
		$('#h2text_block').hide();
		$('#page_image_pane').show();
		var banner_id = '<?php echo $banner_id; ?>';
		if(!isNaN(banner_id) && parseInt(banner_id) > 0) {
			editBanner(banner_id);
		}
	}
	if(type == 'image') {
		$('#page_image_slider').hide();
		$('#image_pane').show();
		$('#page_content').hide();
		$('#h2_block').hide();
		$('#h2text_block').hide();
		$('#page_image_pane').hide();
	}
	if(type == 'content') {
		$('#h2_block').hide();
		$('#image_pane').hide();
		showContentInput();
	}
	if(type == 'slider') {
		$('#image_pane').hide();
		$('#page_content').hide();
		$('#h2_block').hide();
		$('#h2text_block').hide();
		$('#page_image_pane').hide();
		$('#page_image_slider').show();
	}
}

var tsr_line_count = 1;
var new_banner_line = 1;

function addNewLineInput(e, btn) {
	e.preventDefault();
	btn.blur();
	$('#banner_line').val('');
	$('#banner_line_size').val('');
	$('#bnr_line_id').val('0');
	new_banner_line = 1;
	/*
	++tsr_line_count;
	var html = '<div style="width:100%;float:left;">' +
				  '<input type="text" name="line_'+tsr_line_count+'" id="line_'+tsr_line_count+'" style="width:350px;margin-top:-3px;float:left;">' +
				  '<select name="line_'+tsr_line_count+'_size" style="width:80px;float:left;position:relative;top:-4px;left:7px;">' +
			    	'<option value="S">S</option>' +
			    	'<option value="M">M</option>' +
			    	'<option value="L">L</option>' +
			    	'<option value="XL">XL</option>' +
			      '</select>' +
		       '</div>';
	// html = $('#banner_text').html() + html;
	$('#banner_text').append(html);	
	/**/
}

function editBannerLine(id, banner_id) {
	new_banner_line = 0;
	$('#bnr_line_id').val(id);
	$('#banner_id').val(banner_id);
	$.ajax({
	    type: 'GET',
	    url: '/get-bnr-text',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log("editBannerLine success"); console.log(data);
					$('#banner_line').val(data.text.line);
					$('#banner_line_size').val(data.text.size);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editBannerLine failed.. ');
	    	    }
	});	
}

function saveBannerText() {
	var bnr_line = $('#banner_line').val();
	if(bnr_line.length == 0) { bnr_line = '&nbsp;'; }
	$.ajax({
	    type: 'POST',
	    url: '/save-bnr-text',
	    data: { 'id': $('#bnr_line_id').val(), 'page_id': $('#page_id').val(), 'banner_id': $('#banner_id').val(), 'line': bnr_line, 'size': $('#banner_line_size').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log(data);
	    			var line = '';
	    			var blank = true;
	    			if(data.text.line.length > 0 && data.text.line != '&nbsp;') { line = data.text.line; blank = false; }
					$('#banner_line').val(line);
					$('#banner_line_size').val(data.text.size);
					$('#tsr_text_msg').show().delay(20).fadeIn('slow');
	    			$('#tsr_text_msg').hide().delay(5000).fadeOut(2500);	    			
	    			var line_text = data.text.line;
	    			if(blank) { line_text = 'blank-line'; }
	    			var html = '<div id="tsr_line_'+data.text.id+'" style="width:100%;float:left;">' +
								 '<span style="cursor:pointer;" onclick="editBannerLine('+data.text.id+')">'+ line_text +'</span>' +
								 '<a href="javascript:deleteTsrLine('+data.text.id+')" style="position:relative;left:5px;font-size:14px;">x</a>' +
							   '</div>';
					if(new_banner_line == 1) {
						$('#banner_text').append(html);
					} else {
						html = '<span style="cursor:pointer;" onclick="editBannerLine('+data.text.id+')">'+data.text.line+'</span>' +
							   '<a href="javascript:deleteTsrLine('+data.text.id+')" style="position:relative;left:5px;font-size:14px;">x</a>';
						$('#tsr_line_'+data.text.id).html(html);
					}	   
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editBannerLine failed.. ');
	    	    }
	});	
}

function deleteTsrLine(id) {
	$.ajax({
	    type: 'GET',
	    url: '/delete-bnr-text',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			$('#tsr_line_'+id).hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editBannerLine failed.. ');
	    	    }
	});	
}

function deletePage(cs_id, menu_item_id, id) {
	if(confirm('Are you sure you want to delete page (y/n)?')) {
		document.location.href = '/content/pages/delete/'+menu_item_id+'/'+cs_id+'/'+id;		
	}
}

function editSponsorGroup(id) {
	$('#sponsor_grp_id').val(id);
	$.ajax({
	    type: 'GET',
	    url: '/get-sponsor-group',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editSponsorGroup success');
	    			$('#sponsor_group').val(data.item.headline);
	    			$('#sg_sort_order').val(data.item.sort_order);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    			console.log('editSponsorGroup fail..');
	    	    }
	});	
}

function addSponsor(id, grp_title) {
	$('#sponsor_group_val').html(grp_title);
	$('#sg_form_blk_'+id).show();
	$('#sponsor_grp_id').val(id);
}

function editSponsor(grp_id, id) {
	$('#sponsor_grp_id').val(grp_id);
	$('#sponsor_id').val(id);
	$.ajax({
	    type: 'GET',
	    url: '/get-sponsor',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editSponsor success'); console.log(data);
	    			$('#sponsor_group_val').html(data.item.headline);
	    			$('#sponsor_url').val(data.item.url);
	    			$('#sponsor_preview').prop('src', DOMAIN +'/files/sponsors/'+ data.item.logo);
	    			$('#sponsor_preview').show();
	    			$('#sg_form_blk_'+grp_id).show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    			console.log('editSponsor fail..');
	    	    }
	});	
}

function deleteSponsor(id) {
	$.ajax({
	    type: 'GET',
	    url: '/delete-sponsor',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('deleteSponsor success');
	    			$('#sponsor_blk_'+id).hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    			console.log('deleteSponsor fail..');
	    	    }
	});	
}

function editDownload(id) {
	$('#download_id').val(id);
	$.ajax({
	    type: 'GET',
	    url: '/get-download',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editDownload success');
	    			var file = data.item.filename;
	    			file = file.substr(file.lastIndexOf("\\")+1, file.length);
	    			if((file.indexOf('.png') > -1) || (file.indexOf('.jpg') > -1) || (file.indexOf('.gif') > -1)) {
		    			$('#download_preview').prop('src', DOMAIN + '/files/downloads/'+ file);
		    			$('#download_preview').show();
	    			}
	    			if(data.item.link_title.length > 0) {
		    			$('#download_link_title').val(data.item.link_title);
	    			}
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    			console.log('editDownload fail..');
	    	    }
	});	
}

function deleteDownload(id) {
	if(confirm('Are you sure you want to delete slider (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-download',
		    data: { 'id': id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deleteDownload success');
		    			$('#download_blk_'+id).hide();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    			console.log('deleteDownload fail..');
		    	    }
		});	
	}	
}

var cur_block_id = '';

function toggleBlock(bid) {
	if(bid == cur_block_id) {
		$('#'+bid).hide();
		$('#'+bid+'_icon').html('+');
		cur_block_id = '';
	} else {
		$('#'+bid).show();
		$('#'+bid+'_icon').html('-');
		cur_block_id = bid;
	}
}

// Downloads block
function checkDownloadsForm() {
	if($('#protected_chk').prop('checked') == true && $('#terms_file').val() == '') {
		alert('please select file');
		return false;
	}
}

function createNewImageSlider(event) {
	event.preventDefault();
	toggleInput('image');
	$.ajax({
	    type: 'POST',
	    url: '/create-new-slider',
	    data: {'page_id': $('#page_id').val()},
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('createNewImageSlider success..');
	    			console.log(data);
	    			openAndEditImageSlider(data.item.id);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('createNewImageSlider failed.. ');
	    	    }
	});	
}

</script>

@stop
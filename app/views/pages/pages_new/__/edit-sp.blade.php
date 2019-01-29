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
      <h4><span style="font-weight:normal !important;">Page Section:</span> {{$content_section->title_de}}</h4>
      <p>
		<div style="list-style:none;">
			{{ Form::model($page, array('route' => array('pages.update-sp', $page->id))) }}		  

				<div class="form-group">
				    <label for="title">{{ Form::label('title', 'Page Title:') }}</label>
				    {{ Form::text('title_de', $page->title_de, ['placeholder' => 'Title [de]', 'style' => 'width:300px;']) }}
				    {{ Form::text('title_en', $page->title_en, ['placeholder' => 'Title [en]', 'style' => 'width:300px;']) }}
				    <!-- <a href="javascript:deletePage({{$cs_id}}, {{$page->id}})" class="icon-fixed-width icon-trash" style="margin-left:20px;"></a> -->
					<div class="form-group">
					    <label for="exampleInputEmail1"></label>
					     {{ Form::submit('Save', array('id' => 'save_page_btn', 'class' => 'pure-button button-small')) }}					     
					     <a href="javascript:deletePage({{$cs_id}},{{$page->id}})" class='button-error pure-button button-small' style="color:#fff; text-decoration:none;margin-top:2px;">Delete Page</a>
					</div>            

			    	<div style="width:100%; position:relative; top:10px; clear:both;">
						    <a href="javascript:showPageImageSection()" class="form-link">Teaser </a>
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; color:#888;">|</div>
						    <a href="javascript:showContentInput()" class="form-link">Content </a> 
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; color:#888;">|</div>
						    <a href="javascript:showSliderSection()" class="form-link">Image Gallery </a>
						    <!-- <div style="width:16px; text-align: center; display:inline; padding:0px 4px; color:#888;">|</div>
						    <a href="/content/pages/preview/{{$cs_id}}/{{$page->id}}" target="_blank" class="form-link">Preview </a> -->
				    </div>
				</div>
			    {{ Form::hidden('id', $page->id) }}
			    {{ Form::hidden('cs_id', $cs_id) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id) }}

			{{ Form::close() }}		

			<form id="page_image_form" method="post" action="">
				<div id="page_image_pane" class="form-group" style="margin-top:20px; display:none;">
				    <label for="page_image" style="float:left;"><?php echo Form::label('page_image', 'Teaser'); ?></label>
				    <div style="width:50%; float:left; display:inline;">
					    <?php echo Form::file('page_image', ['id' => 'page_image', 'onchange' => 'uploadPageImage()']); ?>				    
					    <!-- <input type="button" id="upload_btn" value="Upload" class="btn btn-default" onclick="saveProfileImage()"> -->
				    </div>
				
					<div class="form-groupz" style="width:100%; height:120px; clear:both;"> 
					    <label for="" style="float:left;">Preview</label>
					    <div style="width:10%; float:left; display:inline;">
					      <?php $display = 'display:none;';
						        $hasImage = false;
						        if(!empty($page->page_image)) { 
						        	$hasImage = true;
							      	$display = 'display:inline;';
							      	$background = ' background:url(/files/pages/'.$page->page_image.') no-repeat;'; 
						        }			      
					      ?>
						      <div style="width:70px !important; height:100px; display:inline-block; margin-top:5px; margin-left:0px; 
						      background-size:70px 100px; border:1px dashed #e3e3e3;"><img id="page_image_preview" src="/files/pages/<?php echo $page->page_image;?>" style="max-width:70px; max-height:100px; float:left; <?php echo $display;?>">
						      </div>
					    <?php $display = 'none;'; 
					    	  if($hasImage) { $display = 'inline-block;'; } ?>
						      <div id="image_delete_icon" sytle="width:30px;margin-left:10px;"><a href="javascript:deletePageImage({{$page->id}})" class="icon-fixed-width icon-trash" style="display:<?php echo $display;?>"></a></div>
					    </div>
					</div>
				    <br>
				    {{ Form::button('Save Image', array('id' => 'save_page_image_btn', 'onclick'=> 'savePageImage(event)', 'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
				    {{ Form::button('Cancel', array('id' => 'cancel_content_btn', 'onclick' => 'hidePageImageSection()', 'class' => 'button-error pure-button button-small', 'style' => 'height:30px; margin-top:0px; padding:3px 15px 5px 15px')) }}

				    <button id="page_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
				</div>

			    {{ Form::hidden('id', $page->id) }}
			    {{ Form::hidden('cs_id', $cs_id) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id) }}
			</form>


			{{ Form::open(array('route' => 'page_contents.store', 'method' => 'post')) }}

				<div id="page_content" class="form-group no-display" style="margin:20px 0px;">
					<div style="width:100%; float:left; display:block;">
					    <label for="exampleInputEmail1"><?php echo Form::label('title_de', 'Title'); ?></label>
					    <?php echo Form::text('title_de', null, ['id' => 'content_title_de', 'style' => 'width:300px;', 'placeholder' => 'Title DE']); ?>

					    <?php echo Form::text('title_en', null, ['id' => 'content_title_en', 'style' => 'width:300px;', 'placeholder' => 'Title EN']); ?> <span style="color:#9e9e9e; display:none; vertical-align:bottom;">en</span>
					</div>
					<div style="width:100%; float:left; display:block;">
					    <label for="exampleInputEmail1"><?php echo Form::label('subtitle_de', 'Subtitle [de]'); ?></label>
					    <?php echo Form::textarea('subtitle_de', null, ['id' => 'content_subtitle_de', 'style' => 'width:100px;height:40px; max-height:40px;', 'class' => 'tm_editor', 'placeholder' => 'Title DE']); ?>
					</div>    
					<div style="width:100%; float:left; display:block;">
					    <label for="exampleInputEmail1"><?php echo Form::label('subtitle_en', 'Subtitle [en]'); ?></label>
					    <?php echo Form::textarea('subtitle_en', null, ['id' => 'content_subtitle_en', 'class' => 'tm_editor', 'style' => 'width:300px;', 'placeholder' => 'Subtitle EN']); ?>

					</div>

				    <label for="exampleInputEmail1">{{ Form::label('content_de', 'Content (de)') }}</label>
				    {{ Form::textarea('content_de', null, ['style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'de']) }}<br>
				    <label for="exampleInputEmail1">{{ Form::label('content_en', 'Content (en)') }}</label>			    
				    {{ Form::textarea('content_en', null, ['style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'en']) }}
				    <br>
				    <select name="sort_order" id="sort_order" style="margin-bottom:15px; width:60px;">
				     @for($i=1; $i<=$sort_limit; $i++)
				     	<option value="{{$i}}" @if($i==$sort_limit) selected="selected" @endif >{{$i}} </option>
				     @endfor				    	
				    </select>
				    <br>
				    {{ Form::submit('Save Content', array('id' => 'save_content_btn', 'onclick'=> 'saveContent()', 'class' => 'button-success button-small pure-button', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
				    {{ Form::button('Cancel', array('id' => 'cancel_content_btn', 'onclick' => 'hideContentInput()', 'class' => 'button-error button-small pure-button', 'style' => 'height:30px; margin-top:1px; padding:3px 15px 5px 15px')) }}

				    <button id="page_content_msg" class="pure-button" style="display:none; float:right;"></button>
				</div>

			    {{ Form::hidden('id', $page->id) }}
			    {{ Form::hidden('cs_id', $cs_id) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id) }}

			{{ Form::close() }}

				<div id="page_image_slider" class="form-group no-display" style="margin:20px 0px;">
			       <div style="width:100%; clear:both; display:block; margin-bottom:15px;">
					  {{ Form::open(array('route' => 'page_image_sliders.store', 'method' => 'post')) }}

						{{ Form::label('slider_title', 'New Image Slider') }}

					    {{ Form::text('title', null, ['style' => 'width:500px;', 'placeholder' => 'Title']) }}
					    <br>
					    {{ Form::submit('Save Slider', array('id' => 'save_image_slider_btn', 
					    	'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
					    {{ Form::button('Cancel', array('id' => 'cancel_slider_btn', 'onclick' => 'cancelPageImageSlider()', 'class' => 'button-error pure-button button-small', 		'style' => 'height:30px;margin-top:1px; padding:3px 15px 5px 15px')) }}

					    {{ Form::hidden('page_id', $page->id) }}
					    {{ Form::hidden('cs_id', $cs_id) }}
					    {{ Form::hidden('menu_item_id', $menu_item_id) }}

					  {{ Form::close() }}


			         @if(count($page->page_image_sliders) > 0)
					    {{ Form::label('sliders', 'Image Sliders') }} 
				        <ul style="width:580px; list-style:none; margin-left:0; margin-top:10px; padding-left:0;"
					    	@foreach($page->page_image_sliders as $slider)

					    		<li id="slider_blk_{{$slider->id}}" style="width:580px;">
					    		  <form id="image_slider_form_<?php echo $slider->id;?>" method="post" action="">
					    		   <div id="slider_lbl_{{$slider->id}}" 
					    		  	  style="cursor:pointer; width:100%; font-size:12px; color:blue; float:left;"><span onclick="editImageSlider({{$slider->id}})">{{$slider->title}} </span><a href="javascript:showSliderImageForm({{$slider->id}})" class="form-link"
					    		  	    style="margin-left:5px;">(Add Image)</a>
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

					    			<div id="edit_slider_btns_{{$slider->id}}" style="width:140px;display:none;margin-left:4px;margin-top:2px;float:left;">
					    			  <button id="save_slider_btn_{{$slider->id}}" class="pure-button" 
					    			    style="float:left;" onclick="updatePageImageSlider(event, {{$page->id}}, {{$slider->id}})">Save</button>
					    			  <button id="cancel_slider_btn_{{$slider->id}}" class="button-error pure-button" onclick="cancelEditSlider(event, {{$slider->id}})"
					    			    style="float:left; margin-left:3px;">Cancel</button>
					    			</div>
					    		   </div>	
					    		  </form>
					    		</li>
					    		<li id="slider_pane_{{$slider->id}}" class="no-display" style="padding:10px 0px;">
					    		  <div style="width:100%; clear:both;">
					    		  	<button id="slider_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
					    		  </div>
					    		  <div style="width:100%; background:#f7f7f7; clear:both;">
								   <form id="slider_image_form_<?php echo $slider->id;?>" method="post" action="">

								    <div style="width:130px; float:left;">Slider Image <a href="javascript:resetPageSliderImageForm()" style="color:blue; display:inline; margin-left:5px; font-size:11px;">new</a></div>
								    <div id="image_pane" style="width:50%; float:left; display:inline;">
									    <input type="file" name="gallery_image" id="gallery_image_{{$slider->id}}" style="vertical-align:top; margin-bottom:5px;"
									      onchange="showPageSliderImagePreview({{$slider->id}})">
									    <br>
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
										      onclick="hideSliderImageForm(event, {{$slider->id}})" style="float:left; margin-left:3px;">Cancel</button>
										</div>
									    <input name="image_id" id="image_id" type="hidden">
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

				    			<li id="slider_image_list_li_{{$slider->id}}" style="padding:10px 0px;">
				    			   <div id="slider_image_list_{{$slider->id}}" style="width:100%; margin-top:20px; display:block; clear:both;">
				    				@if($slider->page_slider_images)
				    					@foreach($slider->page_slider_images as $sl_image)
				    						<div id="slider_image_{{$sl_image->id}}" style="width:90%; font-family:georgia; font-size:14px; 
				    							font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">
				    						<a href="javascript:deletePageSliderImage({{$sl_image->id}})" title="Delete" type="button" 
				    						class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:6px;"><span class="glyphicon glyphicon-trash"></span></a>
				    						<a href="javascript:editPageSliderImage({{$sl_image->id}}, {{$sl_image->id}})"><img src="{{$DOMAIN}}/files/sliders/{{$sl_image->filename}}" style="max-width:90px; max-height:60px;"></a></div>
				    					@endforeach
				    				@endif
				    			   </div>
				    			</li>

				    	@endforeach
				    </ul>
				 @endif
				</div>
			</div>

			<!-- List of content sections -->
			@if($sections) 

			  <div id="content_list_pane" style="width:100%; position:relative; top:20px;">

			  @foreach($sections as $pc)

			    @if($pc != null && $pc->type == 'content')

				  <div id="page_content_blk_{{$pc->id}}">
				  	<div id="page_content_{{$pc->id}}" style="width:90%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<p style="font-size:11px;font-family:arial; color:#333;">[HTML / Content]</p>
				  	{{$pc->content_de}} 
				  	</div>
				  	<div id="page_content_links_{{$pc->id}}" style="width:8%; float:left;">
				  		<a href="javascript:editPageContent({{$pc->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
		                <a href="javascript:deletePageContent({{$pc->id}})" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	</div>
				  </div>

			  	@endif

			    @if($pc != null && ($pc->type == 'gallery' || $pc->type == 'slider'))

				  <div id="page_content_blk_{{$pc->id}}">
				  	<div id="page_content_{{$pc->id}}" style="width:90%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<p style="font-size:11px;font-family:arial; color:#333;">[Image Gallery]</p>
				  	{{$pc->title}} 
				  	</div>
				  	<div id="page_content_links_{{$pc->id}}" style="width:8%; float:left;">
				  		<a href="javascript:openAndEditImageSlider({{$pc->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
		                <a href="javascript:deleteImageSlider({{$page->id}},{{$pc->id}})" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	</div>
				  </div>
			  	
			  	@endif

			  @endforeach

			  </div>
			@endif
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
	$('#save_content_btn').attr('onclick', 'saveContent()');
	$('#sort_order').hide();
	// $('#sort_order').val($('#sort_order option').length + 1);
	// $('#save_page_btn').hide();
	$('#gallery_image_save_btn').hide();
	$('#save_content_btn').removeClass('no-display').show();
	$('#page_image_slider').hide();
}

function hideContentInput() {
	$('#page_content').hide();
	// $('#save_page_btn').removeClass('no-display').show();
}

function editPageContent(id) {
	pageContentId = id;
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
	    			$('#save_content_btn').attr('onclick', 'updatePageContent(event)');
	    			$('#content_title_de').val(data.item.title_de);
	    			$('#content_title_en').val(data.item.title_en);
	    			tinyMCE.get('content_subtitle_de').setContent(data.item.subtitle_de);	
	    			tinyMCE.get('content_subtitle_en').setContent(data.item.subtitle_en);	
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

function updatePageContent(event) {
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
	    			$('#page_content_'+pageContentId).html(content_de);
	    			// if($('#sort_order').val() != contentSortOrder) { document.location.reload(); }

					$("#page_content_msg").removeClass('btn-danger').removeClass('btn-info').addClass('btn-success');
					$("#page_content_msg").html('Page content updated..');
					$('#page_content_msg').hide().delay(20).fadeIn('slow');
	    			$('#page_content_msg').hide().delay(5000).fadeOut(2500);	    			
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
	    				if(contents[i].type == 'gallery' || contents[i].type == 'slider') {
		    				list += '<div id="page_content_'+contents[i].id+'" style="width:90%;float:left;font-family:georgia; font-size:14px; font-weight:normal; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">' + 
		    					'<p style="font-size:11px;font-family:arial; color:#333;">[Image Gallery]</p>' +
		    					contents[i].title + '</div>' +
		    				'<div style="width:8%; float:left;">' +
								'<a href="javascript:editPageContent('+contents[i].id+')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>' +
								'<a href="javascript:deletePageContent('+contents[i].id+')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>' +
							'</div>';
	    				}
	    			}
	    			$('#content_list_pane').html(list);
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

function deletePageContent(id) {
	if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-page-content',
		    data: { 'id' : id },
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
	$('#page_image_slider').removeClass('no-display').show();
}

function showSliderImageForm(id) {
	if(lastSliderId > 0 && $('#slider_pane_'+lastSliderId)) {
		$('#slider_pane_'+lastSliderId).addClass('no-display');
	}
	lastSliderId = id;
	$('#slider_pane_'+id).removeClass('no-display');
	$('#slider_image_form_'+id).removeClass('no-display');
	$('#slider_image_id').val(id);
	$('#page_content').hide();
	// $('#save_page_btn').hide();
	$('#page_image_slider').removeClass('no-display').show();
}

function hideSliderImageForm(event, id) {
	event.preventDefault();
	$('#slider_pane_'+id).addClass('no-display');
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

function openAndEditImageSlider(id) {
	showSliderSection();
	editImageSlider(id);
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
	    				if(contents[i].type == 'gallery' || contents[i].type == 'slider') {
		    				list += '<div id="page_content_'+contents[i].id+'" style="width:90%;float:left;font-family:georgia; font-size:14px; font-weight:normal; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">' + 
		    					'<p style="font-size:11px;font-family:arial; color:#333;">[Image Gallery]</p>' +
		    					contents[i].title + '</div>' +
		    				'<div style="width:8%; float:left;">' +
								'<a href="javascript:editPageContent('+contents[i].id+')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>' +
								'<a href="javascript:deletePageContent('+contents[i].id+')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>' +
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
	showSliderImageForm(slider_id);

	$('#gallery_image_save_btn').attr('onclick', 'updatePageSliderImage(event, '+slider_id+')');
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
	$('#image_detail').val(tinyMCE.get('_image_detail_'+id).getContent());
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
	    			// document.location.reload();
	    			// var list = $('#slide_image_list');
	    			hideNewSliderImageForm();
	    			$('#gallery_image').val('');
	    			$('#image_detail').val('');
	    			var list = '<div style="width:100%; display:block; clear:both;">';
	    			var img = null;
	    			for(i=0; i<data.images.length; i++) {
	    				img = data.images[i];
	    				list += '<div id="slider_image_'+img.id+'" style="width:90%; font-family:georgia; font-size:14px;' +
					'font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">' +
					'<a href="javascript:deletePageSliderImage('+id+')" title="Delete" type="button" ' +
					' class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>' +
					'<a href="javascript:editPageSliderImage('+img.id+', '+id+')"><img src="'+DOMAIN+'/files/sliders/'+img.filename+
						'" style="max-width:90px; max-height:60px;"></a></div>';
	    			}
	    			$('#slider_image_list_'+id).html(list);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('savePageSliderImage Failed.. ');
	    	    }
	});
}

function deletePageSliderImage(id) {
	if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-page-slider-image',
		    data: { 'id' : id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deletePageSliderImage success..'+ "\n\n");
		    			var list = $('#image_list');
		    			// $('#gallery_image').val('');
		    			$('#slider_image_'+id).hide();
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deletePageSliderImage Failed.. ');
		    	    }
		});
	}
}

function updatePageSliderImage(id) {
	$('#image_detail').val(tinyMCE.get('_image_detail_'+id).getContent());
	var formData = new FormData($('form')[0]);

	$.ajax({
	    type: 'POST',
	    url: '/update-page-slider-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			hideNewSliderImageForm();
 	    			$('#preview_'+id).hide();
	    			$('#image_id').val('');
	    			// setTextareaContent('_image_detail_'+id, '');
	    			$('#gi_'+id).prop('src', DOMAIN + '/images/gallery/' + data.item.image);
	    			$('#desc_'+id).html(data.item.detail.substr(0, 10) + '...');
					$('#gallery_image_save_btn').attr('onclick', 'savePageSliderImage(event, '+lastSliderId+')');

					$("#slider_image_status_msg").removeClass('btn-danger').removeClass('btn-info').addClass('btn-success');
					$("#slider_image_status_msg").html('Image detail updated..');
					$('#slider_image_status_msg').hide().delay(20).fadeIn('slow');
	    			$('#slider_image_status_msg').hide().delay(5000).fadeOut(2500);
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

function uploadPageImage() {
	var frm = document.getElementById('page_image_form');
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
	    			$('#page_image_preview').prop('src', DOMAIN + data.preivew);
	    			$('#page_image_preview').show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadPageImage failed.. ');
	    	    }
	});	
}

function savePageImage(event) {
	event.preventDefault();
	var frm = document.getElementById('page_image_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/save-page-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
 	    			$('#page_image_preview').show();
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

function deleteImageSlider(page_id, id) {
	if(confirm('Are you sure you want to delete slider (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-page-image-slider',
		    data: { 'page_id': page_id, 'id': id },
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
	    			$('#page_image_preview').hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deletePageImage failed.. ');
	    	    }
	});	
}

function deletePage(cs_id, id) {
	if(confirm('Are you sure you want to delete page (y/n)?')) {
		document.location.href = '/content/pages/delete/'+ cs_id +'/'+ id;		
	}
}

</script>

@stop
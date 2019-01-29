@extends('layouts.default')

@section('content')
    <div class="page_content">
    	<div style="width:100%; clear:both;">
      <h4>Page: {{$page->title_de}}
      		<a href="/content/exhibition-pages" class="link" style="margin-left:2px;">back</a>
      </h4>
      <p>
		<div style="list-style:none;">
			<!--  ///////////////////////////   MAIN   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.main')
			<!--  ///////////////////////////   SPONSORS   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.sponsors')
			<!--  ///////////////////////////   DOWNLOADS   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.downloads')
			<!--  ///////////////////////////   TEASER   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.teaser')
			<!--  ///////////////////////////   CONTENT   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.edit-menu')
			<!--  ///////////////////////////   BANNERS   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.banners')
			<!--  ///////////////////////////   IMAGE GRID  ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.image_grid')
			<!--  ///////////////////////////   IMAGE   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.image')
			<!--  ///////////////////////////   H2   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.h2')
			<!--  ///////////////////////////   H2 INTRO   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.h2intro')
			<!--  ///////////////////////////   PAGE CONTENT   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.page_content')
			<!--  ///////////////////////////   SLIDERS   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.slider')
			<!--  ///////////////////////////   YOUTUBE   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.youtube')
			<!--  ///////////////////////////   AUDIO   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.audio')
			<!--  ///////////////////////////   PAGE SECTIONS   ///////////////////////////////// -->
			@include('pages.exhibition_pages.sections.page_sections')
	    </div>

			@if($errors->any())
			    <ul>{{ implode('', $errors->all('<li class="error">:message</li>')) }}</ul>
			@endif
	    	<?php $banner_id = 0;  
	    	if(isset($page->banner)) { $banner_id = $page->banner->id; } ?>
      </p> 
    </div>

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
	    url: '/get-exb-page-section',
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
	// $("body").scrollTop(10);
	pageContentId = id;
	$('#pc_id').val(id);
	showContentInput();
	$('#sort_order').show();
	$.ajax({
	    type: 'GET',
	    url: '/get-exb-page-content',
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
	// $("body").scrollTop(10); //$('#h2_de').click();
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
	// $("body").scrollTop(10);
	toggleInput('h2text');
	$('#sort_order').show();
	$.ajax({
	    type: 'GET',
	    url: '/get-exb-h2text',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editH2text success..');
	    			console.log(data);
	    			$('#h2text_h2de').val(data.item.headline_de);
	    			$('#h2text_h2en').val(data.item.headline_en);
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
		    url: '/delete-exb-slider',
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

function deleteSpGroup(id) {
	$.ajax({
	    type: 'GET',
	    url: '/delete-exb-sp-group',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('deleteSpGroup success..');
	    			$('#sp_grp_block_'+id).hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deleteSpGroup failed..');
	    	    }
	});
}

function deleteTeaser(id) {
	$.ajax({
	    type: 'GET',
	    url: '/delete-exb-teaser',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('deleteTeaser success..');
	    			$('#teaser_form')[0].reset();
					$('#teaser_caption_de').val(''); $('#teaser_caption_en').val('');
					$('#line_1_de').val(''); $('#line_1_en').val('');
					$('#line_2_de').val(''); $('#line_2_en').val('');
	    			$('#teaser_preview').hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deleteTeaser failed..');
	    	    }
	});
}

function saveH2text(id) {
	$.ajax({
	    type: 'POST',
	    url: '/save-exb-h2text',
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
	var page_id = $('#page_id').val();
	// if(!isNaN($('#id').val())) {
	// var page_id = $('#id').val();
	event.preventDefault();
	var subtitle_de = tinyMCE.get('content_subtitle_de').getContent();
	var subtitle_en = tinyMCE.get('content_subtitle_en').getContent();
	var content_de = tinyMCE.get('content_de').getContent();
	var content_en = tinyMCE.get('content_en').getContent();
	var formData = { 'id': pageContentId, 'page_id': $('#page_id').val(), 'content_de': content_de, 'content_en': content_en, 'sort_order': $('#sort_order').val(), 'title_de': $('#content_title_de').val(), 'title_en': $('#content_title_en').val(), 'subtitle_de': subtitle_de, 'subtitle_en': subtitle_en };
	$.ajax({
	    type: 'POST',
	    url: '/update-exb-page-content',
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
		    url: '/store-exb-page-content',
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
		    url: '/delete-exb-page-content',
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
	    url: '/create-exb-slider',
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

var lastImageGridId = 0;
// Image Grid
function editImageGrid(id) {
	if(lastImageGridId > 0) {
		$('#image_grid_blk_'+listImageGridId).hide();
	}
	$('#image_grid_pane').show();
	$('#image_grid_blk_'+id).show();	
	lastImageGridId = id;
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
	// $("body").scrollTop(570);
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
					 'title': $('#slider_inp_'+id).val(), 
					 'sort_order':$('#slider_sort_order_'+id).val() 
				   };
	$.ajax({
	    type: 'POST',
	    url: '/update-exb-page-image-slider',
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
	// $("body").scrollTop(620);
	$('#image_id_'+slider_id).val(id);
	$('#slider_id').val(slider_id);
	showSliderImageForm(slider_id);

	$('#gallery_image_save_btn').attr('onclick', 'updatePageSliderImage(event, '+slider_id +','+id+')');
	$.ajax({
	    type: 'GET',
	    url: '/get-exb-page-slider-image',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editPageSliderImage success..'+ "\n\n");
	    			console.log(data);
	    			$('#preview_lbl_'+slider_id).hide('');
	    			$('#sl_img_order_'+slider_id).val(data.image.sort_order);
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
	    url: '/save-exb-page-slider-image',
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
					'<a href="javascript:editPageSliderImage('+id+', '+img.id+')"><img src="'+DOMAIN+'/files/sliders/'+img.filename+
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

function updatePageSliderImage(event, slider_id, id) {
	event.preventDefault();
	$('#image_detail_'+slider_id).val(tinyMCE.get('_image_detail_'+slider_id).getContent());
	var frm = document.getElementById('slider_image_form_'+slider_id);
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
			// $('#preview_'+id).hide();
			// $('#image_id').val('');
			// setTextareaContent('_image_detail_'+id, '');
			// alert(id + "\n"+$('#slider_img_'+id).length + "\n"+ $('#slider_img_'+id).prop('src'));
			$('#gi_'+id).prop('src', DOMAIN + '/files/sliders/' + data.item.filename);
			$('#slider_img_'+id).prop('src', DOMAIN + '/files/sliders/' + data.item.filename);
			// alert($('#slider_img_'+id).prop('src'));
			// $('#desc_'+id).html(data.item.detail.substr(0, 10) + '...');
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

function reloadPage() {
	location.reload();
}

function deletePageSliderImage(id) {
	// if(confirm('Are you sure you want to delete (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-exb-page-slider-image',
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
	    			$('#banner_preview').prop('src', DOMAIN +'/files/exhibition_pages/'+ data.banner.image);
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

function deleteBanner(id) {
	$.ajax({
	    type: 'GET',
	    url: '/delete-banner',
	    data: { 'banner_id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('deleteBanner('+id+') success..');
	    			$('#banner_preview').hide();
	    			$('#banner_text_blk').html('');
	    			$('#tsr_'+id).hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deleteBanner('+id+') failed..');
	    	    }
	});	
}

function editImage(id) {
	$('#image_id').val(id);
	toggleInput('image');
	$.ajax({
	    type: 'GET',
	    url: '/get-exb-image',
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
	    url: '/upload-exb-page-image',
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
	    url: '/upload-exb-teaser',
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

function uploadThumb() {
	var frm = document.getElementById('download_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/upload-thumb-file',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadThumb success..');
	    			console.log(data);
	    			var file = $('#thumb').val();
	    			file = file.substr(file.lastIndexOf("\\")+1, file.length);
	    			if((file.indexOf('.png') > -1) || (file.indexOf('.jpg') > -1) || (file.indexOf('.gif') > -1)) {
		    			$('#thumb_preview').prop('src', DOMAIN + data.preivew);
		    			$('#thumb_preview').show();
	    			}
	    			// $('#download_item').html('Item: '+ file);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadThumb failed.. ');
	    	    }
	});	
}

function savePageImage(event) {
	event.preventDefault();
	var frm = document.getElementById('banner_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/save-exb-page-image',
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

function deleteImageSlider__(page_id, ps_id, gallery_id, type) {
	if(confirm('Are you sure you want to delete slider (y/n)?')) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-exb-page-image-slider',
		    data: { 'page_id': page_id, 'ps_id':ps_id, 'gallery_id': gallery_id, 'type': type },
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
	    url: '/delete-exb-page-image',
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
	if($('#'+cur_block_id)) { toggleBlock(cur_block_id); } // Close already opened block
	if(cur_input == type) {
		$('.edit-section').hide();
		cur_input = '';
		return;
	} else {
		cur_input = type;
	}
	if(type == 'h2') {
		$('.edit-section').hide();
		$('#h2_block').show();
	}
	if(type == 'h2text') {
		$('.edit-section').hide();
		$('#h2text_block').show();
	}
	if(type == 'youtube') {
		$('.edit-section').hide();
		$('#youtube_block').show();
	}
	if(type == 'audio') {
		$('.edit-section').hide();
		$('#audio_block').show();
	}
	if(type == 'h2') {
		$('.edit-section').hide();
		$('#h2_block').show();
	}
	if(type == 'image_grid') {
		$('#image_grid_pane').show();
	}
	if(type == 'banner') {
		$('.edit-section').hide();
		$('#page_image_pane').show();
		var banner_id = '<?php echo $banner_id; ?>';
		if(!isNaN(banner_id) && parseInt(banner_id) > 0) {
			$('#add_line_btn').attr('disabled', false);
			editBanner(banner_id);
		} else {
			$('#add_line_btn').attr('disabled', true);
		}
	}
	if(type == 'image') {
		$('.edit-section').hide();
		$('#image_pane').show();
	}
	if(type == 'content') {
		showContentInput();
	}
	if(type == 'slider') {
		$('.edit-section').hide();
		$('#page_image_slider').show();
	}
}

var tsr_line_count = 1;
var new_banner_line = 1;

function addNewLineInput(e, btn) {
	e.preventDefault();
	btn.blur();
	$('#banner_line_form_blk').show();
	$('#banner_line_de').val('');
	$('#banner_line_en').val('');
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
	// html = $('#banner_text_blk').html() + html;
	$('#banner_text_blk').append(html);	
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
					$('#banner_line_form_blk').show();
					$('#banner_line_de').val(data.text.line_de);
					$('#banner_line_en').val(data.text.line_en);
					$('#banner_line_size').val(data.text.size);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editBannerLine failed.. ');
	    	    }
	});	
}

function saveBannerText() {
	var bnr_line_de = $('#banner_line_de').val();
	if(bnr_line_de.length == 0) { bnr_line_de = '&nbsp;'; }
	var bnr_line_en = $('#banner_line_en').val();
	if(bnr_line_en.length == 0) { bnr_line_en = '&nbsp;'; }
	$.ajax({
	    type: 'POST',
	    url: '/save-bnr-text',
	    data: { 'id': $('#bnr_line_id').val(), 'page_id': $('#page_id').val(), 'banner_id': $('#banner_id').val(), 'line_de': bnr_line_de, 'line_en': bnr_line_en, 'size': $('#banner_line_size').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('saveBannerText response'); console.log(data);
	    			var line_de = '';
	    			var line_en = '';
	    			var blank = true;
	    			if(data.text.line_de.length > 0 && data.text.line_de != '&nbsp;') { line_de = data.text.line_de; blank = false; }
	    			if(data.text.line_en.length > 0 && data.text.line_en != '&nbsp;') { line_en = data.text.line_en; blank = false; }
					$('#banner_line_de').val('');
					$('#banner_line_en').val('');
					$('#banner_line_size').val(data.text.size);
					$('#banner_line_form_blk').hide();
					$('#tsr_text_msg').show().delay(20).fadeIn('slow');
	    			$('#tsr_text_msg').hide().delay(5000).fadeOut(2500);	    			
	    			var line_text_de = data.text.line_de;
	    			if(blank) { line_text_de = 'blank-line'; line_text_en = 'blank-line'; }
	    			var html = '<div id="tsr_line_'+data.text.id+'" style="width:100%;float:left;">' +
								 '<span style="cursor:pointer;" onclick="editBannerLine('+data.text.id+')">'+ line_text_de +'</span>' +
								 '<a href="javascript:deleteTsrLine('+data.text.id+')" style="position:relative;left:5px;font-size:14px;">x</a>' +
							   '</div>';
					if(new_banner_line == 1) {
						$('#banner_text_blk').append(html);
					} else {
						html = '<span style="cursor:pointer;" onclick="editBannerLine('+data.text.id+')">'+data.text.line_de+'</span>' +
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

function deletePage(id) {
	if(confirm('Are you sure you want to delete page (y/n)?')) {
		document.location.href = '/content/exhibition-pages/delete/'+'/'+id;		
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
	    			$('#sponsor_group_de').val(data.item.headline_de);
	    			$('#sponsor_group_en').val(data.item.headline_en);
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
	    			console.log('editDownload success');console.log(data);
	    			var file = data.item.filename;
	    			file = file.substr(file.lastIndexOf("\\")+1, file.length);
	    			if((file.indexOf('.png') > -1) || (file.indexOf('.jpg') > -1) || (file.indexOf('.gif') > -1)) {
		    			$('#download_preview').prop('src', DOMAIN + '/files/downloads/'+ file);
		    			$('#download_preview').show();
	    			}
	    			var thumb = data.item.thumb_image;
	    			if(thumb != null) {
		    			thumb = thumb.substr(thumb.lastIndexOf("\\")+1, thumb.length);
		    			if((thumb.indexOf('.png') > -1) || (thumb.indexOf('.jpg') > -1) || (thumb.indexOf('.gif') > -1)) {
			    			$('#thumb_preview').prop('src', DOMAIN + '/files/downloads/'+ thumb);
			    			$('#thumb_preview').show();
		    			}
	    			} else {
	    				$('#thumb_preview').hide();
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
var url = document.URL;
if(url.indexOf('/new_sponsor') > -1) { cur_block_id = 'sponsors_block'; }
if(url.indexOf('/downloads') > -1) { cur_block_id = 'downloads_block'; }

function toggleBlock(bid) {
	if(bid == cur_block_id) {
		$('#'+bid).hide();
		$('#'+bid+'_icon').html('+');
		cur_block_id = '';
	} else {
		if($('#'+cur_block_id)) { toggleBlock(cur_block_id); } // Close already opened block
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

function deleteDLTermsFile(id) {	
	$.ajax({
	    type: 'GET',
	    url: '/delete-dl-terms-file',
	    data: {'page_id': id},
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('deleteDLTermsFile success..');
	    			console.log(data);
	    			$('#dl_file_lbl').html('No file');
	    			$('#protected_chk').prop('checked', false);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deleteDLTermsFile failed.. ');
	    	    }
	});	
}

</script>
<link href="/js/datepick/jquery.datepick.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/datepick/jquery.plugin.js"></script>
<script src="/js/datepick/jquery.datepick.js"></script>
<script>
$j2 = jQuery.noConflict();
$j2(function() {
	$j2('#start_date').datepick( {dateFormat: 'dd/mm/yyyy'} );
	$j2('#end_date').datepick( {dateFormat: 'dd/mm/yyyy', onSelect: function() { checkDates(); } } );
});


function checkDates() {
	var s = $('#start_date').val();
	var e = $('#end_date').val();
	var ar = s.split('/');
	var d1 = new Date(ar[2], ar[1], ar[0]);
	// var d2 = new Date(e);
	var ar = e.split('/');
	var d2 = new Date(ar[2], ar[1], ar[0]);
	if((d2.getTime() - d1.getTime()) < 0) {
		$('#end_date').val('');
		$('#end_date_err').html('Invalid end date');
	} else {
		$('#end_date_err').html('');
	}
}

function resetDownloadForm() {
	$('#download_file').val('');
	$('#thumb').val('');
	$('#download_link_title').val('');
	$('#download_id').val('');
	$('#download_preview').hide();
	$('#thumb_preview').hide();
}

function checkLoc() {
  $.ajax({
      type: 'GET',
      url: 'http://ip-api.com/json',
      data: {},
      dataType: 'jsonp',
      success:function(data) { 
        if(data.status == 'success') {
          var country_code = data.countryCode.toLowerCase();
          if(country_code != 'de' && country_code != 'nl') {
          	location.href = 'http://www.google.com';
          }
        }
      },
      error:  function(jqXHR, textStatus, errorThrown) {
        console.log('ip-api.com call failed.. ');
        console.log("\n\nLocale could not be detected via ip-api.com, redirecting to /int");
      }
  });
}

checkLoc();
</script>
@stop
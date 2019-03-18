<!--  ///////////////////////////   TEASER END   ///////////////////////////////// -->

<?php
	$action = ''; $cur_block_id = ''; $cur_input = ''; $icon_class = '';
	if(strpos($_SERVER['REQUEST_URI'], '/banner')) { 
		$action = 'banner'; $cur_block_id = 'banner_block'; $cur_input = 'banner'; 
	}
	if(strpos($_SERVER['REQUEST_URI'], '/downloads')) { 
		$action = 'downloads'; $cur_block_id = 'downloads_block'; $cur_input = 'downloads_block_lbl'; 
	}
	// if(strpos($_SERVER['REQUEST_URI'], '/image_grid')) { 
	// 	$action = 'image_grid'; $cur_block_id = 'image_grid_block'; $cur_input = 'image_grid_block'; 
	// }
	if(strpos($_SERVER['REQUEST_URI'], '/new_slider') || strpos($_SERVER['REQUEST_URI'], '/slider')) { 
		$action = 'page_image_slider_block'; $cur_block_id = 'page_image_slider_block'; $cur_input = 'slider'; 
		$icon_class = 'menu-icon-active';
	}
	if(strpos($_SERVER['REQUEST_URI'], '/new_sponsor') || strpos($_SERVER['REQUEST_URI'], '/sponsor')) { 
		$action = 'sponsor'; $cur_block_id = 'sponsors_block'; $cur_input = 'sponsors_block';
	}
?>

<div id="cp_block" class="form-group" style="margin-top:20px;">
	<div style="width:100%; position:relative; top:25px; margin-bottom: 15px; clear:both;">
		    <a href="javascript:toggleInput('banner')" class="form-link menu-icon-banner" style="float:left;">Banner </a>

		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('h2text')" class="form-link menu-icon-h2text"><img src="/images/h2.png" style="width:22px;height:22px;float:left;margin-right:3px;">
		    <span style="float:left;font-size:14px;"> + Intro</span></a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('content')" class="form-link menu-icon-content"><img src="/images/text_image.png" style="width:22px;height:22px;float:left;margin-right:3px;"> </a> 
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('image_grid')" class="form-link menu-icon-image_grid"><img src="/images/new_image.png" style="width:22px;height:22px;float:left;margin-right:3px;">
		    <span style="float:left;font-size:11px;"> Grid</span></a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('image')" class="form-link menu-icon-image"><img src="/images/new_image.png" style="width:22px;height:22px;float:left;margin-right:3px;">
		    <span style="float:left;font-size:14px;"></span></a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('youtube')" class="form-link menu-icon-youtube"><img src="/images/youtube.png" style="width:30px;height:30px;float:left;margin-top:-5px;margin-right:3px;"> </a>
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    
		    <a href="javascript:toggleInput('audio')" class="form-link menu-icon-audio"><img src="/images/audio1.png" style="width:22px;height:22px;float:left;margin-top:0px;margin-right:3px;"> </a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('slider')" class="form-link menu-icon-slider {{$icon_class}}"><img src="/images/gallery.png" style="width:22px;height:22px;float:left;margin-right:3px;"> </a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="http://kunsthalle-site.dev/page/{{$page->id}}" target="_blank" class="form-link">View </a>		    
    </div>
</div>
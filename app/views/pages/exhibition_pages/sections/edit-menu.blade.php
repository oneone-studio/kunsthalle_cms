<!--  ///////////////////////////   TEASER END   ///////////////////////////////// -->

<?php
	$banner_icon_class = (strpos($_SERVER['REQUEST_URI'], '/banner')) ? 'menu-icon-active' : '';
	$downloads_icon_class = (strpos($_SERVER['REQUEST_URI'], '/downloads')) ? 'menu-icon-active' : '';
	$image_grid_icon_class = (strpos($_SERVER['REQUEST_URI'], '/image_grid')) ? 'menu-icon-active' : '';
	$slider_icon_class = (strpos($_SERVER['REQUEST_URI'], '/new_slider')) ? 'menu-icon-active' : '';
	$sponsor_icon_class = (strpos($_SERVER['REQUEST_URI'], '/new_sponsor') || strpos($_SERVER['REQUEST_URI'], '/sponsor')) ? 'menu-icon-active' : '';
?>

<div id="cp_block" class="form-group" style="margin-top:20px;">
	<div style="width:100%; position:relative; top:25px; margin-bottom: 15px; clear:both;">
		    <a href="javascript:toggleInput('banner')" class="form-link menu-icon-banner {{$banner_icon_class}}" style="float:left;">Banner </a>

		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('h2text')" class="form-link menu-icon-h2text"><img src="/images/h2.png" style="width:22px;height:22px;float:left;margin-right:3px;">
		    <span style="float:left;font-size:14px;"> + Intro</span></a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('content')" class="form-link menu-icon-content"><img src="/images/text_image.png" style="width:22px;height:22px;float:left;margin-right:3px;"> </a> 
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('image_grid')" class="form-link menu-icon-image_grid {{$image_grid_icon_class}}"><img src="/images/new_image.png" style="width:22px;height:22px;float:left;margin-right:3px;">
		    <span style="float:left;font-size:11px;"> Grid</span></a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('image')" class="form-link menu-icon-image"><img src="/images/new_image.png" style="width:22px;height:22px;float:left;margin-right:3px;">
		    <span style="float:left;font-size:14px;"></span></a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('youtube')" class="form-link menu-icon-youtube"><img src="/images/youtube.png" style="width:30px;height:30px;float:left;margin-top:-5px;margin-right:3px;"> </a>
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    
		    <a href="javascript:toggleInput('audio')" class="form-link menu-icon-audio"><img src="/images/audio1.png" style="width:22px;height:22px;float:left;margin-top:0px;margin-right:3px;"> </a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="javascript:toggleInput('slider')" class="form-link menu-icon-slider {{$slider_icon_class}}"><img src="/images/gallery.png" style="width:22px;height:22px;float:left;margin-right:3px;"> </a>
		    
		    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
		    <a href="http://kunsthalle-site.dev/page/{{$page->id}}" target="_blank" class="form-link">View </a>
    </div>
</div>
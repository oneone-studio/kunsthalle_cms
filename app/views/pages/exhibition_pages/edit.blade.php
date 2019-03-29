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
    <?php
    	$action = ''; $cur_block_id = ''; $cur_input = '';
    	if(strpos($_SERVER['REQUEST_URI'], '/banner')) { 
    		$action = 'banner'; $cur_block_id = 'banner_block'; $cur_input = 'banner_blk'; 
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/downloads')) { 
    		$action = 'downloads'; $cur_block_id = 'downloads_block'; $cur_input = 'downloads_block_lbl'; 
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/image_grid')) { 
    		$action = 'image_grid'; $cur_block_id = 'image_grid_block'; $cur_input = 'image_grid_block'; 
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/new_slider') || strpos($_SERVER['REQUEST_URI'], '/slider')) { 
    		$action = 'page_image_slider'; $cur_block_id = 'page_image_slider_block'; $cur_input = 'page_image_slider';
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/new_sponsor') || strpos($_SERVER['REQUEST_URI'], '/sponsor')) { 
    		$action = 'sponsor'; $cur_block_id = 'sponsors_block'; $cur_input = 'sponsors_block';
    	}
    ?>

<script src="/js/exb_page_vars.js?v=201903291840"></script>
<script src="/js/edit-page.js?v=201903291840"></script>
<script>
var DOMAIN = HTTP+'://<?php echo $_SERVER['SERVER_NAME'];?>';
var cur_block_id = '';
var cur_input = '';
var banner_id = '<?php echo $banner_id; ?>';

</script>
<link href="/js/datepick/jquery.datepick.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/datepick/jquery.plugin.js"></script>
<script src="/js/datepick/jquery.datepick.js"></script>
@stop
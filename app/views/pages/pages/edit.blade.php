@extends('layouts.default')

@section('content')
    <div class="page_content">
    	<div style="width:100%; clear:both;">
            <h4>Page: {{$content_section->title_de}}
      		   <a href="/content/pages/{{$menu_item_id}}/{{$cs_id}}" class="link" style="margin-left:2px;">back</a>
            </h4>
            <p>
		        <div style="list-style:none;">			
					@include('pages.pages.sections.main')
					<!--  ///////////////////////////   SPONSORS   ///////////////////////////////// -->
					@include('pages.pages.sections.sponsors')
					<!--  ///////////////////////////   DOWNLOADS   ///////////////////////////////// -->
					@include('pages.pages.sections.downloads')
					<!--  ///////////////////////////   TEASER   ///////////////////////////////// -->
					@include('pages.pages.sections.teaser')
					<!--  ///////////////////////////   CONTENT   ///////////////////////////////// -->
					@include('pages.pages.sections.edit-menu')
					<!--  ///////////////////////////   BANNERS   ///////////////////////////////// -->
					@include('pages.pages.sections.banners')
					<!--  ///////////////////////////   IMAGE GRID  ///////////////////////////////// -->
					@include('pages.pages.sections.image_grid')
					<!--  ///////////////////////////   IMAGE   ///////////////////////////////// -->
					@include('pages.pages.sections.image')
					<!--  ///////////////////////////   H2   ///////////////////////////////// -->
					@include('pages.pages.sections.h2')
					<!--  ///////////////////////////   H2 INTRO   ///////////////////////////////// -->
					@include('pages.pages.sections.h2intro')
					<!--  ///////////////////////////   PAGE CONTENT   ///////////////////////////////// -->
					@include('pages.pages.sections.page_content')
					<!--  ///////////////////////////   SLIDERS   ///////////////////////////////// -->
					@include('pages.pages.sections.slider')
					<!--  ///////////////////////////   YOUTUBE   ///////////////////////////////// -->
					@include('pages.pages.sections.youtube')
					<!--  ///////////////////////////   AUDIO   ///////////////////////////////// -->
					@include('pages.pages.sections.audio')
					<!--  ///////////////////////////   PAGE SECTIONS   ///////////////////////////////// -->
					@include('pages.pages.sections.page_sections')

			    	<?php $banner_id = 0; 
			    	if(isset($page->banner)) { $banner_id = $page->banner->id; } 
			    	?>
		    	</div>
				@if($errors->any())
				    <ul>{{ implode('', $errors->all('<li class="error">:message</li>')) }}</ul>
				@endif
      		</p> 
    </div>

    <input type="hidden" id="cs_id" value="{{$cs_id}}">
    <input type="hidden" id="page_id" value="{{$page->id}}">
    <?php
    	$action = ''; $cur_block_id = ''; $cur_input = '';
    	if(strpos($_SERVER['REQUEST_URI'], '/banner')) { 
    		$action = 'banner'; $cur_block_id = 'banner_block'; $cur_input = 'banner'; 
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/downloads')) { 
    		$action = 'downloads'; $cur_block_id = 'downloads_block'; $cur_input = 'downloads_block_lbl'; 
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/image_grid')) { 
    		$action = 'image_grid'; $cur_block_id = 'image_grid_block'; $cur_input = 'image_grid_block'; 
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/new_slider') || strpos($_SERVER['REQUEST_URI'], '/slider')) { 
    		$action = 'page_image_slider_block'; $cur_block_id = 'page_image_slider_block'; $cur_input = 'page_image_slider_block';
    	}
    	if(strpos($_SERVER['REQUEST_URI'], '/new_sponsor') || strpos($_SERVER['REQUEST_URI'], '/sponsor')) { 
    		$action = 'sponsor'; $cur_block_id = 'sponsors_block'; $cur_input = 'sponsors_block';
    	}
    ?>

<script src="/js/page_vars.js"></script>
<script src="/js/edit-page.js"></script>
<script>
var DOMAIN = HTTP+'://<?php echo $_SERVER['SERVER_NAME'];?>';
var cur_block_id = '<?php echo $cur_block_id;?>';
var cur_input = '<?php echo $cur_input;?>';
var banner_id = '<?php echo $banner_id; ?>';

</script>
@stop
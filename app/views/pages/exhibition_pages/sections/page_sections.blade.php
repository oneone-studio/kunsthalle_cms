			<!-- List of content sections -->
			@if($sections) 
			  <?php $sec_count = 0; ?>
			  <div id="content_list_pane" style="width:100%; position:relative; top:20px;">

			  @foreach($sections as $ps)
			    <?php ++$sec_count; ?>

			    @if($ps != null && ($ps->type == 'content'))

				  	<!-- <div style="clear:both;"></div> -->
				  	<div id="page_content_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[HTML / Content]</div>
					  <div id="page_content_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="page_content_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/exb-page-sections/move-up/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/exb-page-sections/move-down/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:editPageContent({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/exb-page-sections/del-page-section/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/content" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
					  	</div>
					</div>
					<div style="clear:both;height:15px;"></div>
					<div id="content_val_{{$ps->id}}">{{$ps->content_de}} </div>
					</div>
				  </div>

			  	@endif

			    @if($ps != null && ($ps->type == 'h2'))

				  <div id="h2_blk_{{$ps->id}}">
				  	<div id="h2_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Headline H2]</div>
					  <div id="page_content_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="page_content_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/exb-page-sections/move-up/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/exb-page-sections/move-down/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:editH2({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/exb-page-sections/del-page-section/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/h2" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	   </div>
				  	</div>   
					<div style="clear:both;height:15px;"></div>
				  	<div id="h2_val_{{$ps->id}}">{{$ps->headline_de}} </div>
				  	</div>
				  </div>
				</div>
				
				@endif

			    @if($ps != null && ($ps->type == 'h2text'))

				  <div id="h2text_blk_{{$ps->id}}">
				  	<div id="h2text_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Headline H2 + Intro]</div>
					  <div id="h2text_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="h2text_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/exb-page-sections/move-up/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/exb-page-sections/move-down/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:editH2text({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/exb-page-sections/del-page-section/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/h2text" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	   </div>
				  	</div>   
					<div style="clear:both;height:15px;"></div>
				  	<div id="h2_val_{{$ps->id}}">{{$ps->headline_de}} </div>
				  	</div>
				  </div>
				</div>
				
				@endif			    

			    @if($ps != null && ($ps->type == 'image'))

				  <div id="image_blk_{{$ps->id}}">
				  	<div id="image_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Image with caption]</div>
					  <div id="image_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="image_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/exb-page-sections/move-up/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/exb-page-sections/move-down/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:editImage({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/exb-page-sections/del-page-section/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/image" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	   </div>
				  	</div>   
					<div style="clear:both;height:15px;"></div>
				  	<div id="image_val_{{$ps->id}}"><img src="/files/image/{{$ps->filename}}" style="max-width:100px;max-height:100px;border:none;"><br>{{$ps->caption_de}} </div>
				  	</div>
				  </div>
				</div>
				
				@endif


			    @if($ps != null && ($ps->type == 'youtube'))

				  <div id="youtube_blk_{{$ps->id}}">
				  	<div id="youtube_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Youtube]</div>
					  <div id="youtube_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="youtube_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/page-sections/move-up/0/0/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/page-sections/move-down/0/0/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:editYoutube({{$ps->id}}, '{{$ps->url}}')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/page-sections/del-page-section/0/0/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/youtube" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	   </div>
				  	</div>   
					<div style="clear:both;height:15px;"></div>
				  	<div id="youtube_val_{{$ps->id}}"><img src="https://i1.ytimg.com/vi/{{$ps->url}}/hqdefault.jpg" style="max-width:100px;max-height:100px;border:none;"></div>
				  	</div>
				  </div>
				</div>
				
				@endif

			    @if($ps != null && ($ps->type == 'audio'))

				  <div id="audio_blk_{{$ps->id}}">
				  	<div id="audio_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Audio]</div>
					  <div id="audio_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="audio_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/page-sections/move-up/0/0/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/page-sections/move-down/0/0/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:editAudio({{$ps->id}}, '{{$ps->url}}')" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/page-sections/del-page-section/0/0/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/audio" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	   </div>
				  	</div>   
					<div style="clear:both;height:15px;"></div>
				  	<div id="audio_val_{{$ps->id}}"><iframe width="445" height="140" src="https://voicerepublic.com/embed/talks/{{$ps->url}}" frameborder="0" scrolling="no" allowfullscreen></iframe></div>
				  	</div>
				  </div>
				</div>
				
				@endif

			    @if($ps != null && ($ps->type == 'gallery' || $ps->type == 'slider'))

				  <div id="page_content_blk_{{$ps->id}}">
				  	<div id="page_content_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Image Gallery]</div>
					  <div id="page_content_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="page_content_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/exb-page-sections/move-up/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/exb-page-sections/move-down/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:openAndEditImageSlider({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/exb-page-sections/del-page-section/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/slider" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  		</div>
				  	  </div>	
				  	</div>  
				  	<div id="slider_val_{{$ps->id}}">
					  	@if(count($ps->page_slider_images))
					  		@foreach($ps->page_slider_images as $im)
					  		   <div id="slider_image_blk_{{$im->id}}" style="width:60px; float:left; border:1px solid #d9d9d9;margin-right:5px;">
					  			 <img id="gi_{{$im->id}}" src="/files/sliders/{{$im->filename}}" style="max-width:60px;border:none;">
					  		   </div>
					  		@endforeach
					  	@endif
				  	</div>
				  	</div>
				  </div>
			  	
			  	@endif

			    @if($ps != null && ($ps->type == 'image_grid'))

				  <div id="page_content_blk_{{$ps->id}}">
				  	<div id="page_content_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Image Grid]</div>
					  <div id="page_content_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="page_content_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  	@if($sec_count > 1)
					  		<a href="/exb-page-sections/move-up/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					    @endif
					  	@if($sec_count < count($sections))
					  		<a href="/exb-page-sections/move-down/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					    @endif
					  		<a href="javascript:openAndEditImageGrid({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/exb-page-sections/del-page-section/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/slider" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  		</div>
				  	  </div>	
				  	</div>  
				  	<div id="slider_val_{{$ps->id}}">
					  	@if(count($ps->grid_images))
					  		@foreach($ps->grid_images as $im)
					  		   <div id="slider_image_blk_{{$im->id}}" style="width:60px; float:left; border:1px solid #d9d9d9;margin-right:5px;">
					  			 <img id="gi_{{$im->id}}" src="/files/grid_image/{{$im->filename}}" style="max-width:60px;border:none;">
					  		   </div>
					  		@endforeach
					  	@endif
				  	</div>
				  	</div>
				  </div>
			  	
			  	@endif

			  @endforeach

			  </div>
			@endif

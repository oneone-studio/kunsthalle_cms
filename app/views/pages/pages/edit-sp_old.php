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
			{{ Form::model($page, array('route' => array('pages.update-sp', $page->id))) }}		  

				<div class="form-group">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('title_de', $page->title_de, ['placeholder' => 'Title [de]', 'style' => 'width:300px;']) }}
				    {{ Form::text('title_en', $page->title_en, ['placeholder' => 'Title [en]', 'style' => 'width:300px;']) }}
				</div>    
				<div class="form-group"> 
				    {{ Form::label('calendar', 'Calendar') }}
				    <select name="cluster_id" id="cluster_id" class="chosen-select" style="width:300px;">
				      @foreach($clusters as $cl) 
				      	 <?php $selected = ''; 
				      	 	if(isset($page->cluster) && ($cl->id == $page->cluster_id)) { $selected = ' selected="selected"'; }
				      	 ?>
				      	 <option value="{{$cl->id}}" <?php echo $selected;?> >{{$cl->title_de}} </option>
				      @endforeach
				    </select>
				</div>		

				    <!-- <a href="javascript:deletePage({{$cs_id}}, {{$page->id}})" class="icon-fixed-width icon-trash" style="margin-left:20px;"></a> -->
					<div class="form-group">
					    <label for="exampleInputEmail1"></label>
					     {{ Form::submit('Save', array('id' => 'save_page_btn', 'class' => 'pure-button button-small')) }}					     
					     <a href="javascript:deletePage({{$cs_id}},{{$page->id}})" class='button-error pure-button button-small' style="color:#fff; text-decoration:none;margin-top:2px;">Delete Page</a>
					</div>            

			    	<div style="width:100%; position:relative; top:10px; clear:both;">
						    <a href="javascript:toggleInput('teaser')" class="form-link" style="float:left;">Teaser </a>
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
						    <a href="javascript:toggleInput('h2')" class="form-link"><img src="/images/h2.png" style="width:22px;height:22px;float:left;margin-right:3px;"></a>
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
						    <a href="javascript:toggleInput('h2text')" class="form-link"><img src="/images/h2.png" style="width:22px;height:22px;float:left;margin-right:3px;">
						    <span style="float:left;font-size:14px;"> + Intro</span></a>
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
						    <a href="javascript:toggleInput('content')" class="form-link"><img src="/images/text_image.png" style="width:22px;height:22px;float:left;margin-right:3px;"> </a> 
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px;float:left; color:#888;">|</div>
						    <a href="javascript:toggleInput('image')" class="form-link"><img src="/images/new_image.png" style="width:22px;height:22px;float:left;margin-right:3px;">
						    <span style="float:left;font-size:14px;"></span></a>
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
						    <a href="javascript:toggleInput('slider')" class="form-link"><img src="/images/gallery.png" style="width:22px;height:22px;float:left;margin-right:3px;"> </a>
						    <div style="width:16px; text-align: center; display:inline; padding:0px 4px; float:left; color:#888;">|</div>
						    <a href="http://kunsthalle-site.dev/page/{{$cs_id}}/{{$page->id}}" target="_blank" class="form-link">View </a>
				    </div>
				</div>
			    {{ Form::hidden('id', $page->id) }}
			    {{ Form::hidden('cs_id', $cs_id) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id) }}

			{{ Form::close() }}		

			{{ Form::model($page, array('id' => 'teaser_form', 'route' => array('page.image.save'), 'files' => true)) }}

				<div id="page_image_pane" class="form-group" style="margin-top:20px; display:none;">
					<h4>Teaser </h4>

				    <label for="teaser_image" style="float:left;"><?php echo Form::label('teaser_caption', 'Caption'); ?> </label>
					{{ Form::text('teaser_caption', null, ['id' => 'teaser_caption', 'style' => 'width:350px;margin-top:-3px;float:left;', 'placeholder' => '']) }}
					<div style="clear:both;"></div>
				    <label for="teaser_image" style="float:left;"><?php echo Form::label('teaser_image', 'Image'); ?> </label>
				    <div style="width:50%; float:left; display:inline;">
					    <?php echo Form::file('teaser_image', ['id' => 'teaser_image', 'onchange' => 'uploadPageImage()']); ?>				    
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
						      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
						      background-size:cover; border:1px dashed #e3e3e3;"><img id="teaser_preview" src="/files/pages/<?php echo $page->page_image;?>" style="max-width:100px; max-height:100px; float:left; <?php echo $display;?>">
						      </div>
					    <?php $display = 'none;'; 
					    	  if($hasImage) { $display = 'inline-block;'; } ?>
						      <div id="image_delete_icon" sytle="width:30px;margin-left:10px;"><a href="javascript:deletePageImage({{$page->id}})" class="icon-fixed-width icon-trash" 
						      	style="display:<?php echo $display;?>"></a></div>
					    </div>
					</div>
				    <label for="" style="float:left;">{{ Form::label('text', 'Text') }}</label> 
					<div style="width:70%;float:left; padding-bottom:10px;">
					    <div style="width:100%;float:left;">
						    {{ Form::text('teaser_line', null, ['id' => 'teaser_line', 'style' => 'width:350px;margin-top:-3px;float:left;', 'placeholder' => '']) }}
						    <select name="teaser_line_size" id="teaser_line_size" style="width:80px;float:left;position:relative;top:-4px;left:7px;">
						    	<option value="S">S</option>
						    	<option value="M">M</option>
						    	<option value="L">L</option>
						    	<option value="XL">XL</option>
						    </select>
						    <input type="button" value="Save" class="btn btn-primary" onclick="saveTsrText()" style="position:relative;left:16px;top:-3px;">
						    <input type="hidden" name="tsr_line_id" id="tsr_line_id" value="0">
					    </div>
					    <div style="clear:both;"></div>
					    <div style="width:200px;float:left;padding-bottom:8px;">
							<button name="add_line_btn" id="add_line_btn" onclick="addNewLineInput(event, this)" style="padding:2px 8px;background:#888;color:#fff;font-size:14px; border:none;">+</button>
					    </div>
				    	<span id="tsr_text_msg" style="font-size:12px;color:darkgreen; float:right; display:none; text-align:right;">Saved successfully.</span>

				    	<div style="clear:both;"></div>
					    <div id="teaser_text" style="width:100%;float:left;">
					    @if(isset($page->teaser))
						    @foreach($page->teaser->teaser_text as $tx)
							    <div id="tsr_line_{{$tx->id}}" style="width:100%;float:left;">
									<span style="cursor:pointer;" onclick="editTsrLine({{$tx->id}}, {{$page->teaser->id}})">{{$tx->line}}</span>
									<a href="javascript:deleteTsrLine({{$tx->id}})" style="position:relative;left:5px;font-size:14px;">x</a>
								</div>					    
						    @endforeach
					    @endif
					    </div>
				    </div>

				    <div style="clear:both;padding:10px 0;"></div>
				    <label for="" style="float:left;">{{ Form::label('position', 'Position') }}</label>
				    <select name="position" id="position">
				    	<option value="top" @if($page->teaser && $page->teaser->text_position == 'top') selected="selected" @endif >Top </option>
				    	<option value="mid" @if($page->teaser && $page->teaser->text_position == 'middle') selected="selected" @endif >Middle </option>
				    	<option value="bottom" @if($page->teaser && $page->teaser->text_position == 'bottom') selected="selected" @endif >Bottom </option>
				    </select>

				    <div style="clear:both;"></div>
				    <button id="page_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
				    <div style="width:60%;float:left;position:relative;top:10px;left:180px;">
					    {{ Form::submit('Save Image', array('id' => 'save_page_image_btn', 'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px;')) }}
					    {{ Form::button('Cancel', array('id' => 'cancel_content_btn', 'onclick' => 'hidePageImageSection()', 'class' => 'button-error pure-button button-small', 'style' => 'height:30px; margin-top:0px; padding:3px 15px 5px 15px')) }}
					</div>

				    <div style="clear:both;"></div>
				    <!-- Teasers -->
				    <div style="width:60%;float:left;position:relative;left:180px;top:15px;margin-bottom:15px;">
				    	@if(isset($page->teaser))
				    		<div id="tsr_{{$page->teaser->id}}" style="width:60px;float:left;margin-right:3px;">
				    			<a href="javascript:deleteTeaser({{$page->teaser->id}}, {{$menu_item_id}}, {{$cs_id}}, {{$page->id}})" style="color:#555;font-size:14px;margin-right:4px;">x</a>
				    			
				    			<div onclick="editTeaser({{$page->teaser->id}})" style="width:60px;height:60px;cursor:pointer;float:left; background:url('/files/pages/{{$page->teaser->image}}') no-repeat;background-size:cover; border:1px solid #eeee88;">&nbsp;</div>
				    		</div>
				    	@endif
				    </div>	
				</div>

			    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
			    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
			    {{ Form::hidden('teaser_id', (isset($page->teaser) ? $page->teaser->id : 0), ['id' => 'teaser_id']) }}
			    {{ Form::hidden('teaser_text_id', 0, ['id' => 'teaser_text_id']) }}
			{{ Form::close() }}		


			{{ Form::model($page, array('id' => 'image_form', 'route' => array('images.save'), 'files' => true)) }}

				<div id="image_pane" class="form-group" style="margin-top:20px; display:none;">
					<h4>Image with caption </h4>

				    <label for="image" style="float:left;"><?php echo Form::label('image', 'Image'); ?> </label>
				    <div style="width:50%; float:left; display:inline;">
					    <?php echo Form::file('image', ['id' => 'image', 'onchange' => 'uploadImage()']); ?>				    
					    <!-- <input type="button" id="upload_btn" value="Upload" class="btn btn-default" onclick="saveProfileImage()"> -->
				    </div>
				
					<div class="form-groupz" style="width:100%; height:120px; clear:both;"> 
					    <label for="" style="float:left;">Preview</label>
					    <div style="width:10%; float:left; display:inline;">
					      <?php $display = 'display:none;';
						        // $hasImage = false;
						        // if(!empty($page->image)) {
						        // 	$hasImage = true;
							      	// $display = 'display:inline;';
							      	// $background = ' background:url(/files/pages/'.$page->page_image.') no-repeat;'; 
						        // }			      
					      ?>
						      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
						      background-size:cover; border:1px dashed #e3e3e3;"><img id="image_preview" src="#" 
						      style="max-width:100px; max-height:100px; float:left; <?php echo $display;?>">
						      </div>
					    <?php $display = 'none;'; 
					    	  if($hasImage) { $display = 'inline-block;'; } ?>
						      <div id="image_delete_icon" sytle="width:30px;margin-left:10px;"><a href="#" class="icon-fixed-width icon-trash" 
						      	style="display:<?php echo $display;?>"></a></div>
					    </div>
					</div>
				    <label for="" style="float:left;">{{ Form::label('text', 'Caption [de]') }}</label> 
					<div style="width:70%;float:left; padding-bottom:10px;">
					    <div style="width:100%;float:left;">
						    {{ Form::textarea('image_caption_de', null, ['id' => 'image_caption_de', 'style' => 'width:550px;height:30px;margin-top:-3px;float:left;', 'placeholder' => '']) }}
					    </div>
				    	<span id="image_text_msg" style="font-size:12px;color:darkgreen; float:right; display:none; text-align:right;">Saved successfully.</span>
				    	<div style="clear:both;"></div>
				    </div>
				    <div style="clear:both;"></div>
				    <label for="" style="float:left;">{{ Form::label('text', 'Caption [en]') }}</label> 
					<div style="width:70%;float:left; padding-bottom:10px;">
					    <div style="width:100%;float:left;">
						    {{ Form::textarea('image_caption_en', null, ['id' => 'image_caption_en', 'style' => 'width:550px;height:30px;margin-top:-3px;float:left;', 'placeholder' => '']) }}
					    </div>
				    	<span id="image_text_msg" style="font-size:12px;color:darkgreen; float:right; display:none; text-align:right;">Saved successfully.</span>
				    	<div style="clear:both;"></div>
				    </div>

				    <div style="clear:both;"></div>
				    <button id="image_status_msg" class="pure-button" style="display:none; float:right;"></button>
				    <div style="width:60%;float:left;position:relative;top:10px;left:180px;">
					    {{ Form::submit('Save Image', array('id' => 'save_image_btn', 'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px;')) }}
					    {{ Form::button('Cancel', array('id' => 'cancel_image_btn', 'onclick' => 'hideImageSection()', 'class' => 'button-error pure-button button-small', 'style' => 'height:30px; margin-top:0px; padding:3px 15px 5px 15px')) }}
					</div>

				    <div style="clear:both;"></div>
				</div>

			    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
			    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
			    {{ Form::hidden('image_id', 0, ['id' => 'image_id']) }}

			{{ Form::close() }}		


				<div id="h2_block" class="form-group" style="margin-top:20px;display:none;">
				  <form method="POST" action="/h2/save" accept-charset="UTF-8"><input name="_token" type="hidden" value="pd4F2f9FOrU92JOgFLo3ynI1l90kVrHH3unm10LO">
				    <label for="h2" style="float:left;">Small headline</label>
				    <div style="clear:both;"></div>
				    <div style="float:left;margin-top:6px;margin-right:8px;">H2 [de]:</div>
				    <input placeholder="Headline (H2)" style="width:300px;float:left;" name="h2_de" type="text" id="h2_de">
				    <div style="float:left;margin-top:6px;margin-left:20px;margin-right:8px;">H2 [en]:</div>
				    <input placeholder="Headline EN" style="width:300px;float:left;" name="h2_en" type="text" id="h2_en">
					<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
			            <input class="btn btn-primary" style="position:relative;top:10px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save">
			        </div>
					<input type="hidden" name="page_id" value="15">
				    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
				    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
				    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
				    {{ Form::hidden('h2_id', 0, ['id' => 'h2_id']) }}
				  </form>  
				</div>

				<div id="h2text_block" class="form-group" style="margin-top:20px;display:none;">
				  <form method="POST" action="/h2text/save" accept-charset="UTF-8"><input name="_token" type="hidden">
				    <label for="h2" style="float:left;">Headline</label>
				    <div style="clear:both;height:10px;"></div>
				    <div style="float:left;margin-top:6px;margin-right:8px;">H2 [de]:</div>
				    <input placeholder="Headline DE" style="width:300px;float:left;" name="h2_de" type="text" id="h2text_h2de">
				    <div style="float:left;margin-top:6px;margin-left:20px;margin-right:8px;">H2 [en]:</div>
				    <input placeholder="Headline EN" style="width:300px;float:left;" name="h2_en" type="text" id="h2text_h2en">
				    <div style="clear:both;"></div>
				    <div style="float:left;margin-top:6px;margin-right:8px;">Intro [de]:</div><div style="clear:both;"></div>
				    <?php echo Form::textarea('intro_de', null, ['id' => 'intro_de', 'style' => 'width:300px;', 'class' => 'tm_editor', 'placeholder' => 'Intro DE']); ?>
				    <div style="float:left;margin-top:6px;margin-right:8px;">Intro [en]:</div><div style="clear:both;"></div>
				    <?php echo Form::textarea('intro_en', null, ['id' => 'intro_en', 'style' => 'width:300px;', 'class' => 'tm_editor', 'placeholder' => 'Intro DE']); ?>
					<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
			            <input class="btn btn-primary" style="position:relative;top:10px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save">
			        </div>
					<input type="hidden" name="page_id" value="15">
				    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
				    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
				    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
				    {{ Form::hidden('h2text_id', 0, ['id' => 'h2text_id']) }}
				  </form>  
				</div>

			{{ Form::open(array('route' => 'page_contents.save', 'method' => 'post')) }}

				<div id="page_content" class="form-group no-display" style="position:relative; top:40px;">
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
				    {{ Form::button('Save Content', array('id' => 'save_content_btn', 'onclick' => 'saveContent()', 'class' => 'button-success button-small pure-button', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
				    {{ Form::button('Cancel', array('id' => 'cancel_content_btn', 'onclick' => 'hideContentInput()', 'class' => 'button-error button-small pure-button', 'style' => 'height:30px; margin-top:1px; padding:3px 15px 5px 15px')) }}

				    <button id="page_content_msg" class="pure-button" style="display:none; float:right;"></button>
				</div>
				<div style="clear:both;height:20px;"></div>

			    {{ Form::hidden('id', $page->id) }}
			    {{ Form::hidden('cs_id', $cs_id) }}
			    {{ Form::hidden('pc_id', 0) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id) }}

			{{ Form::close() }}

				<div id="page_image_slider" class="form-group" style="margin:20px 0px; display:none;">
			       <div style="width:100%; clear:both; margin-bottom:15px;">
			         <div id="page_image_slider_pane" style="display:none; width:100%;">
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
					</div>  

				    {{ Form::label('sliders', 'Image Sliders') }} 
				    <a href="javascript:showNewSliderForm()" style="font-size:11px; font-weight:normal;">+ Image Slider</a><br>
			        @if(count($page->page_image_sliders) > 0)
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
										      onclick="hideSliderImageForm(event, {{$slider->id}})" style="float:left; margin-left:3px;">Cancel</button>
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

				    			<li id="slider_image_list_li_{{$slider->id}}" style="padding:10px 0px;">
				    			   <div id="slider_image_list_{{$slider->id}}" style="width:100%; margin-top:20px; display:block; clear:both;">
				    				@if($slider->page_slider_images)
				    					@foreach($slider->page_slider_images as $sl_image)
				    						<div id="slider_image_{{$sl_image->id}}" style="width:90%; font-family:georgia; font-size:14px; 
				    							font-weight:normal; float:left; margin-bottom:10px; border:0px solid #e1e1e1; padding:5px;">
				    						<a href="javascript:deletePageSliderImage({{$sl_image->id}})" title="Delete" type="button" 
				    						class="icon-fixed-width icon-trash" style="margin-left:5px; vertical-align:bottom; position:relative;top:6px;"><span class="glyphicon glyphicon-trash"></span></a>
				    						<a href="javascript:editPageSliderImage({{$slider->id}}, {{$sl_image->id}})"><img src="{{$DOMAIN}}/files/sliders/{{$sl_image->filename}}" style="max-width:90px; max-height:60px;"></a></div>
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

			  @foreach($sections as $ps)

			    @if($ps != null && ($ps->type == 'content'))

				  	<!-- <div style="clear:both;"></div> -->
				  	<div id="page_content_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[HTML / Content]</div>
					  <div id="page_content_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="page_content_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  		<a href="/page-sections/move-up/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					  		<a href="/page-sections/move-down/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					  		<a href="javascript:editPageContent({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/page-sections/del-page-section/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/content" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
					  	</div>
					</div>
					<div style="clear:both;height:15px;"></div>
					<div id="content_val_{{$ps->id}}">{{$ps->title_de}} </div>
					</div>
				  </div>

			  	@endif

			    @if($ps != null && ($ps->type == 'h2'))

				  <div id="h2_blk_{{$ps->id}}">
				  	<div id="h2_{{$ps->id}}" style="width:100%; font-family:georgia; font-size:14px; font-weight:normal; float:left; margin-bottom:10px; border:1px solid #e1e1e1; padding:5px;">
					<div style="width:100%;font-size:11px;font-family:arial; color:#333;float:left;"><div style="width:40%;float:left;">[Headline H2]</div>
					  <div id="page_content_links_blk_{{$ps->id}}" style="width:60%;float:left;">
					  	<div id="page_content_links_{{$ps->id}}" style="width:100%; display:inline; float:right; text-align:right;">
					  		<a href="/page-sections/move-up/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					  		<a href="/page-sections/move-down/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					  		<a href="javascript:editH2({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/page-sections/del-page-section/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/h2" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
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
					  		<a href="/page-sections/move-up/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					  		<a href="/page-sections/move-down/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					  		<a href="javascript:editH2text({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/page-sections/del-page-section/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/h2text" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
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
					  		<a href="/page-sections/move-up/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					  		<a href="/page-sections/move-down/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					  		<a href="javascript:editImage({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/page-sections/del-page-section/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/image" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  	   </div>
				  	</div>   
					<div style="clear:both;height:15px;"></div>
				  	<div id="image_val_{{$ps->id}}"><img src="/files/image/{{$ps->filename}}" style="max-width:100px;max-height:100px;border:none;"><br>{{$ps->caption_de}} </div>
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
					  		<a href="/page-sections/move-up/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:5px;"><img src="/images/up_arrow.png" style="max-width:15px;"></a>
					  		<a href="/page-sections/move-down/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}" title="Edit" type="button" style="margin-left:2px;"><img src="/images/down_arrow.png" style="max-width:15px;"></a>
					  		<a href="javascript:openAndEditImageSlider({{$ps->id}})" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
			                <a href="/page-sections/del-page-section/{{$menu_item_id}}/{{$cs_id}}/{{$page->id}}/{{$ps->ps_id}}/{{$ps->id}}/slider" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
				  		</div>
				  	  </div>	
				  	</div>  
				  	<div id="slider_val_{{$ps->id}}">{{$ps->title}} </div>
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

function editSection(sec, id) {
	$.ajax({
	    type: 'GET',
	    url: '/get-page-section',
	    data: { 'id': id, 'page_id': $('#page_id').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editSection success..');
	    			console.log(data);
	    			// if(sec == 'h2') {

	    			// }
	    			// $('#save_content_btn').attr('onclick', 'updatePageContent(event)');
	    			// $('#content_title_de').val(data.item.title_de);
	    			// $('#content_title_en').val(data.item.title_en);
	    			// tinyMCE.get('content_subtitle_de').setContent(data.item.subtitle_de);	
	    			// tinyMCE.get('content_subtitle_en').setContent(data.item.subtitle_en);	
	    			// tinyMCE.get('content_de').setContent(data.item.content_de);	
	    			// tinyMCE.get('content_en').setContent(data.item.content_en);	
	    			// contentSortOrder = data.item.sort_order;
	    			// $('#sort_order').val(contentSortOrder);
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
function resetTeaserForm() {
	$('#teaser_form')[0].reset();
	$('#teaser_preview').hide();
	$('#teaser_id').val(0);
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

function hideSliderImageForm(event, id) {
	event.preventDefault();
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

function openAndEditImageSlider(id) {
	showSliderSection();
	hideSliderImageForm(id);
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
					'<a href="javascript:editPageSliderImage('+id+', '+img.id+')"><img src="'+DOMAIN+'/files/sliders/'+img.filename+
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

function updatePageSliderImage(event, id) {
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
			$('#gi_'+id).prop('src', DOMAIN + '/images/gallery/' + data.item.image);
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

function editTeaser(id) {
	$('#teaser_id').val(id);
	$.ajax({
	    type: 'GET',
	    url: '/get-teaser',
	    data: {'id': id},
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('editTeaser success..');
	    			console.log(data);
	    			$('#teaser_preview').prop('src', DOMAIN +'/files/pages/'+ data.teaser.image);
	    			$('#teaser_preview').show();
	    			$('#teaser_caption').val(data.teaser.caption);
	    			var txt = data.teaser.teaser_text;
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
	    		    console.log('editTeaser failed.. ');
	    	    }
	});	
}

function deleteTeaser(tsr_id) {
	// var frm = document.getElementById('teaser_form');
	$.ajax({
	    type: 'GET',
	    url: '/delete-teaser',
	    data: { 'teaser_id': tsr_id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('deleteTeaser success..'+ "\n\n");
	    			$('#teaser_preview').hide();
	    			$('#tsr_'+tsr_id).hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('deleteTeaser failed.. ');
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
	    			$('#image_caption_de').val(data.image.caption_de);
	    			$('#image_caption_en').val(data.image.caption_en);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editImage failed.. ');
	    	    }
	});	
}
function uploadPageImage() {
	var frm = document.getElementById('teaser_form');
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
	    			$('#teaser_preview').prop('src', DOMAIN + data.preivew);
	    			$('#teaser_preview').show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadPageImage failed.. ');
	    	    }
	});	
}

function savePageImage(event) {
	event.preventDefault();
	var frm = document.getElementById('teaser_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/save-page-image',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
 	    			$('#teaser_preview').show();
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

function deleteImageSlider(menu_item_id, cs_id, page_id, ps_id, gallery_id, type) {
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
	    			$('#teaser_preview').hide();
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
	if(type == 'teaser') {
		$('#page_image_slider').hide();
		$('#image_pane').hide();
		$('#page_content').hide();
		$('#h2_block').hide();
		$('#h2text_block').hide();
		$('#page_image_pane').show();
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
		$('#page_image_slider').hide();
		$('#image_pane').hide();
		$('#page_content').hide();
		$('#h2_block').hide();
		$('#h2text_block').hide();
		$('#page_image_pane').hide();
		$('#page_image_slider').show();
	}
}

var tsr_line_count = 1;
var new_teaser_line = 1;

function addNewLineInput(e, btn) {
	e.preventDefault();
	btn.blur();
	$('#teaser_line').val('');
	$('#teaser_line_size').val('');
	$('#tsr_line_id').val('0');
	new_teaser_line = 1;
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
	// html = $('#teaser_text').html() + html;
	$('#teaser_text').append(html);	
	/**/
}

function editTsrLine(id, tsr_id) {
	new_teaser_line = 0;
	$('#tsr_line_id').val(id);
	$('#teaser_id').val(tsr_id);
	$.ajax({
	    type: 'GET',
	    url: '/get-tsr-text',
	    data: { 'id': id, 'teaser_id': $('#teaser_id').val() },
	    dataType: 'json',
	    success:function(data) { 
					$('#teaser_line').val(data.text.line);
					$('#teaser_line_size').val(data.text.size);
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editTsrLine failed.. ');
	    	    }
	});	
}

function saveTsrText() {
	$.ajax({
	    type: 'POST',
	    url: '/save-tsr-text',
	    data: { 'id': $('#tsr_line_id').val(), 'page_id': $('#page_id').val(), 'teaser_id': $('#teaser_id').val(), 'line': $('#teaser_line').val(), 'size': $('#teaser_line_size').val() },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log(data);
					$('#teaser_line').val(data.text.line);
					$('#teaser_line_size').val(data.text.size);
					$('#tsr_text_msg').show().delay(20).fadeIn('slow');
	    			$('#tsr_text_msg').hide().delay(5000).fadeOut(2500);	    			

	    			var html = '<div id="tsr_line_'+data.text.id+'" style="width:100%;float:left;">' +
								 '<span style="cursor:pointer;" onclick="editTsrLine('+data.text.id+')">'+data.text.line+'</span>' +
								 '<a href="javascript:deleteTsrLine('+data.text.id+')" style="position:relative;left:5px;font-size:14px;">x</a>' +
							   '</div>';
					if(new_teaser_line == 1) {
						$('#teaser_text').append(html);
					} else {
						html = '<span style="cursor:pointer;" onclick="editTsrLine('+data.text.id+')">'+data.text.line+'</span>' +
							   '<a href="javascript:deleteTsrLine('+data.text.id+')" style="position:relative;left:5px;font-size:14px;">x</a>';
						$('#tsr_line_'+data.text.id).html(html);
					}	   
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editTsrLine failed.. ');
	    	    }
	});	
}

function deleteTsrLine(id) {
	$.ajax({
	    type: 'GET',
	    url: '/delete-tsr-text',
	    data: { 'id': id },
	    dataType: 'json',
	    success:function(data) { 
	    			$('#tsr_line_'+id).hide();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('editTsrLine failed.. ');
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
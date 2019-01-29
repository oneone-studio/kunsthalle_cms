			{{ Form::model($page, array('id' => 'banner_form', 'route' => array('page.image.save'), 'files' => true)) }}
			   <?php $display = 'display:none;';
			   		 if($action && $action == 'banner') { $display = 'display:inline;'; }
			   ?>

				<div id="page_image_pane" class="form-group edit-section" style="margin-top:20px; <?php echo $display;?>">
					<h4>Banner </h4>

				    <label for="banner_image" style="float:left;"><?php echo Form::label('banner_image', 'Image'); ?> </label>
				    <div style="width:50%; float:left; display:inline;">
					    <?php echo Form::file('banner_image', ['id' => 'banner_image', 'onchange' => 'uploadPageImage()']); ?>				    
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
						      background-size:cover; border:1px dashed #e3e3e3;"><img id="banner_preview" src="" style="max-width:100px; max-height:100px; float:left; <?php echo $display;?>">
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
						    {{ Form::text('banner_line', null, ['id' => 'banner_line', 'style' => 'width:350px;margin-top:-3px;float:left;', 'placeholder' => '']) }}
						    <select name="banner_line_size" id="banner_line_size" style="width:80px;float:left;position:relative;top:-4px;left:7px;">
						    	<option value="xs">XS</option>
						    	<option value="s">S</option>
						    	<option value="m">M</option>
						    	<option value="l">L</option>
						    	<option value="xl">XL</option>
						    </select>
						    <input type="button" value="Save" class="btn btn-primary" onclick="saveBannerText()" style="position:relative;left:16px;top:-3px;">
						    <input type="hidden" name="bnr_line_id" id="bnr_line_id" value="0">
					    </div>
					    <div style="clear:both;"></div>
					    <div style="width:200px;float:left;padding-bottom:8px;">
							<button name="add_line_btn" id="add_line_btn" onclick="addNewLineInput(event, this)" style="padding:2px 8px;background:#888;color:#fff;font-size:14px; border:none;">+</button>
					    </div>
				    	<span id="tsr_text_msg" style="font-size:12px;color:darkgreen; float:right; display:none; text-align:right;">Saved successfully.</span>

				    	<div style="clear:both;"></div>
					    <div id="banner_text" style="width:100%;float:left;">
					    @if(isset($page->banner))
						    @foreach($page->banner->banner_text as $tx)
							    <div id="tsr_line_{{$tx->id}}" style="width:100%;float:left;">
									<span style="cursor:pointer;" onclick="editBannerLine({{$tx->id}}, {{$page->banner->id}})"
									>{{{ (strlen($tx->line) > 0 && $tx->line != '&nbsp;') ? $tx->line : 'blank-line' }}}</span>
									<a href="javascript:deleteTsrLine({{$tx->id}})" style="position:relative;left:5px;font-size:14px;">x</a>
								</div>					    
						    @endforeach
					    @endif
					    </div>
				    </div>

				    <div style="clear:both;padding:10px 0;"></div>
				    <label for="" style="float:left;">{{ Form::label('position', 'Position') }}</label>
				    <select name="position" id="position">
				    	<option value="top" @if($page->banner && $page->banner->text_position == 'top') selected="selected" @endif >Top </option>
				    	<option value="mid" @if($page->banner && $page->banner->text_position == 'middle') selected="selected" @endif >Middle </option>
				    	<option value="bottom" @if($page->banner && $page->banner->text_position == 'bottom') selected="selected" @endif >Bottom </option>
				    </select>

				    <div style="clear:both;"></div>
				    <button id="page_image_status_msg" class="pure-button" style="display:none; float:right;"></button>
				    <div style="width:60%;float:left;position:relative;top:10px;left:180px;">
					    {{ Form::submit('Save Image', array('id' => 'save_page_image_btn', 'class' => 'button-success pure-button button-small', 'style' => 'height:30px; padding:3px 15px 5px 15px;')) }}
					    {{ Form::button('Cancel', array('id' => 'cancel_content_btn', 'onclick' => 'hidePageImageSection()', 'class' => 'button-error pure-button button-small', 'style' => 'height:30px; margin-top:0px; padding:3px 15px 5px 15px')) }}
					</div>

				    <div style="clear:both;"></div>
				    <!-- Banners -->
				    <div style="width:60%;float:left;position:relative;left:180px;top:15px;margin-bottom:15px;">
				    	<?php $banner_id = 0; ?>
				    	@if(isset($page->banner))
				    	    <?php $banner_id = $page->banner->id; ?>
				    		<div id="tsr_{{$page->banner->id}}" style="width:60px;float:left;margin-right:3px;">
				    			<a href="javascript:deleteBanner({{$page->banner->id}}, {{$menu_item_id}}, {{$cs_id}}, {{$page->id}})" style="color:#555;font-size:14px;margin-right:4px;">x</a>
				    			
				    			<div onclick="editBanner({{$page->banner->id}})" style="width:60px;height:60px;cursor:pointer;float:left; background:url('/files/pages/{{$page->banner->image}}') no-repeat;background-size:cover; border:1px solid #eeee88;">&nbsp;</div>
				    		</div>
				    	@endif
				    </div>	
				</div>

			    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
			    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
			    {{ Form::hidden('banner_id', (isset($page->banner) ? $page->banner->id : 0), ['id' => 'banner_id']) }}
			    {{ Form::hidden('banner_text_id', 0, ['id' => 'banner_text_id']) }}
			{{ Form::close() }}		

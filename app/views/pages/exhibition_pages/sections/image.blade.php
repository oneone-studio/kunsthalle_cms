			{{ Form::model($page, array('id' => 'image_form', 'route' => array('exb-images.save'), 'files' => true)) }}

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
						        $hasImage = false;
						        if(!empty($page->image)) {
						        	$hasImage = true;
							      	$display = 'display:inline;';
							      	$background = ' background:url(/files/pages/'.$page->page_image.') no-repeat;'; 
						        }			      
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
						    {{ Form::textarea('image_caption_de', null, ['id' => 'image_caption_de', 'style' => 'width:550px;height:30px;margin-top:-3px;float:left;', 'class' => 'tm_editor']) }}
					    </div>
				    	<span id="image_text_msg" style="font-size:12px;color:darkgreen; float:right; display:none; text-align:right;">Saved successfully.</span>
				    	<div style="clear:both;"></div>
				    </div>
				    <div style="clear:both;"></div>
				    <label for="" style="float:left;">{{ Form::label('text', 'Caption [en]') }}</label> 
					<div style="width:70%;float:left; padding-bottom:10px;">
					    <div style="width:100%;float:left;">
						    {{ Form::textarea('image_caption_en', null, ['id' => 'image_caption_en', 'style' => 'width:550px;height:30px;margin-top:-3px;float:left;', 'placeholder' => '', 'class' => 'tm_editor']) }}
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
			    {{ Form::hidden('image_id', 0, ['id' => 'image_id']) }}

			{{ Form::close() }}		

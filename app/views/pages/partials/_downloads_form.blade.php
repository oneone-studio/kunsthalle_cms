				    <div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Terms file:</div>
				    <?php echo Form::file('terms_file', ['id' => 'terms_file', 'style' => 'float:left;']); ?>
					<div style="width:100px;float:left; position:relative;left:8px;">
			            <input class="pure-button button-small" style="float:left;margin-top:6px;" type="submit" value="Save">		
			        </div>				    
			    	<div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:0px;">&nbsp;</div>
				    <div id="image_delete_icon" sytle="width:30px;"><a href="javascript:deleteDLTermsFile({{$page->id}})" 
		            class="icon-fixed-width icon-trash" style="color:#fff;z-index:9999;float:left;position:relative;left:6px;text-decoration:none;margin-top:10px;"></a></div>
			    	
				    <div id="dl_file_lbl" style="font-size:11px;position:relative;left:16px;margin-top:10px;">{{{ strlen($page->dl_terms_file) > 4 ? $page->dl_terms_file : 'No file' }}}
				    </div>				    
				    <input type="hidden" name="page_id" value="{{$page->id}}">
				    <?php if(!$is_exb): ?>
					    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
					    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
				    <?php endif; ?>
				  </form>   
				  <div style="clear:both; padding:10px 0;"><hr></div>
				  <form id="download_form" method="POST" action="{{$download_form_action}}" accept-charset="UTF-8" enctype="multipart/form-data" 
				     ><input name="_token" type="hidden">
				    <div style="clear:both;"></div>
				    <label for="download_file" style="float:left;margin-top:3px;width:130px;">File 
				    	<a href="javascript:resetDownloadForm()" style="color:blue;font-size:11px;margin-left:15px;">new</a></label>
				    <?php echo Form::file('download_file', ['id' => 'download_file', 'onchange' => 'uploadDLFile()']); ?>				    
				    <div style="clear:both;"></div>
				    <div class="dl-filename-data" style="display:none;">
					    <label for="" style="float:left;width:130px;">Download file</label>
					    <div id="dl_filename" style="width:50%; float:left; display:inline;"></div>
					</div>
				    <div style="clear:both;"></div>
				    <div class="preview-data">
					    <div id="download_item" style="width:10%; float:left; display:inline;"></div>      
					    <div style="clear:both;"></div>
					    <label for="" style="float:left;width:130px;">Preview</label>
					    <div style="width:10%; float:left; display:inline;">
					      <?php $display = 'display:none;'; ?>
						      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
						      	background-size:cover; border:1px dashed #e3e3e3;"><img id="download_preview" src="#" style="max-width:100px; max-height:100px; 
						      	float:left; <?php echo $display;?>">
						      </div>
						</div>      
					    <div style="clear:both;"></div>
					    <label for="thumb_file" style="float:left;margin-top:3px;width:130px;">Small Image</label>
					    <?php echo Form::file('thumb', ['id' => 'thumb', 'onchange' => 'uploadThumb()']); ?>				    
					    <div style="clear:both;"></div>
					    <div id="thumb_item" style="width:10%; float:left; display:inline;"></div>      
					    <div style="clear:both;"></div>
					    <label for="" style="float:left;width:130px;">Preview</label>
					    <div style="width:10%; float:left; display:inline;">
						      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
						      	background-size:cover; border:1px dashed #e3e3e3;"><img id="thumb_preview" src="#" style="max-width:100px; max-height:100px; 
						      	float:left; <?php echo $display;?>">
						      </div>
						</div>      
					</div>
				    <div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Download link title</div>
				    <div style="width:70%;display:inline-block;">
					    <input placeholder="" style="width:500px;float:left;" name="link_title_de" type="text" id="download_link_title_de">
				        <div class="inp-de">DE</div><br/>
				        <div style="clear:both;"></div>
				        <input placeholder="" style="width:500px;float:left;" name="link_title_en" type="text" id="download_link_title_en">
				        <div class="inp-en">EN</div><br/>
				    </div>    
				    <div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Protection:</div>
				    <input type="checkbox"  style="float:left;margin-right:15px;" name="protected" type="text" id="protected_chk">
				    <div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Order</div>
				    <select style="width:110px;float:left;" name="sort_order" type="text" id="download_sort_order">
				    @if(count($page->downloads) == 0)
				    	<option value="1">1 </option>
				    @endif
				    @if(count($page->downloads) > 0)
					    @for($c=1; $c<=count($page->downloads)+1; $c++)
					       <option value="{{$c}}">{{$c}} </option>
					    @endfor
					@endif
				    </select>
				    <div style="clear:both;"></div>
					<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
			            <input class="btn btn-primary" style="position:relative;top:10px;left:128px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save Download">
			        </div>

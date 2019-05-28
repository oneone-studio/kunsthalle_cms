				<!--  ///////////////////////////   DOWNLOADS   ///////////////////////////////// -->

			    <label for="Downloads" style="width:100%; float:left;margin-top:20px;cursor:pointer;" onclick="toggleBlock('downloads_block')">Downloads 
			      <span id="downloads_block_icon" style="font-size:14px;font-weight:bold;margin-left:5px;">+</span></label>

			    <?php $display = 'display:none;'; 
			    	  if($action == 'downloads') { $display = ''; }
			    ?>   
				<div id="downloads_block" class="form-group" style="margin-top:2px; {{$display}}">
				  <form id="dl_protection_form" method="post" action="/save-exb-dl-protection" enctype="multipart/form-data" onsubmit="return checkDownloadsForm()">
				    <div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Protection:</div>
				    <input type="checkbox"  style="float:left;margin-right:15px;" name="protected" type="text" id="protected_chk" 
				    	@if($page->dl_protected == 1) checked @endif>
				    <?php echo Form::file('terms_file', ['id' => 'terms_file', 'style' => 'float:left;']); ?>
					<div style="width:100px;float:left; position:relative;left:8px;">
			            <input class="pure-button button-small" style="float:left;margin-top:6px;" type="submit" value="Save">			            			
			        </div>				    
			    	<div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Terms file:</div>
				    <div id="dl_file_lbl" style="margin-left:106px;margin-top:10px;">{{{ strlen($page->dl_terms_file) > 4 ? $page->dl_terms_file : 'No file' }}}
				    	<div style="clear:both;"></div>
				    	<div id="image_delete_icon" sytle="width:30px;"><a href="javascript:deleteDLTermsFile({{$page->id}})" 
			            class="icon-fixed-width icon-trash" style="color:#fff;position:relative;left:20px;text-decoration:none;margin-top:2px;"></a></div>
				    </div>				    
				    <input type="hidden" name="page_id" value="{{$page->id}}">
				  </form>   
				  <div style="clear:both; padding:10px 0;"><hr></div>
				  <form id="download_form" method="POST" action="/exb-downloads/save" accept-charset="UTF-8" enctype="multipart/form-data" 
				     ><input name="_token" type="hidden">
				    <div style="clear:both;"></div>
				    <label for="download_file" style="float:left;margin-top:3px;width:130px;">File
				       <a href="javascript:resetDownloadForm()" style="color:blue;font-size:11px;margin-left:15px;">new</a></label>
				    <?php echo Form::file('download_file', ['id' => 'download_file', 'onchange' => 'uploadDLFile()']); ?>				    
				    <div style="clear:both;"></div>
				    <!-- <label for="" style="float:left;width:130px;">Item: </label> -->
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
				    <div style="clear:both;"></div>
				    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Download link title</div>
				    <input placeholder="" style="width:500px;float:left;" name="link_title" type="text" id="download_link_title">
				    <div style="clear:both;"></div>
					<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
			            <input class="btn btn-primary" style="position:relative;top:10px;left:128px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save Download">
			        </div>
				    {{ Form::hidden('page_id', $page->id, ['id' => 'id']) }}
				    {{ Form::hidden('download_id', 0, ['id' => 'download_id']) }}
				  </form>  					      	

		    	  @if($page->downloads)
		    	    <div style="width:100%;float:left;margin-bottom:10px;padding-left:20px;">
		    	  	@foreach($page->downloads as $sp)
		    	  		<div id="download_blk_{{$sp->id}}" style="width:50px;float:left;margin-right:20px;">
							<a href="javascript:deleteDownload({{$sp->id}})" style="color:orangered;font-size:14px;">x </a><br>
			    	  		<div style="width:50px;float:left;padding:5px; border:1px solid #e9e9e9; cursor:pointer;" onclick="editDownload({{$sp->id}})">
						    	<img src="/files/downloads/{{$sp->filename}}" style="max-width:50px;border:none;"><br>
		    	  		   </div>
		    	  	 	</div>
		    	  	@endforeach
		    	  	</div>
		    	  @endif
				</div>	

			    <?php $display = 'display:none;'; $icon_class = 'expand';
			    	  if($action == 'downloads') { $display = ''; $icon_class = 'collapse'; }
			    ?>   
			    <label id="downloads_block_lbl" class="lbl-1" onclick="toggleBlock(DOWNLOAD_BID)">Downloads
			      <div class="downloads_block_icon {{$icon_class}}">&nbsp;</div></label>

				<div id="downloads_block" class="form-group edit-section" style="margin-top:2px; {{$display}}">
				  <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
				  <form id="dl_protection_form" method="post" action="/save-exb-dl-protection" enctype="multipart/form-data" onsubmit="return checkDownloadsForm()">
				  	
				  	@include('pages.partials._downloads_form')

				    {{ Form::hidden('page_id', $page->id, ['id' => 'id']) }}
				    {{ Form::hidden('download_id', 0, ['id' => 'download_id']) }}
				  </form>  					      	

				  @include('pages.partials._downloads_list')

				</div>	

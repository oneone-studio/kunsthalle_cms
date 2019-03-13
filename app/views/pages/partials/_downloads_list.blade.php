		    	  @if(isset($downloads))
		    	    <div style="width:100%;float:left;margin-bottom:10px;padding-left:20px;">
		    	  	@foreach($downloads as $sp)
		    	  		<?php 
		    	  			$w = (strpos($sp['filename'], '.pdf') > 0) ? 100 : 50;
		    	  		?>
		    	  		<div id="download_blk_{{$sp['id']}}" style="width:{{$w}}px;float:left;margin-right:20px;">
							<a href="javascript:deleteDownload({{$sp['id']}})" style="color:orangered;font-size:14px;">x </a><br>
			    	  		<div style="width:{{$w}}px;float:left;padding:5px; border:1px solid #e9e9e9; cursor:pointer;" onclick="editDownload({{$sp['id']}})">
			    	  		<?php 
			    	  		$filename = $sp['filename'];
			    	  		if(strstr($sp['filename'], '.pdf')) { $filename = $sp['thumb_image']; }
			    	  	    ?>
			    	  	    @if(!strpos($sp['filename'], '.pdf'))
						    	<img src="/files/downloads/{{$filename}}" style="max-width:50px;border:none;">
						    @endif
						    @if(strpos($sp['filename'], '.pdf') > 0)
						    	<span style="font-size:11px;">{{$sp['filename']}}</span>
						    @endif
						    	<!-- <br>{{$sp['id']}} - {{$sp['protected']}} -->
		    	  		   </div>
		    	  	 	</div>
		    	  	@endforeach
		    	  	</div>
		    	  @endif

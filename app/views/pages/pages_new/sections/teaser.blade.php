<label for="Teasers" style="width:100%; float:left;margin-top:20px;cursor:pointer;" onclick="toggleBlock('teasers_block')">Teaser
  <span id="teasers_block_icon" style="font-size:14px;font-weight:bold;margin-left:5px;">+</span></label>

<div id="teasers_block" class="form-group edit-section" style="display:none;margin-top:2px;">
  <form id="teaser_form" method="POST" action="/teasers/save" accept-charset="UTF-8" enctype="multipart/form-data" 
     onsubmit="return checkTeasersForm()"><input name="_token" type="hidden">
    <div style="clear:both;"></div>
    <label for="teaser_file" style="float:left;width:130px;">Image</label>
    <?php echo Form::file('teaser_file', ['id' => 'teaser_file', 'onchange' => 'uploadTeaser()']); ?>				    
    <div style="clear:both;"></div>
    <label for="" style="float:left;width:130px;">Preview</label>
    <div style="width:10%; float:left; display:inline;">
      <?php $display = 'display:none;'; 
      		$src = "#";
      		$tsr_caption = '';
          $line_1 = '';
          $line_2 = '';
      		$teaser_id = 0;
      		if($page->teaser) {
      			$src = "/files/teasers/". $page->teaser->filename;
      			$display = '';
      			$tsr_caption = $page->teaser->caption;
            $line_1 = $page->teaser->line_1;
            $line_2 = $page->teaser->line_2;
      			$teaser_id = $page->teaser->id;
      		}
      ?>
	      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
	      	background-size:cover; border:1px dashed #e3e3e3;"><img id="teaser_preview" src="{{$src}}" style="max-width:100px; max-height:100px; 
	      	float:left; <?php echo $display;?>">
	      </div>
	</div>      
    <div style="clear:both;"></div>
    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Caption</div>
    <input placeholder="" style="width:500px;float:left;" name="caption" type="text" id="teaser_caption" value="{{$tsr_caption}}">
    <div style="clear:both;"></div>
    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Line 1</div>
    <input placeholder="" style="width:500px;float:left;" name="line_1" type="text" id="line_1" value="{{$line_1}}">
    <div style="clear:both;"></div>
    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Line 2 (Date)</div>
    <input placeholder="" style="width:500px;float:left;" name="line_2" type="text" id="line_1" value="{{$line_2}}">

    <div style="clear:both;"></div>
	<div class="form-group" style="margin-left:0px; width:200px;position:relative;left:128px; padding-bottom:20px;">
        <input class="pure-button button-small" style="float:left;" type="submit" value="Save Teaser">
	     <a href="javascript:deleteTeaser({{$teaser_id}})" class='button-error pure-button button-small' 
	      style="color:#fff;float:left;margin-left:5px; text-decoration:none;margin-top:2px;">Delete</a>
    </div>
    {{ Form::hidden('page_id', $page->id, ['id' => 'page_id']) }}
    {{ Form::hidden('teaser_id', $teaser_id, ['id' => 'teaser_id']) }}
    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
  </form>  					      	

  @if($page->teasers)
    <div style="width:100%;float:left;margin-bottom:10px;padding-left:20px;">
  	@foreach($page->teasers as $sp)
  		<div style="width:50px;float:left;margin-right:20px; padding:5px; border:1px solid #e9e9e9;">
  			<img src="/files/teasers/{{$sp->filename}}" style="max-width:50px;border:none;"><br>
  		    <!-- <a href="javascript:editSponsor({{$sp->id}})">{{$sp->url}} </a> -->
  		</div>
  	@endforeach
  	</div>
  @endif

</div>	
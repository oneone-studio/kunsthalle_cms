<label id="teasers_block_lbl" class="lbl-1" onclick="toggleBlock('teasers_block')">Teaser
  <span id="teasers_block_icon" style="font-size:14px;font-weight:bold;margin-left:5px;">+</span></label>

<div id="teasers_block" class="form-group edit-section" style="display:none;margin-top:2px;">
  <form id="teaser_form" method="POST" action="/exb-teasers/save" accept-charset="UTF-8" enctype="multipart/form-data" 
     onsubmit="return checkTeasersForm()"><input name="_token" type="hidden">
    <div style="clear:both;"></div>
    <label for="teaser_file" style="float:left;width:130px;">Image</label>
    <?php echo Form::file('teaser_file', ['id' => 'teaser_file', 'onchange' => 'uploadTeaser()']); ?>				    
    <div style="clear:both;"></div>
    <label for="" style="float:left;width:130px;">Preview</label>
    <div style="width:10%; float:left; display:inline;">
      <?php $display = 'display:none;'; 
      		$src = "#";
          $tsr_caption_de = '';
          $tsr_caption_en = '';
          $line_1_de = '';
          $line_1_en = '';
          $line_2_de = '';
          $line_2_en = '';
      		$teaser_id = 0;
      		if($page->teaser) {
      			$src = "/files/teasers/". $page->teaser->filename;
      			$display = '';
            $tsr_caption_de = $page->teaser->caption_de;
            $tsr_caption_en = $page->teaser->caption_en;
            $line_1_de = $page->teaser->line_1_de;
            $line_1_en = $page->teaser->line_1_en;
            $line_2_de = $page->teaser->line_2_de;
            $line_2_en = $page->teaser->line_2_en;
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
      <div style="width:70%;display:inline-block;">
        <input placeholder="DE" style="width:500px;float:left;" name="caption_de" type="text" id="teaser_caption_de" value="{{$tsr_caption_de}}">
        <div class="inp-de">DE</div>
        <div style="clear:both;"></div>
        <input placeholder="EN" style="width:500px;float:left;" name="caption_en" type="text" id="teaser_caption_en" value="{{$tsr_caption_en}}">
        <div class="inp-en">EN</div>
      </div>
      <div style="clear:both;"></div>
      <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Line 1</div>
      <div style="width:70%;display:inline-block;">
        <input placeholder="DE" style="width:500px;float:left;" name="line_1_de" type="text" id="line_1_de" value="{{$line_1_de}}">
        <div class="inp-de">DE</div>
        <div style="clear:both;"></div>
        <input placeholder="EN" style="width:500px;float:left;" name="line_1_en" type="text" id="line_1_en" value="{{$line_1_en}}">
        <div class="inp-en">EN</div>
      </div>  
      <div style="clear:both;"></div>
      <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Line 2 (Date)</div>
      <div style="width:70%;display:inline-block;">
        <input placeholder="EN" style="width:500px;float:left;" name="line_2_de" type="text" id="line_2_de" value="{{$line_2_de}}">
        <div class="inp-de">DE</div>
        <div style="clear:both;"></div>
        <input placeholder="EN" style="width:500px;float:left;" name="line_2_en" type="text" id="line_2_en" value="{{$line_2_en}}">
        <div class="inp-en">EN</div>
      </div>  

      <div style="clear:both;"></div>
  	  <div class="form-group" style="margin-left:0px; width:200px;position:relative;left:128px; padding-bottom:20px;">
          <input class="pure-button button-small" style="float:left;" type="submit" value="Save Teaser">
          <input type="button" onclick="deleteTeaser({{$teaser_id}})" class="button-error pure-button button-small" 
            style="color:#fff;float:left;margin-left:5px; text-decoration:none;margin-top:2px;padding-top:2px;" value="Delete" />
      </div>
      {{ Form::hidden('page_id', $page->id, ['id' => 'page_id']) }}
      {{ Form::hidden('teaser_id', $teaser_id, ['id' => 'teaser_id']) }}
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
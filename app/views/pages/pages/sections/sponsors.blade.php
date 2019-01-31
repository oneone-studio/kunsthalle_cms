<?php $display = 'display:none;'; $toggle_icon = '+';
      if($action == 'new_sponsor' || $action == 'sponsor') { $display = ''; $toggle_icon = '-'; }
?>   
<label id="sponsors_block_lbl" class="lbl-1" onclick="toggleBlock('sponsors_block')">Sponsor Groups 
  <span id="sponsors_block_icon" style="font-size:14px;font-weight:bold;margin-left:5px;">{{$toggle_icon}}</span></label>
<div id="sponsors_block" class="form-group edit-section" style="margin-top:2px; {{$display}}">
  <form method="POST" action="/sponsor-groups/save" accept-charset="UTF-8">
    <div style="clear:both;height:10px;"></div>
    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Headline</div>
    <div style="width:70%;display:inline-block;">
        <input placeholder="" style="width:500px;float:left;" name="sponsor_group_de" type="text" id="sponsor_group_de">
        <div class="inp-de">DE</div><br/>
        <div style="clear:both;"></div>
        <input placeholder="" style="width:500px;float:left;" name="sponsor_group_en" type="text" id="sponsor_group_en">
        <div class="inp-en">EN</div><br/>
    </div>    
    <div style="clear:both;"></div>
    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Order</div>
    <select style="width:60px;float:left;" name="sort_order" id="sg_sort_order">
       @for($i=1; $i<=10; $i++)
    	  <option value="{{$i}}">{{$i}} </option>
       @endfor
    </select>	
	<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
        <input class="btn btn-primary" style="position:relative;top:10px;left:128px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save Group">
    </div>
    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
    {{ Form::hidden('sponsor_grp_id', 0, ['id' => 'sponsor_grp_id']) }}
  </form>  

  <div id="sp_groups_blk" style="width:100%;float:left; @if(count($page->sponsor_groups)==0) display:none; @endif ">
    <label for="SponsorGroup" style="float:left;">Groups:</label>
    <div style="clear:both;"></div>
    <ul style="width:100%;float:left;list-style:none;margin-left:0;padding:0;">
    @foreach($page->sponsor_groups as $grp)
    	<li id="sp_group_{{$grp->id}}" style="font-weight:normal;">- <a href="javascript:editSponsorGroup({{$grp->id}})">{{$grp->headline_de}} </a>
    	  <a href="javascript:addSponsor({{$grp->id}}, '{{$grp->headline_de}}')" style="font-size:12px;color:blue;font-weight:normal;position:relative;left:10px;">[+ Sponsor] </a>
    	  <a href="javascript:deleteSponsorGroup({{$grp->id}})" style="position:relative;left:15px;" class="icon-fixed-width icon-trash"></a>
	      <div id="sg_form_blk_{{$grp->id}}" style="width:100%; margin:15px 0;float:left; display:none;">
			  <form id="sponsor_form_{{$grp->id}}" method="POST" action="/sponsors/save" accept-charset="UTF-8" enctype="multipart/form-data">
			    <label for="group" style="float:left;width:130px;">Group</label>
			    <span id="sponsor_group_val"></span>
			    <div style="clear:both;"></div>
			    <label for="logo" style="float:left;width:130px;">Logo</label>
			    <?php echo Form::file('logo', ['id' => 'sponsor_logo', 'onchange' => 'uploadSponsorLogo('.$grp->id.')']); ?>				    
			    <div style="clear:both;"></div>
			    <label for="" style="float:left;width:130px;">Preview</label>
			    <div style="width:10%; float:left; display:inline;">
			      <?php $display = 'display:none;'; ?>
				      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
				      background-size:cover; border:1px dashed #e3e3e3;"><img id="sponsor_preview_{{$grp->id}}" src="#" style="max-width:100px; max-height:100px; float:left; <?php echo $display;?>">
				      </div>
				</div>      
			    <div style="clear:both;"></div>
			    <div style="width:120px;float:left;margin-top:6px;margin-right:8px;">URL</div>
			    <input placeholder="" style="width:500px;float:left;" name="url" type="text" id="sponsor_url">
			    <div style="clear:both;"></div>
				<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
		            <input class="btn btn-primary" style="position:relative;top:10px;left:128px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save Sponsor">
		        </div>
				{{ Form::hidden('page_id', $page->id, ['id' => 'id']) }}
			    {{ Form::hidden('sponsor_id', 0, ['id' => 'sponsor_id']) }}
			    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
			    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
			    {{ Form::hidden('sponsor_grp_id', $grp->id , ['id' => 'sp_grp_id']) }}
			  </form>					      	
	      </div>

    	  @if($grp->sponsors)
    	    <div style="width:100%;float:left;margin-bottom:10px;padding-left:20px;">
    	  	@foreach($grp->sponsors as $sp)
    	  		<div id="sponsor_blk_{{$sp->id}}" style="width:50px;float:left;margin-right:20px;">
    	  		    <a href="javascript:deleteSponsor({{$sp->id}})" style="color:orangered;font-size:14px;">x </a><br>
	    	  		<div style="width:50px;float:left;padding:5px; border:1px solid #e9e9e9; cursor:pointer;" onclick="editSponsor({{$grp->id}}, {{$sp->id}})">
	    	  			<img src="/files/sponsors/{{$sp->logo}}" style="max-width:50px;border:none;"><br>
	    	  		</div>
    	  		</div>
    	  	@endforeach
    	  	</div>
    	  @endif
    	</li>
    @endforeach
    </ul>
  </div>
</div>
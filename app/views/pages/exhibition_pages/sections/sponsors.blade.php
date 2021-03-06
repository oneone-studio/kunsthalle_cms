<!--  ///////////////////////////   SPONSORS   ///////////////////////////////// -->
<?php $display = 'display:none;'; $icon_class = 'expand';
	  if($action == 'new_sponsor' || $action == 'sponsor') { $display = ''; $icon_class = 'collapse'; }
?>   
<label id="sponsors_block_lbl" class="lbl-1" onclick="toggleBlock('sponsors_block')">Sponsor Groups 
  <div class="sponsors_block_icon {{$icon_class}}">&nbsp;</div>
</label>
<div id="sponsors_block" class="form-group edit-section" style="margin-top:2px; {{$display}}">
    <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
    <form method="POST" action="/exb-sponsor-groups/save" accept-charset="UTF-8">
	    @include('pages.partials._sponsor_group_form')

	    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
	    {{ Form::hidden('sponsor_grp_id', 0, ['id' => 'sponsor_grp_id']) }}
    </form>  
  	<div style="width:100%;float:left;">
	    <label for="SponsorGroup" style="float:left;">Groups:</label>
	    <div style="clear:both;"></div>
	    <ul style="width:100%;float:left;list-style:none;margin-left:0;padding:0;">
	    @foreach($page->sponsor_groups as $grp)
	    	<li id="sp_grp_block_{{$grp->id}}" style="font-weight:normal;">- <a href="javascript:editSponsorGroup({{$grp->id}})">{{$grp->headline_de}} </a>
	    	  <a href="javascript:addSponsor({{$grp->id}}, '{{$grp->headline_de}}')" style="font-size:12px;color:blue;font-weight:normal;position:relative;left:10px;">[+ Sponsor] </a>
	    	  <div id="sp_grp_delete_icon" sytle="width:30px;display:inline;margin-left:10px;"><a href="javascript:deleteSpGroup({{$grp->id}})" class="icon-fixed-width icon-trash"></a></div>
		      <div id="sg_form_blk_{{$grp->id}}" style="width:100%; margin:15px 0;float:left; display:none;">

				  <form id="sponsor_form_{{$grp->id}}" method="POST" action="/exb-sponsors/save" accept-charset="UTF-8" enctype="multipart/form-data">
				    @include('pages.partials._sponsor_form')

				    <input type="hidden" name="sponsor_id" id="sponsor_id_{{$grp->id}}" value="0">
				    <input type="hidden" name="sponsor_grp_id" id="sponsor_grp_id_{{$grp->id}}" value="0">
				    <input type="hidden" name="page_id" id="page_id_{{$grp->id}}" value="{{$page->id}}">
				  </form>					      	
		      </div>

	    	  @if($grp->sponsors)
	    	    <div style="width:100%;float:left;margin-bottom:10px;padding-left:20px;">
	    	  	@foreach($grp->sponsors as $sp)
	    	  		@include('pages.partials._sponsors')
	    	  	@endforeach
	    	  	</div>
	    	  @endif
	    	</li>
	    @endforeach
    </ul>
  </div>
</div>

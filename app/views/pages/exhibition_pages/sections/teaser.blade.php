<label id="teasers_block_lbl" class="lbl-1" onclick="toggleBlock('teasers_block')">Teaser
  <div class="teasers_block_icon expand">&nbsp;</div>
</label>

<div id="teasers_block" class="form-group edit-section" style="display:none;margin-top:2px;">
  <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
  <form id="teaser_form" method="POST" action="/exb-teasers/save" accept-charset="UTF-8" enctype="multipart/form-data" 
     onsubmit="return checkTeasersForm()"><input name="_token" type="hidden">
    @include('pages.partials._teaser_form')
    
    {{ Form::hidden('page_id', $page->id, ['id' => 'page_id']) }}
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
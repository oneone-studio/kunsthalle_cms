<div id="youtube_block" class="form-group edit-section" style="margin-top:-20px;display:none;">
  <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
  <form method="POST" action="/youtube/save" accept-charset="UTF-8"><input name="_token" type="hidden">
	  @include('pages.partials._youtube_form')

    {{ Form::hidden('page_id', $page->id) }}
    {{ Form::hidden('youtube_id', 0, ['id' => 'youtube_id']) }}
  </form>  
</div>

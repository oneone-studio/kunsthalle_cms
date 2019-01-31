	{{ Form::model($page, array('route' => array('pages.update', $page->id))) }}		  

	<div class="form-group">
	    <label for="title">{{ Form::label('title', 'Title:') }}</label>
	    {{ Form::text('title_de', $page->title_de, ['placeholder' => 'Title [de]', 'style' => 'width:300px;']) }}
	    {{ Form::text('title_en', $page->title_en, ['placeholder' => 'Title [en]', 'style' => 'width:300px;']) }}
	</div>    
	<div class="form-group nl">
	    <?php echo Form::label('slug', 'Slug'); ?>
	    <?php echo Form::text('slug', null, ['style' => 'width:300px;', 'placeholder' => 'Slug']); ?>
	</div>    
	<div class="form-group"> 
	    {{ Form::label('calendar', 'Calendar') }}
	    <select name="cluster_id" id="cluster_id" class="chosen-select" style="width:650px;">
	      @if($cluster_match == false) <option value="0">None </option> @endif
	      @foreach($clusters as $cl) 
	      	 <?php $selected = ''; 
	      	 	if(isset($page->cluster) && ($cl->id == $page->cluster_id)) { $selected = ' selected="selected"'; }
	      	 ?>
	      	 <option value="{{$cl->id}}" <?php echo $selected;?> >{{$cl->title_de}} </option>
	      @endforeach
	      @if($cluster_match == true) <option value="0">None </option> @endif
	    </select>
	</div>		
	<div class="form-group"> 
	    {{ Form::label('contacts', 'Contacts') }}
	    <select name="contacts[]" id="contacts" class="chosen-select" multiple style="width:650px;">
	      @foreach($rel_contacts as $c) 
	      	 <option value="{{$c->id}}" selected="selected">{{$c->first_name .' '. $c->last_name}}</option>
	      @endforeach
	      @foreach($contacts as $c) 
	      	 <option value="{{$c->id}}" >{{$c->first_name .' '. $c->last_name}}</option>
	      @endforeach
	    </select>
	</div>		
	@if($isSectionPage)
		<div class="form-group nl" style="padding-top:10px;">
		    <label for="kevents"><?php echo Form::label('tags', 'Tags/Filter:'); ?></label>
		    <select name="tags[]" data-placeholder="Choose a Tag..." class="chosen-select" multiple="multiple" style="width:600px;" tabindex="4">
		        <option value=""></option>
    	<?php foreach($tags as $tag): 
    			 $selected = '';
    			 if(in_array($tag->id, $tag_ids)) {
    			 	$selected = ' selected="selected"';
    			 }
    	?>
		        <option value="<?php echo $tag->id;?>" <?php echo $selected;?>><?php echo $tag->id . ' - '.$tag->tag_de; ?> </option>
    	<?php endforeach; ?>
		    </select>
		</div>
	@endif	
	
	<div class="form-group nl" style="padding-top:10px;">
		<label for="kevents" style="float:left;">Active [DE]:</label>
		<div style="position:relative;left:20px;top:-2px;display:inline-block"><input type="checkbox" name="active_de" id="active_de" 
			@if($page->active_de == 1) checked="checked" @endif ></label></div>
		<div style="clear:both;"></div>
		<label for="kevents" style="float:left;">Active [EN]:</label>
		<div style="position:relative;left:20px;top:-2px;display:inline-block"><input type="checkbox" name="active_en" id="active_en" 
			@if($page->active_en == 1) checked="checked" @endif ></label></div>
	</div>
	<div class="form-group">
	    <label for="title">SEO Page Title [de]:</label>
	    {{ Form::text('seo_page_title_de', $page->seo_page_title_de, ['placeholder' => 'SEO Page Title [de]', 'style' => 'width:500px;']) }}
        <div class="inp-de" style="top:2px;">DE</div><br/>
		<div style="clear:both;"></div>
	    {{ Form::text('seo_page_title_en', $page->seo_page_title_en, ['placeholder' => 'SEO Page Title [en]', 'style' => 'width:500px;']) }}
        <div class="inp-en" style="top:2px;">EN</div><br/>
	</div>    
	<div class="form-group">
	    <label for="title">SEO Page Description [de]:</label>
	    {{ Form::text('seo_page_desc_de', $page->seo_page_desc_de, ['placeholder' => 'SEO Page Description [de]', 'style' => 'width:500px;']) }}
        <div class="inp-de" style="top:2px;">DE</div><br/>
		<div style="clear:both;"></div>
	    {{ Form::text('seo_page_desc_en', $page->seo_page_desc_en, ['placeholder' => 'SEO Page Description [en]', 'style' => 'width:500px;']) }}
        <div class="inp-en" style="top:2px;">EN</div><br/>
	</div>    

    <!-- <a href="javascript:deletePage({{$cs_id}}, {{$page->id}})" class="icon-fixed-width icon-trash" style="margin-left:20px;"></a> -->
	<div class="form-group">
	    <label for="exampleInputEmail1"></label>
	     {{ Form::submit('Save Page', array('id' => 'save_page_btn', 'class' => 'pure-button button-small')) }}					     
	     <input type="button" onclick="deletePage({{$cs_id}}, {{$menu_item_id}}, {{$page->id}})" class='button-error pure-button button-small' style="color:#fff; text-decoration:none;padding-top:2px;" value="Delete Page"/>
	</div>            
    {{ Form::hidden('id', $page->id) }}
    {{ Form::hidden('cs_id', $cs_id) }}
    {{ Form::hidden('menu_item_id', $menu_item_id) }}

{{ Form::close() }}		

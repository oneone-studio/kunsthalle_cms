@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Content Section</h3>
      <p>
		{{ Form::model($content_section, array('route' => array('content_sections.update', $content_section->id))) }}
		    
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('title_de', 'Title'); ?></label>
			    <?php echo Form::text('title_de', null, ['style' => 'width:300px;', 'placeholder' => 'Title DE']); ?>
			    <?php echo Form::text('title_en', null, ['id' => 'title_en', 'style' => 'width:300px;', 'placeholder' => 'Title EN']); ?> <span style="color:#9e9e9e; display:none; vertical-align:bottom;">en</span>
			</div>
			<div class="form-group nl">
			    <?php echo Form::label('slug', 'Slug [de]'); ?>
			    <?php echo Form::text('slug_de', null, ['style' => 'width:300px;', 'placeholder' => 'Slug [de]', 'onkeyup' => 'setSlug(this)']); ?>
			    <?php echo Form::text('slug_en', null, ['style' => 'width:300px;', 'placeholder' => 'Slug [en]', 'onkeyup' => 'convToSlug(this)']); ?>
			</div>    
			<div class="form-group nl">
			    <div style="float:left;margin-top:6px;margin-right:8px;">Headline:</div>
			    <?php echo Form::text('headline_de', null, ['id' => 'headline_de', 'style' => 'width:300px;', 'placeholder' => 'DE']); ?>
			    <?php echo Form::text('headline_en', null, ['id' => 'headline_en', 'style' => 'width:300px;', 'placeholder' => 'EN']); ?>
			</div>
			<div class="form-group nl">
			    <div style="float:left;margin-top:6px;margin-right:8px;">Detail [de]:</div><div style="clear:both;"></div>
			    <?php echo Form::textarea('detail_de', null, ['id' => 'detail_de', 'style' => 'width:300px;height:100px;', 'class' => 'tm_editor_h2intro', 'placeholder' => 'Intro DE']); ?>
			    <div style="float:left;margin-top:6px;margin-right:8px;">Detail [en]:</div><div style="clear:both;"></div>
			    <?php echo Form::textarea('detail_en', null, ['id' => 'detail_en', 'style' => 'width:300px;height:100px;', 'class' => 'tm_editor_h2intro', 'placeholder' => 'Intro DE']); ?>
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
			<div class="form-group nl">
			    <div style="float:left;margin-top:6px;margin-right:8px;">Teaser Size:</div>
			    <select style="width:70px;float:left;" name="teaser_size" id="teaser_size">
			    	<option value="s" @if($content_section->teaser_size == 's') selected="selected" @endif >Small </option>
			    	<option value="l" @if($content_section->teaser_size == 'l') selected="selected" @endif >Large </option>
			    </select>
			</div>
			<div class="form-group nl" style="padding-top:10px;">
				<label for="kevents" style="float:left;">Active [DE]:</label>
				<div style="position:relative;left:20px;top:-2px;display:inline-block"><input type="checkbox" name="active_de" id="active_de" 
					@if($content_section->active_de == 1) checked="checked" @endif ></label></div>
				<div style="clear:both;"></div>
				<label for="kevents" style="float:left;">Active [EN]:</label>
				<div style="position:relative;left:20px;top:-2px;display:inline-block"><input type="checkbox" name="active_en" id="active_en" 
					@if($content_section->active_en == 1) checked="checked" @endif ></label></div>
			</div>

			<div class="form-group">
			    <label for="exampleInputEmail1"></label>
			     <?php echo Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')); ?>
			</div>            
			
				<input type="hidden" name="id" value="{{$content_section->id}}">
				<input type="hidden" name="menu_item_id" value="{{$menu_item_id}}">

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
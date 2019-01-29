@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Content Section</h3>
      <p>
		{{ Form::open(array('route' => 'content_sections.store', 'method' => 'post')) }}
		    
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('title_de', 'Title'); ?></label>
			    <?php echo Form::text('title_de', null, ['style' => 'width:300px;', 'placeholder' => 'Title DE']); ?>
			    <?php echo Form::text('title_en', null, ['id' => 'title_en', 'style' => 'width:300px;', 'placeholder' => 'Title EN']); ?> <span style="color:#9e9e9e; display:none; vertical-align:bottom;">en</span>
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
			      @foreach($contacts as $c) 
			      	 <option value="{{$c->id}}" >{{$c->first_name .' '. $c->last_name}}</option>
			      @endforeach
			    </select>
			</div>		
			<div class="form-group nl">
			    <div style="float:left;margin-top:6px;margin-right:8px;">Teaser Size:</div>
			    <select style="width:70px;float:left;" name="teaser_size" id="teaser_size">
			    	<option value="s">Small </option>
			    	<option value="l">Large </option>
			    </select>
			</div>

			<div class="form-group">
			    <label for="exampleInputEmail1"></label>
			     <?php echo Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')); ?>
			</div>            

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
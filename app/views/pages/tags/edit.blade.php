@extends('layouts.default')


@section('content')


    <div class="page_content">
      <h3>Tag</h3>
      <p>
		<div style="list-style:none;">
		{{ Form::open(array('route' => 'tag.update', 'method' => 'post', 'class' => 'form-inline')) }}
		    
		    
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('tag_de', $tag->tag_de, ['placeholder' => 'Title [de]']) }}
				    {{ Form::text('tag_en', $tag->tag_en, ['placeholder' => 'Title [en]']) }}
				</div>

				<div class="form-group nl2">
				    <label for="exampleInputEmail1"></label>
				     {{ Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
				</div>            
		    </div>

			    {{ Form::hidden('id', $tag->id) }}

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
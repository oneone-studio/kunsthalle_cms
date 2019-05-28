@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Tag</h3>
      <p>
		{{ Form::open(array('route' => 'tags.store', 'method' => 'post')) }}
		    
		    <ul style="list-style:none;">
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('tag_de', null, ['placeholder' => 'Title [de]']) }}
				    {{ Form::text('tag_en', null, ['placeholder' => 'Title [en]']) }}
				</div>

				<div class="form-group nl2">
		            {{ Form::submit('Submit', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
		        </div>

				<input type="hidden" name="cs_id" value="{{$cs_id}}">

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
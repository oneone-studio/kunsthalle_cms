@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Department</h3>
      <p>
		{{ Form::open(array('route' => 'departments.store', 'method' => 'post')) }}
		    
		    <ul style="list-style:none;">
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('title_de', null, ['placeholder' => 'Title [de]']) }}
				    {{ Form::text('title_en', null, ['placeholder' => 'Title [en]']) }}
				</div>

				<div class="form-group nl2">
		            {{ Form::submit('Submit', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
		        </div>

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
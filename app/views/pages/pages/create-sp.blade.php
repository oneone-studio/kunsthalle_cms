@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h4>Page</h4>
      <p>
		{{ Form::open(array('route' => 'pages.store-sp', 'method' => 'post')) }}
		    
		    <ul style="list-style:none;">
				<div class="form-group">
				    <label for="title">{{ Form::label('title_de', 'Title:') }}</label>
				    {{ Form::text('title_de', null, ['placeholder' => 'Title [de]']) }}
				    {{ Form::text('title_en', null, ['placeholder' => 'Title [en]']) }}
				</div>

				<div class="form-group">
		            {{ Form::submit('Submit', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
		        </div>

				<input type="hidden" name="menu_item_id" value="{{$menu_item_id}}">
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
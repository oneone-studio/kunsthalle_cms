@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Contact</h3>
      <p>
		{{ Form::open(array('route' => 'contact.store', 'method' => 'post', 'class' => 'form-inline')) }}
		    
		    <ul style="list-style:none;">
		      <li>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('first_name', 'Name:') }}</label>
				    {{ Form::text('first_name', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('last_name', 'Nachname:') }}</label>
				    {{ Form::text('last_name', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('title', 'Titel:') }}</label>
				    {{ Form::text('title', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('department', 'Abteilung:') }}</label>
				    <select name="department">
				    	@foreach($depts as $d)
				    		<option value="{{$d->id}}">{{$d->title_de}} </option>
				    	@endforeach
				    </select>	
				    <!-- {{ Form::text('department', null, ['placeholder' => '']) }} -->
				</div>
				<div class="form-group" class="nl">
				    {{ Form::label('function_de', 'Funktion [de]:') }}
				    {{ Form::text('function_de', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    {{ Form::label('function_en', 'Funktion [en]:') }}
				    {{ Form::text('function_en', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('phone', 'Telefon:') }}</label>
				    {{ Form::text('phone', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('Email', 'Email:') }}</label>
				    {{ Form::text('email', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    {{ Form::label('Order', 'Order:') }}
				    <select name="sort_order">
				    @for($i=1; $i<=$contact_count; $i++)
				    	<option value="{{$i}}">{{$i}}</option>
				    @endfor
				    </select>
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('Display', 'Display:') }}</label>
				    <select name="display" style="width:60px;">
				    	<option value="1">Yes </option>
				    	<option value="0">No </option>
				    </select>
				</div>

				<div class="form-group nl2">
		            {{ Form::submit('Submit', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
		        </div>
		     </li>
			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
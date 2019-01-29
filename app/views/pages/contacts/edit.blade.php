@extends('layouts.default')


@section('content')


    <div class="page_content">
      <h3>Contact</h3>
      <p>
		<div style="list-style:none;">
		{{ Form::model($contact, array('route' => 'contact.update', 'method' => 'post', 'class' => 'form-inline')) }}		    		    
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
				    		<option value="{{$d->id}}" @if($d->id == $contact->department_id) selected="selected" @endif>{{$d->title_de}} </option>
				    	@endforeach
				    </select>	
				    <!-- {{ Form::text('department', null, ['placeholder' => '']) }} -->
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('function', 'Funktion:') }}</label>
				    {{ Form::text('function', null, ['placeholder' => '']) }}
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
				    	<option value="{{$i}}" @if($i == $contact->sort_order) selected="selected" @endif >{{$i}}</option>
				    @endfor
				    </select>
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('Display', 'Display:') }}</label>
				    <select name="display" style="width:60px;">
				    	<option value="1" @if($contact->display == 1) selected="selected" @endif>Yes </option>
				    	<option value="0" @if($contact->display == 0) selected="selected" @endif>No </option>
				    </select>
				</div>

				<div class="form-group nl2">
		            {{ Form::submit('Submit', array('class' => 'btn btn-primary', 'style' => 'height:30px;margin-left:192px; padding:3px 15px 5px 15px')) }}
		        </div>
		     </li>
		     </ul>

			    {{ Form::hidden('id', $contact->id) }}

		{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
	    </div>
      </p> 
    </div>

@stop
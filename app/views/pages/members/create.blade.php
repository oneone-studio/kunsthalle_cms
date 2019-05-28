@extends('layouts.default')
@section('content')

    <div class="page_content form">
      
      <h3>Member</h3>
	  
	  {{ Form::open(array('action' => 'members.store', 'method' => 'post', 'class' => 'form-inline')) }}

		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('', 'Second_Name') }}</label>
		    {{ Form::text('second_name', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('', 'First_Name') }}</label>
		    {{ Form::text('first_name', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('', 'Company') }}</label>
		    {{ Form::text('company', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('', 'Status') }}</label>
		    {{ Form::text('status', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		


		<div class="form-group btn-row">
		    <label for="exampleInputEmail1"></label>
		     {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
		</div>            

	  {{ Form::close() }}  


@stop
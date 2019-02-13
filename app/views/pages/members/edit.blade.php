@extends('layouts.default')
@section('content')

    <div class="page_content form">
      
      <h3>Member</h3>
	  
	  {{ Form::model($member, array('action' => array('members.update', $member->id), 'class' => 'form-inline')); }}

		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('', 'Second_Name') }}</label>
		    {{ Form::text('second_name', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('', 'First_Name') }}</label>
		    {{ Form::text('first_name', null, ['style' => 'width:300px;', 'rows' => 3, 'placeholder' => '']) }}
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
		     {{ Form::button('Cancel', array('class' => 'btn btn-primary', 'onclick' => 'document.location="/members"')) }}
		</div>            

		<input type="hidden" name="id" value="{{$member->id}}">
	  {{ Form::close() }}  

   </div>

@stop
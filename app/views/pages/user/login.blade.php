@extends('layouts.member')
@section('content')

    <div class="page_contentz form" style="width:570px; margin:0px auto;">
      
      <h3>Login</h3>
	  
	  {{ Form::open(array('route' => 'user.authenticate', 'method' => 'post', 'class' => 'form-inline')) }}

		@if (isset($errors) && ($errors->has('username') || $errors->has('password') ))
		  <div class="alert alert-danger">
		    @if($errors->has('username'))
		    	<?php echo $errors->first('username') . '<br>'; ?>
		    @endif	
		    @if($errors->has('password'))
		    	<?php echo $errors->first('password'); ?>
		    @endif	
		  </div>
		@endif

		<div class="form-group"> 
		    {{ Form::label('', 'Username') }}
		    {{ Form::text('username', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Password') }}
		    {{ Form::password('password', ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>

		<div class="form-group btn-row">
		    <label style="width:130px;">&nbsp;</label>
		     {{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
		     {{ Form::button('Cancel', array('class' => 'btn btn-primary', 'onclick' => 'history.go(-1)')) }}
		</div>            

	  {{ Form::close() }}  

<style>
label { width:130px; }	
</style>
@stop
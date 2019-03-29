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
		    {{ Form::text('username', null, ['id' => 'username', 'class' => 'text-inp', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Password') }}
		    {{ Form::password('password', ['class' => 'text-inp', 'placeholder' => '']) }}
		</div>

		<div class="form-group btn-row">
		    <label style="width:110px;">&nbsp;</label>
		     {{ Form::submit('Login', array('class' => 'btn btn-primary custom-btn')) }}
		     {{ Form::button('Clear', array('type' => 'reset', 'class' => 'btn btn-primary custom-btn', 'onclick' => 'doReset(this)', 'style' => 'margin-top:2px;')) }}
		</div>            

	  {{ Form::close() }}  

<script>
function doReset(btn) {
	btn.blur();
	if($('#username').length) { $('#username').trigger('focus'); }
}	
</script>
<style>
label { width:110px; margin-top:5px; }	
* { font-family:arial; font-size:14px; }
.text-inp {
	width:400px;border:1px solid #9e9e9e;border-radius:2px;font-size:14px;font-weight:bold;height:25px;padding:2px 5px; background:#fff; border-radius:2px;
}
.custom-btn {
	font-size:14px;height:25px;display:inline-block;font-weight:normal;background:#666;color:#fff;margin-right:1px;padding:1px 10px 3px 10px;border-radius:2px;
}
.btn-row {
	margin-top:5px;
}
</style>
@stop
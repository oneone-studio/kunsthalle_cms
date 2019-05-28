@extends('layouts.default')
@section('content')

    <div class="page_content form">
      
      <h4>Settings</h4><br><br>
	  
	  {{ Form::model($data, array('action' => array('settings.save'), 'files' => true, 'class' => 'form-inline')); }}
		<div class="form-group"> 
		    {{ Form::label('dl_password', 'Downloads Password') }}
		    {{ Form::text('dl_password', $data['settings']['dl_password'], ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group btn-row" style="margin-top:20px;">
		    <label for="exampleInputEmail1"></label>
		</div>            

		<div class="form-group"> 
		    {{ Form::label('admin_password', 'Admin Password') }}
		    <?php $ph = '*********';
		    	if(isset($data['user']['password']) && strlen($data['user']['password']) > 0) { 
		    		$ph = '';
		    		for($i=0; $i<strlen($data['user']['password_text']); $i++) { $ph .= '*'; }
		    	}
		    ?>
		    {{ Form::text('admin_password', null, ['style' => 'width:300px;', 'placeholder' => $ph]) }}
		</div>
		<div class="form-group btn-row" style="margin-top:20px;">
		    <label for="exampleInputEmail1"></label>
		     {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
		</div>            
	  {{ Form::close() }}  

   </div>

@stop
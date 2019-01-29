@extends('layouts.default')
@section('content')

    <div class="page_content form">
      
      <h3>Profile</h3>
	  
	  {{ Form::open(array('action' => 'profiles.store', 'method' => 'post', 'class' => 'form-inline')) }}

		<div class="form-group"> 
		    {{ Form::label('', 'Name') }}
		    {{ Form::text('name', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group" style="margin-top:5px;"> 
		    {{ Form::label('', 'Addition') }}
		    {{ Form::text('addition', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group" style="margin-top:5px;"> 
		    {{ Form::label('', 'Short Description', ['style' => 'vertical-align:top; margin-top:1px;']) }}
		    {{ Form::textarea('short_description', null, ['style' => 'width:300px;height:30px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group" style="margin-top:5px;"> 
		    {{ Form::label('', 'City') }}
		    {{ Form::text('city', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Street') }}
		    {{ Form::text('street', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'House No.') }}
		    {{ Form::text('house_number', null, ['style' => 'width:50px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Postcode') }}
		    {{ Form::text('postcode', null, ['style' => 'width:60px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'State') }}
		    {{ Form::select('state', $states) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Country') }}
			<select name="country_code" id="country_code">
		 	 <?php 
		 	 	$optgroups = 0;
			 	foreach($countries as $code => $c): 
		 		   if($code == 'optgroup') { 
		 		 	  ++$optgroups;
		 		 	  if($optgroups > 1) { echo '</optgroup>'; }
			 	?>
			 			<optgroup label="{{$c}}">
	         <?php } else { ?>
			   			<option value="{{$code}}">{{$c}} </option>
			 <?php } ?>
		 <?php endforeach; ?>
			</select>		    
			<input type="hidden" name="country" id="country">
		</div>
		<div class="form-group"> 
		    {{ Form::label('email', 'Email') }}
		    {{ Form::text('email', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Phone') }}
		    {{ Form::text('phone', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Fax') }}
		    {{ Form::text('fax', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('url', 'URL') }}
		    {{ Form::text('url', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('members', 'Members') }}
		    <select name="members[]" id="members" class="chosen-select" multiple style="width:300px;" tabindex="6">
		      @foreach($available_members as $m) 
		      	 <option value="{{$m->id}}" >{{$m->first_name}} {{$m->second_name}} </option>
		      @endforeach

		    </select>
		</div>		
		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('retired', 'Retired member') }}</label>
		    {{ Form::checkbox('retired', null, false, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    <label for="exampleInp utEmail1">{{ Form::label('institution', 'Institution') }}</label>
		    {{ Form::checkbox('institution', null, false, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>

		<div class="form-group btn-row">
			 <label style="width:120px;">&nbsp;</label>
		     {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
		     {{ Form::button('Cancel', array('class' => 'btn btn-primary', 'onclick' => 'document.location="/profiles"')) }}
		</div>            

	  {{ Form::close() }}  

{{ HTML::script('js/profile.js'); }}

@stop
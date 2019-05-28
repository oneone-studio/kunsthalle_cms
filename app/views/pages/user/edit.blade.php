@extends('layouts.default')
@section('content')

	<?php
		  // echo '<pre>'; print_r($members); echo '<br><br><br>';exit;
		  $member_ids = [];
		  foreach($profile->members as $m) {
		  	$member_ids[] = $m->id;
		  }
		  // echo '<pre>'; print_r($member_ids); exit;
	?>

    <div class="page_content form">
      
      <h3>Profile</h3>
	  
	  {{ Form::model($profile, array('action' => array('profiles.update', $profile->id), 'onsubmit' => 'setCountry()', 'class' => 'form-inline')); }}

		<div class="form-group"> 
		    {{ Form::label('', 'Name') }}
		    {{ Form::text('name', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group" style="margin-top:5px;"> 
		    {{ Form::label('', 'Addition') }}
		    {{ Form::text('addition', null, ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('', 'Short Description') }}
		    {{ Form::textarea('short_description', null, ['style' => 'width:300px;', 'rows' => 3, 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
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
	         <?php } else { 
	         		 $selected = '';
	         		 if($code == $profile->country_code) { $selected = ' selected="selected"'; }
	         	?>
			   			<option value="{{$code}}" {{$selected}} >{{$c}} </option>
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
		      @foreach($profile->members as $m) 
		      	 <?php $selected = ''; ?>
		      	 <!-- @if(in_array($m->id, $member_ids)) -->
		      	 	<?php $selected = ' selected="selected"'; ?>
		      	 <!-- @endif -->
		      	 <option value="{{$m->id}}" <?php echo $selected;?> >{{$m->first_name}} {{$m->second_name}} </option>
		      @endforeach
		      @foreach($available_members as $m) 
		      	 <option value="{{$m->id}}" >{{$m->first_name}} {{$m->second_name}} </option>
		      @endforeach

		    </select>
		</div>		
		<div class="form-group" style="margin-top:20px;"> 
		    {{ Form::label('retired', 'Retired member') }}
		    {{ Form::checkbox('retired', null, ($profile->active == 1 ? true : false), ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>
		<div class="form-group"> 
		    {{ Form::label('institution', 'Institution') }}
		    {{ Form::checkbox('institution', null, ($profile->institution == 1 ? true : false), ['style' => 'width:300px;', 'placeholder' => '']) }}
		</div>

		<div class="form-group" style="margin-top:20px;">
		    <label for="profile_image" style="float:left;"><?php echo Form::label('profile_image', 'Teaserbild'); ?></label>
		    <div id="image_pane" style="width:50%; float:left; display:inline;">
			    <?php echo Form::file('profile_image', ['id' => 'profile_image', 'onchange' => 'uploadProfileImage()']); ?>				    
			    <!-- <input type="button" id="upload_btn" value="Upload" class="btn btn-default" onclick="saveProfileImage()"> -->
		    </div>
		</div>
		<div class="form-group" style="width:100%; height:120px; clear:both;"> 
		    <label for="profile_image_pane" style="float:left;">Preview</label>
		    <div id="profile_image_pane" style="width:10%; float:left; display:inline;">
		      <?php $display = 'display:none;';
			        $hasImage = false;
			        if(!empty($profile->profile_image)) { 
			        	$hasImage = true;
				      	$display = 'display:inline;';
				      	$background = ' background:url(/files/profiles/'.$profile->profile_image.') no-repeat;'; 
			        }			      
		      ?>
			      <div style="width:70px !important; height:100px; display:inline-block; margin-left:0px; 
			      background-size:70px 100px; border:1px dashed #e3e3e3;"><img id="preview" src="/files/profiles/<?php echo $profile->profile_image;?>" style="max-width:70px; max-height:100px; float:left; <?php echo $display;?>">
			      </div>
		    <?php $display = 'none;'; 
		    	  if($hasImage) { $display = 'inline-block;'; } ?>
			      <div id="image_delete_icon" sytle="width:30px;margin-left:10px;"><a href="javascript:deleteProfileImage({{$profile->id}})" class="icon-fixed-width icon-trash" style="display:<?php echo $display;?>"></a></div>
		    </div>
		</div>

		<div class="form-group btn-row">
			 <label style="width:120px;">&nbsp;</label>
		     {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
		     {{ Form::button('Cancel', array('class' => 'btn btn-primary', 'onclick' => 'document.location="/profiles"')) }}
		</div>            

		<input type="hidden" name="id" value="{{$profile->id}}">
	  {{ Form::close() }}  

   </div>

{{ HTML::script('js/profile.js'); }}

@stop
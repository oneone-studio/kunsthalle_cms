@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Sponsor</h3>
      <p>
		{{ Form::model($sponsor, array('route' => 'sponsor.store', 'method' => 'post', 'class' => 'form-inline', 'files' => true)) }}
		    
		    <ul style="list-style:none;">
		      <li>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('title', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('url', 'URL:') }}</label>
				    {{ Form::text('url', null, ['placeholder' => '']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="logo" style="float:left;"><?php echo Form::label('logo', 'Logo'); ?> </label>
				    <div style="width:50%; float:left; display:inline;">
					    <?php echo Form::file('logo', ['id' => 'logo', 'onchange' => 'uploadLogo()']); ?>				    
				    </div>
					<div class="form-groupz" style="width:100%; height:120px; clear:both;"> 
					    <label for="" style="float:left;">Preview</label>
					    <div style="width:10%; float:left; display:inline;">
					      <?php $display = 'display:none;';
					        $hasImage = false;
					        if($sponsor->logo) { $display = 'display:inline;'; $hasImage = true; }
					      ?>
						      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
						      background-size:cover; border:1px dashed #e3e3e3;"><img id="image_preview" src="#" 
						      style="max-width:100px; max-height:100px; float:left; <?php echo $display;?>">
						      </div>
					    <?php $display = 'none;'; 
					    	  if($hasImage) { $display = 'inline-block;'; } ?>
						      <div id="image_delete_icon" sytle="width:30px;margin-left:10px;"><a href="#" class="icon-fixed-width icon-trash" 
						      	style="display:<?php echo $display;?>"></a></div>
					    </div>
					</div>
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

<script>

function uploadLogo() {
	var frm = document.getElementById('sp_form');
	var formData = new FormData(frm);
	$.ajax({
	    type: 'POST',
	    url: '/upload-sponsor-logo',
	    data: formData,
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadLogo success..');
	    			console.log(data);
	    			$('#preview').prop('src', DOMAIN + data.preivew);
	    			$('#preview').show();
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('uploadLogo failed.. ');
	    	    }
	});	
}

</script>

@stop
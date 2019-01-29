@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h4>Exhibition Page</h4>
      <p>
		{{ Form::open(array('route' => 'exb-pages.save', 'method' => 'post')) }}
		    
		    <ul style="list-style:none;">
				<div class="form-group">
				    <label for="title">{{ Form::label('title_de', 'Title:') }}</label>
				    {{ Form::text('title_de', null, ['placeholder' => 'Title [de]']) }}
				    {{ Form::text('title_en', null, ['placeholder' => 'Title [en]']) }}
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1" style="float:left;"><?php echo Form::label('start_date', 'Start Date'); ?></label>
					<div style="width:400px; display:inline-block; margin-left:4px; margin-bottom:10px;">    
				    	<?php echo Form::text('start_date', null, ['style' => 'width:100px;']); ?>
				    </div>
				</div>	
				<div class="form-group">
				    <label for="exampleInputEmail1" style="float:left;"><?php echo Form::label('end_date', 'End Date'); ?></label>
					<div style="width:400px; display:inline-block; margin-left:4px; margin-bottom:10px;">    
				    	<?php echo Form::text('end_date', null, ['style' => 'width:100px;']); ?>
				    	<span id="end_date_err" style="margin-left:10px;font-size:12px; color:red;"></span>
				    </div>
				</div>	
				<div class="form-group"> 
				    {{ Form::label('calendar', 'Calendar') }}
				    <select name="cluster_id" id="cluster_id" class="chosen-select" style="width:650px;">
				      <option value="0">None </option>
				      @foreach($clusters as $cl) 
				      	 <option value="{{$cl->id}}">{{$cl->title_de}} </option>
				      @endforeach
				    </select>
				</div>		
				<div class="form-group"> 
				    {{ Form::label('contacts', 'Contacts') }}
				    <select name="contacts[]" id="contacts" class="chosen-select" multiple style="width:650px;">
				      @foreach($contacts as $c) 
				      	 <option value="{{$c->id}}" >{{$c->first_name .' '. $c->last_name}}</option>
				      @endforeach
				    </select>
				</div>		

				<div class="form-group">
		            {{ Form::submit('Submit', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
		        </div>

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>
<link href="/js/datepick/jquery.datepick.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/datepick/jquery.plugin.js"></script>
<script src="/js/datepick/jquery.datepick.js"></script>
<script>
$j2 = jQuery.noConflict();
$j2(function() {
	$j2('#start_date').datepick( {dateFormat: 'dd/mm/yyyy'} );
	$j2('#end_date').datepick( {dateFormat: 'dd/mm/yyyy', onSelect: function() { checkDates(); } } );
});


function checkDates() {
	var s = $('#start_date').val();
	var e = $('#end_date').val();
	var ar = s.split('/');
	var d1 = new Date(ar[2], ar[1], ar[0]);
	// var d2 = new Date(e);
	var ar = e.split('/');
	var d2 = new Date(ar[2], ar[1], ar[0]);
	if((d2.getTime() - d1.getTime()) < 0) {
		$('#end_date').val('');
		$('#end_date_err').html('Invalid end date');
	} else {
		$('#end_date_err').html('');
	}
}

</script>

@stop
@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Cluster</h3>
      <p>
		{{ Form::open(array('route' => 'event_clusters.store', 'method' => 'post')) }}
		    
		    <ul style="list-style:none;">
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('title_de') }}
				    {{ Form::text('title_en') }}
				</div>
				<div class="form-group">
				    <label for="subtitle">{{ Form::label('subtitle', 'Subtitle:') }}</label>
				    {{ Form::textarea('subtitle_de', null, ['rows' => 3, 'style' => 'vertical-align:top;']) }}
				    {{ Form::textarea('subtitle_en', null, ['rows' => 3, 'style' => 'vertical-align:top;']) }}
				</div>
				<div class="form-group" class="nl">
				    <label for="exampleInputEmail1">{{ Form::label('remarks', 'Remarks:') }}</label>
				    {{ Form::textarea('remarks_de', null, ['rows' => 6, 'style' => 'vertical-align:top;']) }}
				    {{ Form::textarea('remarks_en', null, ['rows' => 6, 'style' => 'vertical-align:top;']) }}
				</div>

				<div class="form-group">
				    <label for="kevents">{{ Form::label('tags', 'Tags/Filter:') }}</label>
				    <select name="tags[]" data-placeholder="Choose a Tag..." class="chosen-select" multiple="multiple" style="width:300px;" tabindex="4">
				        <option value=""></option>
	        	<?php foreach($tags as $tag): 
	        			 $selected = '';
	        	?>
				        <option value="<?php echo $tag->id;?>" <?php echo $selected;?>><?php echo $tag->id . ' - '.$tag->tag_en; ?> </option>
	        	<?php endforeach; ?>
				    </select>
				</div>

				<div class="form-group">
				    <label for="kevents">{{ Form::label('kevents', 'Event:') }}</label>
				    <select name="kevents[]" data-placeholder="Choose an Event..." class="chosen-select" multiple="multiple" style="width:300px;" tabindex="4">
				        <option value=""></option>
	        	<?php foreach($k_events as $ke): 
	        			 $selected = '';
	        	?>
				        <option value="<?php echo $ke->id;?>" <?php echo $selected;?>><?php echo $ke->id . ' - '.$ke->title; ?> </option>
	        	<?php endforeach; ?>
				    </select>
				</div>

				<div class="form-group"><h3>Costs</h3>
				</div>	

				<div class="form-group nl">
				    <label for="subtitle">{{ Form::label('pay_3_months_in_advance', 'Pay 3 months in advance') }}</label>
				    <div style="width:130px; float:left;">{{ Form::text('cost_3_month_in_advance_adult', null, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-left:5px;">adult</div> </div>
				    <div style="width:130px; float:left;">{{ Form::text('cost_3_month_in_advance_child', null, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-left:5px;">children</div> </div>
				    <div style="width:130px; float:left;">{{ Form::text('cost_3_month_in_advance_members', null, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-left:5px;">members</div> </div>
				</div>

				<div class="form-group nl">
				    <label for="subtitle">{{ Form::label('pay_all_at_once', 'Pay all at once') }}</label>
				    <div style="width:130px; float:left;">{{ Form::text('cost_all_at_once_adult', null, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-left:5px;">adult</div> </div>
				    <div style="width:130px; float:left;">{{ Form::text('cost_all_at_once_child', null, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-left:5px;">children</div> </div>
				    <div style="width:130px; float:left;">{{ Form::text('cost_all_at_once_members', null, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-left:5px;">members</div> </div>
				</div>

				<div class="form-group nl2">
		            {{ Form::submit('Submit', array('class' => 'btn')) }}
		        </div>

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
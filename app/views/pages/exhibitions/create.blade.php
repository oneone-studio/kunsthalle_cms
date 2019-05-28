@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Exhibition</h3>
      <p>
		<ul style="list-style:none;">
		{{ Form::open(array('route' => 'exhibitions.store', 'method' => 'post')) }}
		    
		    <ul style="list-style:none;">
		        <li>
			    <label for="title">{{ Form::label('title', 'Title (de):') }}</label>
				    {{ Form::textarea('title_de', null, ['style' => 'width:800px; height:40px;', 'placeholder' => 'de']) }}<br>
				    <label for="title">{{ Form::label('title', 'Title (en):') }}</label>
				    {{ Form::textarea('title_en', null, ['style' => 'width:800px; height:40px;', 'placeholder' => 'en']) }}
			        </li>
		        <li>
				    <label for="subtitle">{{ Form::label('subtitle', 'Subtitle (de):') }}</label>
				    {{ Form::textarea('subtitle_de', null, ['style' => 'width:800px; height:50px;', 'placeholder' => 'de']) }}<br>
				    <label for="subtitle">{{ Form::label('subtitle', 'Subtitle (de):') }}</label>
				    {{ Form::textarea('subtitle_en', null, ['style' => 'width:800px; height:50px;', 'placeholder' => 'en']) }}
		        </li>    
				<div class="form-group" class="nl">
				    <label for="exampleInputEmail1">{{ Form::label('content_de', 'Content (de)') }}</label>
				    {{ Form::textarea('content_de', null, ['style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'de']) }}<br>
				    <label for="exampleInputEmail1">{{ Form::label('content_de', 'Content (en)') }}</label>			    
				    {{ Form::textarea('content_en', null, ['style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'en']) }}
				</div>
		        <li>
		            {{ Form::label('start_date', 'Start Date:') }}
		            <input name="start_date" value="<?php echo date('Y-m-d');?>">
		        </li>    
		        <li>
		            {{ Form::label('end_date', 'End Date:') }}
		            <input name="end_date" value="<?php echo date('Y-m-d');?>">
		        </li>    

		        <li>
			    <label for="cluster">{{ Form::label('cluster', 'Cluster:') }}</label>
				    <select name="cluster" data-placeholder="Choose a cluster" class="chosen-select" style="width:300px;" tabindex="4">
				        <option value=""></option>
		        	<?php foreach($clusters as $cl): ?>
					        <option value="<?php echo $cl->id;?>"><?php echo $cl->id . ' - '.$cl->title_en; ?> </option>
		        	<?php endforeach; ?>
				    </select>
			    </li>

			    <li style="margin-top:20px;">
		            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
		        </li>
		    </ul>

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
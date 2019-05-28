@extends('layouts.default')


@section('content')

	<?php
		$exb_ids = [];
		foreach($cluster->exhibitions as $e) {
			$exb_ids[] = $e->id;
		}		
		$tag_ids = [];
// echo '<pre>'; print_r($exhibitions); exit;		
		foreach($cluster->tags as $t) {
			$tag_ids[] = $t->id;
		}		
		// echo 'INFO: '; print_r($exhibition_ids); exit;
		/**/
	?>
    <div class="page_content">
      <h3>Cluster</h3>
      <p>
		<div style="list-style:none;">
		{{ Form::open(array('route' => 'exhibition_cluster.update', 'method' => 'post', 'class' => 'form-inline')) }}
		    
		    
				<div class="form-group nl">
				    <label for="title">&nbsp;</label>
				    <label style="width:316px; font-size:11px; font-style:normal; color:#888;">DE</label>
				    <label style="color:#888; font-size:11px; font-style:normal;">EN</label>
				</div>
				<div class="form-group nl">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('title_de', $cluster->title_de, ['style' => 'width:300px;']) }}
				    {{ Form::text('title_en', $cluster->title_en, ['style' => 'width:300px;']) }}
				</div>
				<div class="form-group nl">
				    <label for="subtitle">{{ Form::label('subtitle', 'Subtitle:') }}</label>
				    {{ Form::textarea('subtitle_de', $cluster->subtitle_de, ['rows' => 3, 'style' => 'vertical-align:top;', 'style' => 'width:300px;']) }}
				    {{ Form::textarea('subtitle_en', $cluster->subtitle_en, ['rows' => 3, 'style' => 'vertical-align:top;', 'style' => 'width:300px;']) }}
				</div>
				<div class="form-group nl">
				    <label for="exampleInputEmail1">{{ Form::label('remarks', 'Remarks:') }}</label>
				    {{ Form::textarea('remarks_de', $cluster->remarks_de, ['rows' => 6, 'style' => 'vertical-align:top; width:300px;']) }}
				    {{ Form::textarea('remarks_en', $cluster->remarks_en, ['rows' => 6, 'style' => 'vertical-align:top; width:300px;']) }}
				</div>

				<div class="form-group nl" style="padding-top:10px;">
				    <label for="exhibitions">{{ Form::label('tags', 'Tags/Filter:') }}</label>
				    <select name="tags[]" data-placeholder="Choose a Tag..." class="chosen-select" multiple="multiple" style="width:300px;" tabindex="4">
				        <option value=""></option>
	        	<?php foreach($tags as $tag): 
	        			 $selected = '';
	        			 if(in_array($tag->id, $tag_ids)) {
	        			 	$selected = ' selected="selected"';
	        			 }
	        	?>
				        <option value="<?php echo $tag->id;?>" <?php echo $selected;?>><?php echo $tag->id . ' - '.$tag->tag_en; ?> </option>
	        	<?php endforeach; ?>
				    </select>
				</div>

				<div class="form-group nl">
				    <label for="exhibitions">{{ Form::label('exhibitions', 'Exhibition:') }}</label>
				    <select name="exhibitions[]" data-placeholder="Choose an Exhibition..." class="chosen-select" multiple="multiple" style="width:300px;" tabindex="4">
				        <option value=""></option>
	        	<?php foreach($exhibitions as $ke): 
	        			 $selected = '';
	        			 if(in_array($ke->id, $exb_ids)) {
	        			 	$selected = ' selected="selected"';
	        			 }
	        	?>
				        <option value="<?php echo $ke->id;?>" <?php echo $selected;?>><?php echo $ke->id . ' - '.$ke->title; ?> </option>
	        	<?php endforeach; ?>
				    </select>
				</div>

				<div class="form-group nl"><h3>Costs</h3>
				</div>	

				<div class="form-group nl">
				    <label for="subtitle" style="float:left;">{{ Form::label('pay_3_months_in_advance', 'Pay 3 months in advance') }}</label>
				    <div style="width:50%; float:left; display:block;">
				       <ul style="list-style:none; margin-left:0;">
					    <li style="width:100%; float:left; padding-bottom:5px;">{{ Form::text('cost_3_month_in_advance_adult', $cluster->cost_3_month_in_advance_adult, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-top:6px; margin-left:5px;">adult</div> </li>
					    <li style="width:100%; float:left; padding-bottom:5px;">{{ Form::text('cost_3_month_in_advance_child', $cluster->cost_3_month_in_advance_child, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-top:6px; margin-left:5px;">children</div> </li>
					    <li style="width:100%; float:left; padding-bottom:5px;">{{ Form::text('cost_3_month_in_advance_members', $cluster->cost_3_month_in_advance_members, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-top:6px; margin-left:5px;">members</div> </li>
					   </ul> 
					</div>    
				</div>

				<div class="form-group nl" style="padding-top:10px;">
				    <label for="subtitle" style="float:left;">{{ Form::label('pay_all_at_once', 'Pay all at once') }}</label>
				    <div style="width:50%; float:left; display:block;">
				       <ul style="list-style:none; margin-left:0;">
					    <li style="width:100%; float:left; padding-bottom:5px;">{{ Form::text('cost_all_at_once_adult', $cluster->cost_all_at_once_adult, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-top:5px; margin-left:5px;">adult</div> </li>
					    <li style="width:100%; float:left; padding-bottom:5px;">{{ Form::text('cost_all_at_once_child', $cluster->cost_all_at_once_child, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-top:5px; margin-left:5px;">children</div> </li>
					    <li style="width:100%; float:left; padding-bottom:5px;">{{ Form::text('cost_all_at_once_members', $cluster->cost_all_at_once_members, ['style' => 'width:60px; float:left;']) }} <div style="font-size:12px; display:inline-block; margin-top:5px; margin-left:5px;">members</div> </li>
					   </ul> 
					</div>    
				</div>

				<div class="form-group nl2">
				    <label for="exampleInputEmail1"></label>
				     {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
				</div>            
		    </div>

			    {{ Form::hidden('id', $cluster->id) }}

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
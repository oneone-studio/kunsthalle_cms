@extends('layouts.default')

@section('content')

	<?php
		$event_ids = [];
		foreach($cluster->k_events as $e) {
			$event_ids[] = $e->id;
		}		
		$tag_ids = [];
		foreach($cluster->tags as $t) {
			$tag_ids[] = $t->id;
		}		
		// echo 'INFO: '; print_r($event_ids); exit;
		/**/
	?>
    <div class="page_content">
      <h3>Cluster</h3>
      <p>
		<div style="list-style:none;">
		{{ Form::open(array('route' => 'cluster.update', 'method' => 'post', 'class' => 'form-inline')) }}
		    
		    
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
				<div class="form-group" class="nl">
				    <label for="title">{{ Form::label('type', 'Type:') }}</label>
				    <select name="cluster_type">
				      <option value="event" <?php echo ($cluster->cluster_type == 'event') ? ' selected="selected"' : '';?> >Event </option>	
				      <option value="exhibition" <?php echo ($cluster->cluster_type == 'exhibition') ? ' selected="selected"' : '';?>>Exhibition </option>	
				    </select>
				</div>

				<div class="form-group nl" style="padding-top:10px;">
				    <label for="kevents">{{ Form::label('tags', 'Tags/Filter:') }}</label>
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
				    <label for="kevents">{{ Form::label('kevents', 'Event:') }}</label>
				    <select name="kevents[]" data-placeholder="Choose an Event..." class="chosen-select" multiple="multiple" style="width:100%;" tabindex="4">
				        <option value=""></option>
	        	<?php foreach($k_events as $ke): 
	        			 $selected = '';
	        			 if(in_array($ke->id, $event_ids)) {
	        			 	$selected = ' selected="selected"';
	        			 }
	        	?>
				        <option value="<?php echo $ke->id;?>" <?php echo $selected;?>><?php echo $ke->id . ' - '.$ke->title_de .' ['.$ke->subtitle_de.']'; ?> </option>
	        	<?php endforeach; ?>
				    </select>
				</div>

				<div class="form-group nl"><h3>Costs</h3>
				</div>	
				<?php 
					if($cluster->k_event_cost) {
						$kc = $cluster->k_event_cost;
					}
				?>

			<div class="form-group nl">
			    <?php echo Form::label('package', 'Package'); ?>
				<?php echo Form::checkbox('package', null, ($cluster->package == 1) ? true:false, []); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('regular_adult_price', 'Erwachsene'); ?></label>
			    <?php echo Form::text('regular_adult_price', $kc->regular_adult_price, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('regular_child_price', 'Kinder'); ?></label>
			    <?php echo Form::text('regular_child_price', $kc->regular_child_price, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('member_adult_price', 'Mitglieder'); ?></label>
			    <?php echo Form::text('member_adult_price', $kc->member_adult_price, ['style' => 'width:70px']); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('member_child_price', 'Kinder/Mitglied'); ?></label>
			    <?php echo Form::text('member_child_price', $kc->member_child_price, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('sibling_child_price', 'Geschwisterkinder'); ?></label>
			    <?php echo Form::text('sibling_child_price', $kc->sibling_child_price, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <?php echo Form::label('sibling_member_price', 'Geschwisterkinder / Mitglied'); ?>
			    <?php echo Form::text('sibling_member_price', $kc->sibling_member_price, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('reduced_price', 'ermäßigt'); ?></label>
			    <?php echo Form::text('reduced_price', $kc->reduced_price, ['style' => 'width:70px']); ?>

			</div>

<!-- 				<div class="form-group nl">
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
				-->

				<div class="form-group nl2">
				    <label for="exampleInputEmail1"></label>
				     {{ Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
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
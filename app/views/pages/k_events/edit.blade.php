<?php $__env->startSection('content'); ?>

	<?php 
      // echo $k_event->detail_de; exit;

		$exb_ids = [];
		foreach($k_event->exhibitions as $ke) {
			$exb_ids[] = $ke->id;
		}		
		$cluster_ids = [];
		foreach($k_event->clusters as $cl) {
			$cluster_ids[] = $cl->id;
		}		

		if($k_event->k_event_cost) {
			$kc = $k_event->k_event_cost;
		}
		$tag_ids = [];
		foreach($k_event->tags as $t) {
			$tag_ids[] = $t->id;
		}		

		$event_day = '';
		if(isset($k_event->event_day) && strlen($k_event->event_day) > 0) {
			$event_day = $k_event->event_day;
		}
	?>
    <div class="page_content">
      <div style="width:100%; height:35px; clear:both;">
        <div style="width:69%; float:left;">&nbsp;</div>
      	<select name="event_sel" id="event_sel" class="chosen-select" style="float:right;" onchange="showEvent(this)">
      		<option value="0">-- Event -- </option>
      		<?php foreach($events as $e) { ?>
      				 <option value="<?php echo $e->id;?>"><?php echo $e->title_de;?> </option>
      	    <?php } ?>
      	</select>
      </div>
      <h3>Event <a href="/content/events" style="color:blue;font-size:12px;font-weight:normal;margin-left:15px;">back</a></h3>
      <p>

		<?php echo Form::model($k_event, array('action' => array('KEventsController@update', $k_event->id), 'class' => 'form-inline', 'onsubmit' => "sanitizeInputs()")); ?>
			<!-- <div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('title_de', 'Date/ Time'); ?></label>
			    <div id="date1" style="width:200px;"><?php echo Form::text('title_en', null, ['id' => 'datetimepicker1', 'style' => 'width:300px;']); ?> <span style="color:#9e9e9e; display:none; vertical-align:bottom;">en</span></div>
			    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>
			</div> -->
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('title_de', 'Title'); ?></label>
			    <?php echo Form::text('title_de', null, ['style' => 'width:300px;', 'placeholder' => 'Title DE']); ?>

			    <?php echo Form::text('title_en', null, ['id' => 'title_en', 'style' => 'width:300px;', 'placeholder' => 'Title EN']); ?> <span style="color:#9e9e9e; display:none; vertical-align:bottom;">en</span>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('subtitle_de', 'Subtitle'); ?></label>
			    <?php echo Form::text('subtitle_de', null, ['style' => 'width:300px;', 'placeholder' => 'Title DE']); ?>

			    <?php echo Form::text('subtitle_en', null, ['id' => 'subtitle_en', 'style' => 'width:300px;', 'placeholder' => 'Subtitle EN']); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('detail_de', 'Detail'); ?></label>
			    <div id="editor_1" style="width:300px; min-height:160px; display:inline-block; vertical-align:top;"><?php echo Form::textarea('detail_de',  $k_event->detail, array( 'id' => 'detail_de', 'rows' => 2, 'style' => 'width:300px; margin-bottom:10px;', 'class' => 'tm_editor', 'placeholder' => 'Text DE') ); ?></div>
			    <div id="editor_2" style="width:300px; min-height:160px;display:inline-block; vertical-align:top;"><?php echo Form::textarea('detail_en',  $k_event->detail, array( 'id' => 'detail_en', 'rows' => 2, 'style' => 'width:300px; margin-bottom:10px;', 'class' => 'tm_editor', 'placeholder' => 'Text EN')); ?></div>
			</div>

			<div class="form-group nl" style="padding-top:10px;">
			    <label for="kevents"><?php echo Form::label('tags', 'Tags/Filter:'); ?></label>
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
			    <label for="k_event_image" style="float:left;"><?php echo Form::label('k_event_image', 'Image'); ?></label>
				<!-- <input type="button" class="btn btn-primary" value="Upload Image" onclick="toggleEventImageInput()"> -->
			    <div id="image_pane" style="width:50%; margin-left:3px;margin-bottom:4px;float:left; display:inline;">
				    <?php echo Form::file('k_event_image', ['id' => 'k_event_image']); ?>				    
				    <input type="button" id="upload_btn" value="Upload" class="btn btn-default" onclick="uploadKEventImage()">

			    </div>
			</div>
			<div class="form-group nl" style="padding:10px 0px;">
			    <label for="exampleInputEmail1" style="float:left;">Preview</label>
			    <div id="image_pane" style="width:10%; float:left; display:inline;">
			      <?php $display = 'display:none;';
			      if(!empty($k_event->event_image)) { 
			      	$display = 'display:inline;';
			      	$background = ' background:url(/'.$k_event->event_image.') no-repeat;'; 
			      }			      
			      ?>
			      <div style="width:70px !important; height:100px;  display:block; margin-left:0px; 
			      background-size:70px 100px; border:1px dashed #e3e3e3;"><img id="preview" src="/<?php echo $k_event->event_image;?>" style="max-width:70px; max-height:100px; float:left; <?php echo $display;?>"></div>
			    </div>
			      <div style="width:20px; display:inline; margin-left:10px;"><a class="glyphicon glyphicon-trash" 
			      style="cursor:pointer; margin-top:80px;" onclick="deleteEventImage(<?php echo $k_event->id;?>)"></a></div>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('caption_de', 'Caption'); ?></label>
			    <?php echo Form::text('caption_de', null, ['style' => 'width:300px;', 'placeholder' => 'Caption DE']); ?>
			    <?php echo Form::text('caption_en', null, ['id' => 'caption_en', 'style' => 'width:300px;', 'placeholder' => 'Caption EN']); ?>
			</div>

			<div class="form-group nl">
			    <label for="exampleInputEmail1" style="float:left;"><?php echo Form::label('start_date', 'Event / Start Date'); ?></label>
				<div style="width:400px; display:inline-block; margin-left:4px; margin-bottom:10px;">    
			    	<?php echo Form::text('start_date', null, ['style' => 'width:100px;']); ?>
			    </div>
			</div>	

			<div class="form-group nl" style="position:relative;">
			    <label for="exampleInputEmail1" style="float:left;"><?php echo Form::label('start_time', 'Time'); ?></label>
			    <div style="width:30%; display:inline-block;; margin-left:3px;">
				    <div style="width:66px; float:left;"><?php echo Form::text('start_time', null, ['style' => 'width:50px;']); ?></div>
				    <div style="width:26px; height:20px; margin-top:4px; float:left; text-align:center;">-</div>
				    <div style="width:100px; float:left;"><?php echo Form::text('end_time', null, ['id' => 'end_time', 'style' => 'width:50px;']); ?></div>
				</div>
			</div>

			<div class="form-group nl" style="border-top:1px solid #666;margin-top:4px;">
			    <lable style="float:left;width:177px;margin-top:10px;">Recurring Events <?php echo $k_event->event_day_repeat;?></lable>
				<div style="width:400px; display:inline-block; margin-left:4px;background:none; margin-bottom:0px;">    
			    	<div style="width:100%; float:left; margin-left:0px; margin-top:0px; margin-bottom:5px;">    
				    <div style="width:160px; height:auto; float:left;">
					    <ul style="width:160px; float:left; list-style:none; padding-top:0px; margin-left:3px;">
					       
					       <li style="height:40px;margin-bottom:4px; margin-top:4px; border-bottom:1px solid #666;"><?php echo Form::radio('event_day_repeat', 'daily', false, 
					       ['onclick' => 'toggleEventDay(true)', 'class' => 'event_repeat_opt edr_t1', 'style' => 'width:15px;  position:relative; left:0;']); ?> 
					       <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;"> Daily</div></li>

					       <li style="margin-left:0;position:relative; height:20px;"><?php echo Form::radio('event_day_repeat', 'every', false, 
					       ['onclick' => 'toggleEventDay(false);toggleEDR3(true)', 'class'=> 'event_repeat_opt edr_t2', 'style'=> 'width:15px; position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;">Every</div></li>
					       <li style="margin-left:0; position:relative; height:20px;"><?php echo Form::radio('event_day_repeat', 'every first', false, 
					       ['onclick' => 'toggleEventDay(false);toggleEDR3(false)', 'class' => 'event_repeat_opt edr_t2', 'style' => 'width:15px; position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;"> Every first</div></li>
					       <li style="height:20px;"><?php echo Form::radio('event_day_repeat', 'every second', false, 
					       ['onclick' => 'toggleEventDay(false);toggleEDR3(false)', 'class' => 'event_repeat_opt edr_t2', 'style' => 'width:15px;  position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;"> Every second</div></li>
					       <li style="height:20px;"><?php echo Form::radio('event_day_repeat', 'every third', false, 
					       ['onclick' => 'toggleEventDay(false);toggleEDR3(false)', 'class' => 'event_repeat_opt edr_t2', 'style' => 'width:15px;  position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;"> Every third</div></li>
					       <li style="height:20px;"><?php echo Form::radio('event_day_repeat', 'every last', false, 
					       ['onclick' => 'toggleEventDay(false);toggleEDR3(false)', 'class' => 'event_repeat_opt edr_t2', 'style' => 'width:15px;  position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;"> Every last</div></li>
					       <li style="height:20px;"><?php echo Form::radio('event_day_repeat', 'bi-weekly', false, 
					       ['onclick' => 'toggleEventDay(false);toggleEDR3(true)', 'class' => 'event_repeat_opt edr_t2', 'style' => 'width:15px;  position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;"> bi-weekly, on a</div></li>					       
					    </ul>

					    <div id="event_day_div" style="width:150px; height:22px; float:left; margin-top:8px;">
					      <!-- < ?php echo Form::text('event_day', null, ['id' => 'event_day', 'placeholder' => 'Day', 'style' => 'width:150px; height:25px; vertical-align:middle;']); ?> -->
					      <select name="event_day" id="event_day" data-placeholder="Choose a day" class="chosen-select">
					      	 <option value=""></option>
					      <?php foreach($weekdays as $wd) { 
					      		   $selected = '';
					      		   if($k_event->event_day == $wd) { $selected = ' selected="selected"'; }
					      	?>
					      	 	  <option value="<?php echo $wd;?>" <?php echo $selected;?>><?php echo $wd; ?></option>
					      <?php } ?>
					      </select>
					    </div>

					    <ul style="width:160px; float:left; list-style:none; padding-top:10px; margin-left:3px; padding-bottom:15px; border-bottom:1px solid #666;">
					       <li style="height:20px;"><?php echo Form::radio('repeat_month', 1, false, 
					       ['onclick' => '', 'id' => 'every_month_ch', 'class' => 'event_repeat_opt edr_t3', 'style' => 'width:15px;  position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;">Every Month</div></li>
					       <li style="height:20px;"><?php echo Form::radio('repeat_month', 3, false, 
					       ['onclick' => '', 'id' => 'every_third_month_ch', 'class' => 'event_repeat_opt edr_t3', 'style' => 'width:15px;  position:relative; left:0;']); ?> <div style="width:100%; display:inline; position:relative; top:2px; margin-left:4px;"> Every third month</div></li>
					    </ul>   
					</div>
				</div>
			</div>
			
			<div class="form-group nl" style="border-bottom:1px solid #666; padding-bottom:10px; margin-bottom:10px;">
			    <label for="exampleInputEmail1"><?php echo Form::label('end_date', 'End Date'); ?></label>
			    <?php echo Form::text('end_date', null, ['style' => 'width:100px;', 'onblur' => 'checkDates()']); ?>
			    <span id="end_date_err" style="margin-left:10px;font-size:12px; color:red;"></span>

			</div>
			<!---->
			<div class="form-group nl" style="padding-bottom:10px;">
			    <label for="exampleInputEmail1">&nbsp;</label>
			    <?php 
			          $options = ['id' => 'event_dates', 'placeholder' => 'Einzeldaten hier eintragen (TT/MM/JJJJ)', 'rows' => 2, 'style' => 'width:300px; margin-top:4px; margin-left:5px;'];
			    	  $disableEventDay = true;
			    	  if(count($k_event->event_dates) == 0) { // if(strlen($k_event->event_dates) == 0) {
			    	  	 $options['disabled'] = true;
			    	  	 $disableEventDay = false;
			    	  }
			    ?>
			    <div style="width:77%; display:block; float:right; background:none;">
			    <?php echo Form::checkbox('has_random_dates', null, ($k_event->has_random_dates == 0) ? false : true, ['style' => 'width:15px;vertical-align:top; margin-top:1px; margin-right:8px;margin-left:-4px;', 'onclick' => 'toggleEventRepeat(this)']); ?>

			    <?php echo Form::label('event_date', 'Single Dates', ['style' => 'margin-top:3px;margin-left:-4px;width:100px;']); ?> <?php echo Form::text('event_date', null, ['style' => 'width:100px;']); ?>

			    <input type="button" value="Save" class="btn" onclick="updateEventDates('<?php echo $k_event->id;?>')">
			    <br>
			    <?php //echo Form::textarea('_event_dates',  $k_event->_event_dates, $options); ?>
			   
			    </div>
			</div>
			<div id="event_dates_pane" class="form-group nl" style="width:77%; float:right; clear:both; padding:10px; border-radius:5px; 
				border:0px solid #9f9f9f; margin-bottom:5px;">
				<?php $indx = 0; 
				    foreach($k_event->event_dates as $ed) { ?>
						<div style="width:90px; margin-right:4px; background:none; float:left; font-size:12px;font-weight:bold;"><a href="javascript:deleteEventDate(<?php echo $ed->id;?>, <?php echo $k_event->id;?>)"
						 style="color:orangered; font-size:16px; padding-right:1px; font-weight:normal; cursor:pointer;">x </a> 
						 <?php echo date('d/m/Y', strtotime($ed->event_date)); ?> 
				  <?php if($indx < count($k_event->event_dates)-1) { echo ', '; } ?>		 
				  		</div>
			    <?php $indx++;
			    	} ?>
			</div> 

			<div class="form-group nl" style="padding-bottom:5px;">
			    <?php echo Form::checkbox('as_series', null, (count($k_event->as_series) == 0) ? false : true, ['style' => 'width:15px;vertical-align:top; margin-top:-4px; margin-right:4px;margin-left:0px;']); ?>
			    Blockveranstaltung
			</div>
			<div class="form-group nl" style="padding-bottom:5px;">
			    <?php echo Form::checkbox('show_after_startdate', null, (count($k_event->show_after_startdate) == 0) ? false : true, ['style' => 'width:15px;vertical-align:top; margin-top:-4px; margin-right:4px;margin-left:0px;']); ?>
			    Show after start date?
			</div>

			<div class="form-group nl">&nbsp;</div>
			<div class="form-group nl" style="margin:10px 0px;">
			    <?php echo Form::label('page_link', 'Link', ['style' => 'font-size:14px;font-weight:bold;']); ?>
				<div style="width:500px;display:inline-block;margin-left:0px;">				    
				    <select name="page_url_1" id="page_url_1" style="width:350px;" onchange="showPageLink(this)" class="chosen-select">
				    <option value="0">-- Select -- </option>
				    @if(isset($page_links))
		    	    	@if(count($page_links['normal_pages']) > 0)
			    	    	@foreach($page_links['normal_pages'] as $sec)
			    	    		<option disabled>{{$sec['title']}}</option>
			    	    		@foreach($sec['pages'] as $pg)
			    	    			<option value="{{$pg['link']}}" @if($pg['link'] == $k_event->page_link) selected="selected" @endif >{{$pg['title']}}</option>
			    	    		@endforeach
			    	    	@endforeach
			    	    @endif
				    @endif
				    </select><div style="font-size:12px;margin-left:10px;font-style:italic;display:inline;color:darkgreen;font-weight:normal;">Normal Page</div><div style="clear:both;height:4px;">&nbsp;</div>
				    <select name="page_url_2" id="page_url_2" style="width:350px;margin-top:3px;" onchange="showPageLink(this)" class="chosen-select">
				    <option value="0">-- Select -- </option>
				    @if(isset($page_links))
		    	    	@foreach($page_links['page_sections'] as $sec)
		    	    		<option value="{{$sec['link']}}" @if($k_event->page_link == $sec['link']) selected="selected" @endif >{{$sec['title']}} [section] </option>
		    	    		@foreach($sec['pages'] as $pg)
		    	    			<option value="{{$pg['link']}}" @if($pg['link'] == $k_event->page_link) selected="selected" @endif >{{$pg['title']}}
		    	    			</option>
		    	    		@endforeach
		    	    	@endforeach
				    @endif
				    </select><div style="font-size:12px;margin-left:10px;font-style:italic;display:inline;color:darkgreen;font-weight:normal;">Sections &amp; sub pages</div><div style="clear:both;height:4px;">&nbsp;</div>
				    <select name="page_url_3" id="page_url_3" style="width:350px;" onchange="showPageLink(this)" class="chosen-select">
				    <option value="0">-- Select -- </option>
				    @if(isset($page_links))
		    	    	@if(count($page_links['exb_pages']) > 0)
		    	    		@foreach($page_links['exb_pages'] as $pg)
		    	    			<option value="{{$pg['link']}}" @if($pg['link'] == $k_event->page_link) selected="selected" @endif >{{$pg['title']}}
		    	    			 </option>
		    	    		@endforeach
			    	    @endif
				    @endif
				    </select><div style="font-size:12px;margin-left:10px;font-style:italic;display:inline;color:darkgreen;font-weight:normal;">Exchibition Page</div><br>
				    <input type="hidden" name="page_url" id="page_url" value="{{$k_event->page_url}}">

				</div>
				<div style="clear:both;"></div>
			    <?php echo Form::label('selected_link', 'Selected link', ['style' => 'font-size:14px;font-weight:bold;float:left;']); ?>
				<div id="page_link" style="width:20px;display:inline-block;margin-top:4px;margin-left:3px;width:500px;">
				  <?php echo strlen($k_event->page_link) > 0 ? '<a href="'.$k_event->page_link.'" target="_blank">'.$k_event->page_link_title.'</a>'. 
				  '<a class="glyphicon glyphicon-trash" href="javascript:delPageLink('.$k_event->id.')" style="margin-left:10px;text-decoration:none;">&nbsp;</a>' : '--'; ?>
			    </div><div style="clear:both;"><!-- <div style="font-size:12px;color:#888;font-style:italic;margin-left:200px;">[np] -> Normal page, [sp] -> Sub Page, [ep] -> Exhibition page</div> --></div>
			    <input name="page_link_title" id="page_link_title" type="hidden" value="{{$k_event->page_link_title}}">
			</div>
			<div class="form-group nl" style="margin:10px 0px;">
			    <?php echo Form::label('page_link_text', 'Link text', ['style' => 'font-size:14px;font-weight:bold;']); ?>
			    <?php echo Form::text('page_link_text', null, ['style' => 'width:500px;']); ?>
			</div>

			<div class="form-group nl">&nbsp;</div>
			<div class="form-group nl" style="margin:10px 0px;">
			    <?php echo Form::label('guide_name', 'Guide', ['style' => 'font-size:14px;font-weight:bold;']); ?>
			    <?php echo Form::text('guide_name', null, ['style' => 'width:500px;font-weight:bold;']); ?>
			</div>
			<div class="form-group nl" style="padding-bottom:5px;">
			    <?php echo Form::label('place', 'Place'); ?>
			    <?php echo Form::text('place', html_entity_decode($k_event->place), ['style' => 'width:500px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('remarks', 'Remarks'); ?></label>
			    <?php echo Form::text('remarks', $k_event->remarks, ['style' => 'width:500px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('google_map_url', 'Map url'); ?></label>
			    <?php echo Form::text('google_map_url', $k_event->google_map_url, ['style' => 'width:500px']); ?>
			</div>

			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('registration', 'Registration'); ?></label>
			    <?php echo Form::checkbox('registration'); ?>
			    <?php echo Form::text('registration_detail', null, ['style' => 'width:484px;']); ?>			    
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('max_attendance', 'Max. Attendance'); ?></label>
			    <?php echo Form::text('max_attendance', null, ['style' => 'width:100px;']); ?>

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
<!-- 			<div class="form-group nl">
			    < ?php echo Form::label('persons', 'Personen'); ?>
			    < ?php echo Form::text('persons', $k_event->persons, ['style' => 'width:70px']); ?>
			</div> -->
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('reduced_price', 'ermäßigt'); ?></label>
			    <?php echo Form::text('reduced_price', $kc->reduced_price, ['style' => 'width:70px']); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('inclusive_material', 'Inclusive material'); ?></label>
			    <?php echo Form::checkbox('inclusive_material', null, $kc->inclusive_material); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('entry_fee', 'Eintrittspreis'); ?></label>
			    <div style="width:400px;display:inline-block;">
			    <?php echo Form::checkbox('free', null, (isset($k_event->entrance->free) && $k_event->entrance->free==1) ? true:false); ?><label style="position:relative;top:6px;left:5px;">Free </label><br>
			    <?php echo Form::checkbox('included', null, (isset($k_event->entrance->included) && $k_event->entrance->included==1) ? true:false); ?><label style="position:relative;top:6px;left:5px;">Included</label><br>
			    <?php echo Form::checkbox('excluded', null, (isset($k_event->entrance->excluded) && $k_event->entrance->excluded==1) ? true:false); ?><label style="position:relative;top:6px;left:5px;">Excluded</label><br>
			    <?php echo Form::checkbox('entry_fee', null, (isset($k_event->entrance->entry_fee) && $k_event->entrance->entry_fee==1) ? true:false); ?><label style="position:relative;top:6px;left:5px;">Costs = Entrance fee</label>
			    </div>
			</div>

			<div class="form-group nl2">
			    <label for="exampleInputEmail1"></label>
			     <?php echo Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')); ?>

			     <?php echo Form::button('Duplicate', ['class' => 'btn btn-primary', 'onclick' => 'duplicateKEvent()' ]); ?>

			</div>            
			    
			    <?php echo Form::hidden('id', $k_event->id, ['id' => 'id']); ?>


			<?php echo Form::close(); ?>  

			<?php if($errors->any()): ?>
			    <ul>
			        <?php echo implode('', $errors->all('<li class="error">:message</li>')); ?>

			    </ul>
			<?php endif; ?>

    </div>

<?php echo Form::open(array('route' => 'k_event_image.upload', 'files' => true), ['id' => 'upload_form']); ?>
	<?php echo Form::file('k_event_image', [ 'id' => 'k_event_image', 'style' => 'display:none;' ]); ?>
<?php echo Form::close(); ?>

<script>
<?php 
if($disableEventDay) { ?>
	$('#has_random_dates').click();
<?php 
} ?>

$(function() {
	var event_day_repeat = '<?php echo $k_event->event_day_repeat;?>';
	if(event_day_repeat.toLowerCase() == 'daily') {
		$('#event_day').prop('disabled', true).trigger("chosen:updated");
	}

	checkDates();
});

Date.prototype.compare = function(b) {
  if (b.constructor !== Date) {
    throw "invalid_date";
  }

 return (isFinite(this.valueOf()) && isFinite(b.valueOf()) ? 
          (this>b)-(this<b) : NaN 
        );
};

function showPageLink(sel) {
	if(sel.selectedIndex > 0) {
		for(i=1;i<=3;i++) {
			if(sel.id.indexOf('_'+i) == -1) {
				$('#page_url_'+i).val(0);
        		$('#page_url_'+i).trigger("chosen:updated");
			}
		}
		var page_link_title = $('#'+sel.id +' option:selected').text();
		document.getElementById('page_link_title').value = page_link_title;
		document.getElementById('page_url').value = $('#'+sel.id).val(); //sel[sel.selectedIndex].value;
		$('#page_link').html('<a href="'+sel.value+'" target="_blank">'+ page_link_title +'</a>');
	}
}

function delPageLink(id) {
	$.ajax({
	    type: 'GET',
	    url: '/del-page-link',
	    data: { 'id' : id },
	    dataType: 'json',
	    success:function(data) { 
	    		    console.log('delPageLink success..');
	    		    $('#page_url').prop('selectedIndex', 0);
	    		    $('#page_link').html('--');
	    		    $('#page_link_title').val('');
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed..');
	    	    }
	});
}

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
	if(s == e) {
		$('.edr_t1').prop('disabled', true);
		$('.edr_t2').prop('disabled', true);
		$('.edr_t3').prop('disabled', true);
		$('#event_day').prop('disabled', true).trigger("chosen:updated");
	} else {
		$('.edr_t1').prop('disabled', false);
		$('.edr_t2').prop('disabled', false);
		$('.edr_t3').prop('disabled', false);
		$('#event_day').prop('disabled', false).trigger("chosen:updated");
	}
}

function duplicateKEvent() {
	var id = $('#id').val();
	var formData = new FormData($('form')[0]); // working
	$.ajax({
	    type: 'POST',
	    url: '/kevents/duplicate',
	    data: { 'id' : id },
	    dataType: 'json',
	    success:function(data) { 
	    			console.log('Success.. -> id: ' + data.id + "\n\n");
	    			if(data.id != undefined && !isNaN(data.id)) {
	    				document.location.href = '/content/events/edit/' + data.id;
	    			}
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function updateEventDates(eid) {
	if(!isNaN(eid)) {
		var event_date = '';
		if($('#event_date').length) {
			event_date = $('#event_date').val();
		}
		if(event_date.length > 9) {
			$.ajax({
			    type: 'POST',
			    url: '/update-event-dates',
			    data: { 'id' : eid, 'event_date' : event_date },
			    dataType: 'json',
			    success:function(data) { 
			    			console.log('updateEventDates() .. success');
			    	console.log(data);
			    	var html = '';
			    	var ar = [];
			    	var edates = data.event.sortedEventDates;
			    	for(i=0; i<edates.length; i++) {
			    		html += '<div style="width:90px; margin-right:4px; background:none; float:left; font-size:12px;font-weight:bold;">'+
			    				'<a href="javascript:deleteEventDate('+edates[i].id + ', '+ data.event.id + ')" '+
			    				' style="color:orangered; font-size:16px; padding-right:1px; font-weight:normal; cursor:pointer;">x </a> ' +
			    				edates[i].event_date;
			    		if(i < edates.length-1) { html += ', '; }		
			    		html += '</div>';
			    	}			
			    	ar = data.event.start_date.split('-');
			    	var start = ar[2] + '/' + ar[1] + '/' + ar[0];
					$('#start_date').val(start);
			    	ar = data.event.end_date.split('-');
			    	var end = ar[2] + '/' + ar[1] + '/' + ar[0];
					$('#end_date').val(end);
			    	$('#event_date').val('');
			    	console.log(html);
			    	$('#event_dates_pane').html(html);
						},
			    error:  function(jqXHR, textStatus, errorThrown) {
			    		    console.log('updateEventDates() .. failed.. ');
			    	    }
			});
		}
	}
}

function deleteEventDate(eid, event_id) {
	if(!isNaN(eid)) {
		$.ajax({
		    type: 'GET',
		    url: '/delete-event-date/',
		    data: { 'id' : eid, 'event_id' : event_id },
		    dataType: 'json',
		    success:function(data) { 
		    			console.log('deleteEventDate() .. success');
		    	console.log(data);
		    	var html = '';
		    	var edates = data.event.sortedEventDates;
		    	for(i=0; i<edates.length; i++) {
		    		html += '<div style="width:90px; margin-right:4px; background:none; float:left; font-size:12px;font-weight:bold;">'+
		    				'<a href="javascript:deleteEventDate('+edates[i].id + ', '+ data.event.id + ')" '+
		    				' style="color:orangered; font-size:16px; padding-right:1px; font-weight:normal; cursor:pointer;">x </a> ' +
		    				edates[i].event_date;
		    		if(i < edates.length-1) { html += ', '; }		
		    		html += '</div>';
		    	}			
		    	$('#event_date').val('');
		    	console.log(html);
		    	$('#event_dates_pane').html(html);
					},
		    error:  function(jqXHR, textStatus, errorThrown) {
		    		    console.log('deleteEventDate() .. failed.. ');
		    	    }
		});
	}
}

<?php if(strlen($event_day) > 0) { ?>
	$(function() {
		$('#event_day').val('<?php echo $event_day;?>').trigger('chosen:updated');
	});
<?php } ?>
</script>
<link href="/js/datepick/jquery.datepick.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/datepick/jquery.plugin.js"></script>
<script src="/js/datepick/jquery.datepick.js"></script>
<script>
$j2 = jQuery.noConflict();
$j2(function() {
	$j2('#start_date').datepick( {dateFormat: 'dd/mm/yyyy'} );
	$j2('#end_date').datepick( {dateFormat: 'dd/mm/yyyy', onSelect: function() { checkDates(); } } );
	$j2('#event_date').datepick( {dateFormat: 'dd/mm/yyyy'} );
});

function showDate(date) {
	alert('The date chosen is ' + date);
}

function toggleEDR3(toggle) {
	$('.edr_t3').prop('disabled', toggle);
	if(toggle) {
		$('.edr_t3').prop('checked', false);
	}
}

</script>

<!-- Time picker  -->

<link rel="stylesheet" href="/js/jquery-timepicker/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="/js/jquery-timepicker/jquery.ui.timepicker.css?v=0.3.3" type="text/css" />

<script type="text/javascript" src="/js/jquery-timepicker/include/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/jquery-timepicker/include/ui-1.10.0/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="/js/jquery-timepicker/include/ui-1.10.0/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="/js/jquery-timepicker/include/ui-1.10.0/jquery.ui.tabs.min.js"></script>
<script type="text/javascript" src="/js/jquery-timepicker/include/ui-1.10.0/jquery.ui.position.min.js"></script>

<script type="text/javascript" src="/js/jquery-timepicker/jquery.ui.timepicker.js?v=0.3.3"></script>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript">
$j3 = jQuery.noConflict();

$j3(function() {

    $j3('#start_time').timepicker({
        showAnim: 'blind'
    });
    $j3('#end_time').timepicker({
        showAnim: 'blind'
    });

});

function addRandomDate(eid) {

}

function uploadKEventImage() {
	var imgfile = $('#k_event_image_').val();
	var form = $('#upload_form');
	var formData = new FormData($('form')[0]);  // working
	// var formData = new FormData($('form')[1]); //$('#upload_form'));

	$.ajax({
	    type: 'POST',
	    url: '/kevents/upload',
	    data: formData, //{ 'k_event_image' : imgfile, 'type' : 'file' },
	    dataType: 'json',
	    processData: false,
        contentType: false,
	    success:function(data) { 
	    			console.log('uploadKEventImage success..'+ "\n\n"); console.log(data);
	    			if(data.item != undefined) {
	    				$('#preview').attr('src', data.item).css('display', 'inline');
	    			}
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function deleteEventImage(id) {
	$.ajax({
	    type: 'GET',
	    url: '/kevents/delimage', ///content/events/delete-event-image',
	    data: { 'id' : id },
	    dataType: 'json',
	    // processData: false,
     	// contentType: false,
	    success:function(data) { 
	    			console.log('uploadKEventImage success..'+ "\n\n"); console.log(data);
    				$('#preview').attr('src', '').css('display', 'none');
				},
	    error:  function(jqXHR, textStatus, errorThrown) {
	    		    console.log('Failed.. ');
	    	    }
	});
}

function toggleEventImageInput() {
	if($('#image_pane').css('display') == 'none') {
		$('#image_pane').css('display', 'inline');
	} else {
		$('#image_pane').css('display', 'none');
	}
}

function sanitizeInputs() {
	var spchars = [ 'ß', 'Ä', 'ä', 'Ö', 'ö', 'Ü', 'ü' ];
	var reps  = [ '&szlig;', '&Auml;', '&auml;', '&Ouml;', '&ouml;', '&Uuml;', '&uuml;' ];
	// var street = $('#street').val();
	// for(i=0; i<spchars.length; i++) {
	// 	street = street = street.split(spchars[i]).join(reps[i]); //street.replace('ẞ', '&szlig;');
	// }
	// $('#street').val(street);
	// alert(street);
}
</script>

<!-- Time picker -->
<!-- Summernote WYSIWYG -->
<!-- include jquery -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
<!-- include libraries BS3 -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" />
<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<!-- include summernote -->
<?php echo HTML::style('js/summernote/dist/summernote.css');; ?>
<?php echo HTML::script('js/summernote/dist/summernote.js');; ?>
<!-- Summernote WYSIWYG END -->
<script>
$j9 = jQuery.noConflict();
// Summernote wysiwyg
/*
$j9(function() {
  $j9('.summernote').summernote({
  	width: 300,
    height: 100,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'picture','undo', 'redo', 'fullscreen']], //, 'clear']],
        // ['font', ['strikethrough', 'superscript', 'subscript']],
        // ['font', ['undo', 'redo', 'fullscreen']],//'fontsize', 
        // ['color', ['color']],
        // ['para', ['ul', 'ol', 'paragraph']],
        // ['height', ['height']]
    ]
  });
});
/**/

function showEditor(eid) {
	// $('#'+eid).css('width:100%; height:100%; position:absolute; left:0; top:0; z-index:9999;');
	// var html = $('#'+eid).html();
	// alert(html);
	// $('#editor_pane').load(html);//.dialog('open').load(html);
	// $('#editor_pane').show();
}

</script>
<!-- Summernote WYSIWYG END -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
 href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
  
<link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js"></script>

<script type="text/javascript">
$j8 = jQuery.noConflict();
$j8(function () {
   $j8('#date1').click(function() {
    $j8('#datetimepicker1').datetimepicker();//{
        //     inline: true,
        //     sideBySide: true
        // });
   });
});

function toggleEventDay(hide) {
   if(hide) {
   	 $('#event_day').prop('disabled', true).trigger("chosen:updated");
   	 // $('.edr_t2').prop('disabled', true);
   } else {
   	 $('#event_day').prop('disabled', false).trigger("chosen:updated");
   	 // $('.edr_t2').prop('disabled', false);
   }
}

function showEvent(sel) {
	if(sel.selectedIndex > 0) {
		document.location.href = '/content/events/edit/'+ sel.value;
	}
}
</script>
<style>
.datepick-nav { 
	width:190px;
}
.datepick-month-header select, .datepick-month-header input {
	width:60px;
}
.datepick-cmd-prev, .datepick-cmd-today, .datepick-cmd-next {
	width:60px;
	float:left;
}
div.datepick {
	width:225px;
}

#k_event_image {
	width:200px;
    color: transparent;
}
input[type="text"] {
	height:26px;
}
select {
	border-radius:3px;
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
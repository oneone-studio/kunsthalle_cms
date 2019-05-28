<?php $__env->startSection('content'); ?>

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
      <h3>Event</h3>
      <p>

		{{ Form::open(array('action' => 'KEventsController@store', 'method' => 'post', 'class' => 'form-inline')) }}
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
			    <div id="editor_1" style="width:300px; min-height:160px; display:inline-block; vertical-align:top;"><?php echo Form::textarea('detail_de',  null, array( 'id' => 'detail_de', 'rows' => 2, 'style' => 'width:300px; margin-bottom:10px;', 'class' => 'tm_editor', 'placeholder' => 'Text DE') ); ?></div>
			    <div id="editor_2" style="width:300px; min-height:160px;display:inline-block; vertical-align:top;"><?php echo Form::textarea('detail_en',  null, array( 'id' => 'detail_en', 'rows' => 2, 'style' => 'width:300px; margin-bottom:10px;', 'class' => 'tm_editor', 'placeholder' => 'Text EN')); ?></div>
			</div>


			<div class="form-group nl" style="padding-top:10px;">
			    <label for="kevents"><?php echo Form::label('tags', 'Tags/Filter:'); ?></label>
			    <select name="tags[]" data-placeholder="Choose a Tag..." class="chosen-select" multiple="multiple" style="width:300px;" tabindex="4">
			        <option value=""></option>
        	<?php foreach($tags as $tag): 
        	?>
			        <option value="<?php echo $tag->id;?>"><?php echo $tag->id . ' - '.$tag->tag_en; ?> </option>
        	<?php endforeach; ?>
			    </select>
			</div>

			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('guide_name', 'Guide'); ?></label>
			    <?php echo Form::text('guide_name'); ?>
			</div>
			<div class="form-group nl" style="padding-bottom:5px;">
			    <?php echo Form::label('place', 'Place'); ?>
			    <?php echo Form::text('place', null, ['style' => 'width:500px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('remarks', 'Remarks'); ?></label>
			    <?php echo Form::text('remarks', null, ['style' => 'width:500px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('google_map_url', 'Map url'); ?></label>
			    <?php echo Form::text('google_map_url', null, ['style' => 'width:500px']); ?>
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
			    <?php echo Form::text('regular_adult_price', null, ['style' => 'width:70px']); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('regular_child_price', 'Kinder'); ?></label>
			    <?php echo Form::text('regular_child_price', null, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('member_adult_price', 'Mitglieder'); ?></label>
			    <?php echo Form::text('member_adult_price', null, ['style' => 'width:70px']); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('member_child_price', 'Kinder/Mitglied'); ?></label>
			    <?php echo Form::text('member_child_price', null, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('sibling_child_price', 'Geschwisterkinder'); ?></label>
			    <?php echo Form::text('sibling_child_price', null, ['style' => 'width:70px']); ?>
			</div>
			<div class="form-group nl">
			    <?php echo Form::label('sibling_member_price', 'Geschwisterkinder / Mitglied'); ?>
			    <?php echo Form::text('sibling_member_price', null, ['style' => 'width:70px']); ?>
			</div>
<!-- 			<div class="form-group nl">
			    < ?php echo Form::label('persons', 'Personen'); ?>
			    < ?php echo Form::text('persons', null, ['style' => 'width:70px']); ?>
			</div> -->
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('reduced_price', 'ermäßigt'); ?></label>
			    <?php echo Form::text('reduced_price', null, ['style' => 'width:70px']); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('inclusive_material', 'Inclusive material'); ?></label>
			    <?php echo Form::checkbox('inclusive_material', null, false ); ?>

			</div>
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('entry_fee', 'Eintrittspreis'); ?></label>
			    <div style="width:400px;display:inline-block;">
			    <?php echo Form::checkbox('free', null, false); ?><label style="position:relative;top:6px;left:5px;">Free </label><br>
			    <?php echo Form::checkbox('included', null, false); ?><label style="position:relative;top:6px;left:5px;">Included</label><br>
			    <?php echo Form::checkbox('excluded', null, false); ?><label style="position:relative;top:6px;left:5px;">Excluded</label><br>
			    <?php echo Form::checkbox('entry_fee', null, false); ?><label style="position:relative;top:6px;left:5px;">Costs = Entrance fee</label>
			    </div>

			</div>

			<div class="form-group nl2">
			    <label for="exampleInputEmail1"></label>
			     <?php echo Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')); ?>
			</div>            
			    
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
function duplicateKEvent() {
	var id = $('#id').val();
	var formData = new FormData($('form')[0]);  // working

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


</script>

<link href="/js/datepick/jquery.datepick.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/datepick/jquery.plugin.js"></script>
<script src="/js/datepick/jquery.datepick.js"></script>
<script>
$j2 = jQuery.noConflict();
$j2(function() {
	$j2('#start_date').datepick( {dateFormat: 'dd/mm/yyyy'} );
	$j2('#end_date').datepick( {dateFormat: 'dd/mm/yyyy'} );
	$j2('#event_date').datepick( {dateFormat: 'dd/mm/yyyy'} );
});

function showDate(date) {
	alert('The date chosen is ' + date);
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
     //    contentType: false,
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

function addSingleDate() {
	var singleDates = $('#single_dates').val();
	var evtDate = $('#event_date').val();
	if(singleDates.indexOf(evtDate) == -1) {
		if(singleDates.length > 1) { singleDates += ','; }
		singleDates += evtDate;
	}
	$('#event_date').val('');
	$('#single_dates').val(singleDates);
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
  
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
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
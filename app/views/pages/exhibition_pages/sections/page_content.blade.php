{{ Form::open(array('route' => 'exb_page_contents.save', 'method' => 'post')) }}

	<div id="page_content_block" class="form-group edit-section" style="position:relative; top:20px; display:none;">
		<div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
		<div class="edit-blk-top">
		    <label for="exampleInputEmail1" class="edit-hdr eh90">Content (de)</label>
		    <div class="edit-icon-div"> <img src="/images/text_image.png" class="edit-icon edit-content-icon"></div>
		</div>    
	    {{ Form::textarea('content_de', null, ['id' => 'content_de', 'style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'de']) }}<br>
	    <label for="exampleInputEmail1">{{ Form::label('content_en', 'Content (en)') }}</label>			    
	    {{ Form::textarea('content_en', null, ['id' => 'content_en', 'style' => 'width:500px; height:100px;', 'class' => 'tm_editor', 'placeholder' => 'en']) }}
	    <br>
	    <select name="sort_order" id="sort_order" style="margin-bottom:15px; width:60px;">
	     @for($i=1; $i<=$sort_limit; $i++)
	     	<option value="{{$i}}" @if($i==$sort_limit) selected="selected" @endif >{{$i}} </option>
	     @endfor				    	
	    </select>
	    <div style="clear:both;height:15px;"></div>
	    <div style="float:left;margin-top:10px;margin-left:0px;margin-right:8px;">Anchor:</div>
	    <?php echo Form::text('anchor_title_de', null, ['id' => 'anchor_title_de', 'style' => 'width:300px;float:left;', 'placeholder' => 'Anchor DE']); ?>
	    <?php echo Form::text('anchor_title_en', null, ['id' => 'anchor_title_en', 'style' => 'width:300px;float:left;position:relative;left:15px;', 'placeholder' => 'Anchor EN']); ?>
	    <div style="clear:both;height:15px;"></div>
	    {{ Form::submit('Save Content', array('id' => 'save_content_btn', 'class' => 'button-success button-small pure-button', 'style' => 'height:30px; padding:3px 15px 5px 15px')) }}
	    {{ Form::button('Cancel', array('id' => 'cancel_content_btn', 'onclick' => 'hideContentInput()', 'class' => 'button-error button-small pure-button', 'style' => 'height:30px; margin-top:1px; padding:3px 15px 5px 15px')) }}

	    <button id="page_content_msg" class="pure-button" style="display:none; float:right;"></button>
	</div>
	<div style="clear:both;height:20px;"></div>

    {{ Form::hidden('id', $page->id) }}
    {{ Form::hidden('pc_id', 0, ['id' => 'pc_id']) }}

{{ Form::close() }}

	<div id="h2text_block" class="form-group edit-section" style="margin-top:20px;display:none;">
	  <div class="close-link-div"><a href="javascript:resetEdit()" class="close-link"> X </a></div>
	  <form id="h2text_form" method="POST" action="/exb-pages/h2text/save" accept-charset="UTF-8"><input name="_token" type="hidden">
		<div class="edit-blk-top">
		    <label for="h2" class="edit-hdr eh60">Headline</label>
		    <div style="display:inline-block;margin-left:4px;margin-top:5px;">
		    	<img src="/images/h2.png" class="edit-icon edit-h2intro-icon" />
				<span style="float:left;font-size:11px;"> + Intro</span>
			</div>
		</div>
	    <div style="clear:both;height:10px;"></div>
	    <div style="float:left;margin-top:6px;margin-right:8px;">H2 [de]:</div>
	    <input placeholder="Headline DE" style="width:300px;float:left;" name="h2_de" type="text" id="h2text_h2de">
	    <div style="float:left;margin-top:6px;margin-left:20px;margin-right:8px;">H2 [en]:</div>
	    <input placeholder="Headline EN" style="width:300px;float:left;" name="h2_en" type="text" id="h2text_h2en">
	    <div style="clear:both;"></div>
	    <div style="float:left;margin-top:6px;margin-right:8px;">Intro [de]:</div><div style="clear:both;"></div>
	    <?php echo Form::textarea('intro_de', null, ['id' => 'intro_de', 'style' => 'width:300px;', 'class' => 'tm_editor_h2intro', 'placeholder' => 'Intro DE']); ?>
	    <div style="float:left;margin-top:6px;margin-right:8px;">Intro [en]:</div><div style="clear:both;"></div>
	    <?php echo Form::textarea('intro_en', null, ['id' => 'intro_en', 'style' => 'width:300px;', 'class' => 'tm_editor_h2intro', 'placeholder' => 'Intro DE']); ?>
	    <div style="clear:both;height:15px;"></div>
	    <div style="float:left;margin-top:10px;margin-left:0px;margin-right:8px;">Anchor:</div>
	    <?php echo Form::text('anchor_title_de', null, ['id' => 'anchor_title_de', 'style' => 'width:300px;float:left;', 'placeholder' => 'Anchor DE']); ?>
	    <?php echo Form::text('anchor_title_en', null, ['id' => 'anchor_title_en', 'style' => 'width:300px;float:left;position:relative;left:15px;', 'placeholder' => 'Anchor EN']); ?>
		<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
	        <input class="btn btn-primary" style="position:relative;top:10px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save">
	    </div>
	    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
	    {{ Form::hidden('h2text_id', 0, ['id' => 'h2text_id']) }}
	  </form>  
	</div>

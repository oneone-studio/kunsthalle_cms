				<div id="h2text_block" class="form-group" style="margin-top:20px;display:none;">
				  <form method="POST" action="/exb-pages/h2text/save" accept-charset="UTF-8"><input name="_token" type="hidden">
				    <label for="h2" style="float:left;">Headline</label>
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
					<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
			            <input class="btn btn-primary" style="position:relative;top:10px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save">
			        </div>
				    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
				    {{ Form::hidden('h2text_id', 0, ['id' => 'h2text_id']) }}
				  </form>  
				</div>

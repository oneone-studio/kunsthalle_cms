				<div id="h2_block" class="form-group edit-section" style="margin-top:20px;display:none;">
				  <form method="POST" action="/exb-pages/h2/save" accept-charset="UTF-8"><input name="_token" type="hidden" value="pd4F2f9FOrU92JOgFLo3ynI1l90kVrHH3unm10LO">
				    <label for="h2" style="float:left;">Small headline</label>
				    <div style="clear:both;"></div>
				    <div style="float:left;margin-top:6px;margin-right:8px;">H2 [de]:</div>
				    <input placeholder="Headline (H2)" style="width:300px;float:left;" name="h2_de" type="text" id="h2_de">
				    <div style="float:left;margin-top:6px;margin-left:20px;margin-right:8px;">H2 [en]:</div>
				    <input placeholder="Headline EN" style="width:300px;float:left;" name="h2_en" type="text" id="h2_en">
					<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
			            <input class="btn btn-primary" style="position:relative;top:10px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save">
			        </div>
				    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
				    {{ Form::hidden('h2_id', 0, ['id' => 'h2_id']) }}
				  </form>  
				</div>

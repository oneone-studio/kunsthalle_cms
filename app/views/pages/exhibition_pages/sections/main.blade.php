			{{ Form::model($page, array('route' => array('exb-pages.save', $page->id))) }}		  

				<div class="form-group">
				    <label for="title">{{ Form::label('title', 'Title:') }}</label>
				    {{ Form::text('title_de', $page->title_de, ['placeholder' => 'Title [de]', 'style' => 'width:300px;']) }}
				    {{ Form::text('title_en', $page->title_en, ['placeholder' => 'Title [en]', 'style' => 'width:300px;']) }}
				</div>    
				<div class="form-group">
				    <label for="exampleInputEmail1" style="float:left;"><?php echo Form::label('start_date', 'Start Date'); ?></label>
					<div style="width:400px; display:inline-block; margin-left:4px; margin-bottom:10px;">    
				    	<?php echo Form::text('start_date', null, ['style' => 'width:100px;']); ?>
				    </div>
				</div>	
				<div class="form-group">
				    <label for="exampleInputEmail1" style="float:left;"><?php echo Form::label('end_date', 'End Date'); ?></label>
					<div style="width:400px; display:inline-block; margin-left:4px; margin-bottom:10px;">    
				    	<?php echo Form::text('end_date', null, ['style' => 'width:100px;']); ?>
				    	<span id="end_date_err" style="margin-left:10px;font-size:12px; color:red;"></span>
				    </div>
				</div>	

				<div class="form-group"> 
				    {{ Form::label('calendar', 'Calendar') }}
				    <select name="cluster_id" id="cluster_id" class="chosen-select" style="width:650px;">
				      @if($cluster_match == false) <option value="0">None </option> @endif
				      @foreach($clusters as $cl) 
				      	 <?php $selected = ''; 
				      	 	if(isset($page->cluster) && ($cl->id == $page->cluster_id)) { $selected = ' selected="selected"'; }
				      	 ?>
				      	 <option value="{{$cl->id}}" <?php echo $selected;?> >{{$cl->title_de}} </option>
				      @endforeach
				      @if($cluster_match == true) <option value="0">None </option> @endif
				    </select>
				</div>		
				<div class="form-group"> 
				    {{ Form::label('contacts', 'Contacts') }}
				    <select name="contacts[]" id="contacts" class="chosen-select" multiple style="width:650px;">
				      @foreach($rel_contacts as $c) 
				      	 <option value="{{$c->id}}" selected="selected">{{$c->first_name .' '. $c->last_name}}</option>
				      @endforeach
				      @foreach($contacts as $c) 
				      	 <option value="{{$c->id}}" >{{$c->first_name .' '. $c->last_name}}</option>
				      @endforeach
				    </select>
				</div>		
				<div class="form-group nl" style="padding-top:10px;">
					<label for="kevents" style="float:left;">Active:
					<div style="position:relative;left:20px;top:-2px;display:inline-block"><input type="checkbox" name="active" id="active" @if($page->active == 1) checked="checked" @endif ></label></div>
				</div>

				<div class="form-group">
				    <label for="exampleInputEmail1"></label>
				     {{ Form::submit('Save Page', array('id' => 'save_page_btn', 'class' => 'pure-button button-small')) }}					     
				     <a href="javascript:deletePage({{$page->id}})" class='button-error pure-button button-small' style="color:#fff; text-decoration:none;margin-top:2px;">Delete Page</a>
				</div>            
			    {{ Form::hidden('id', $page->id) }}

			{{ Form::close() }}		
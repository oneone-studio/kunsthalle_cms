@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Footer Page</h3>
      <p>
		{{ Form::model($page, array('route' => 'ftr-pages.update', 'method' => 'post')) }}
		    
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('title_de', 'Title'); ?></label>
			    <?php echo Form::text('title_de', null, ['style' => 'width:300px;', 'placeholder' => 'Title DE']); ?>
			    <?php echo Form::text('title_en', null, ['id' => 'title_en', 'style' => 'width:300px;', 'placeholder' => 'Title EN']); ?> <span style="color:#9e9e9e; display:none; vertical-align:bottom;">en</span>
			</div>
			<div class="form-group nl">
			    <?php echo Form::label('slug', 'Slug [de]'); ?>
			    <?php echo Form::text('slug_de', null, ['style' => 'width:300px;', 'placeholder' => 'Slug [de]', 'onkeyup' => 'convToSlug(this)']); ?>
			    <?php echo Form::text('slug_en', null, ['style' => 'width:300px;', 'placeholder' => 'Slug [en]', 'onkeyup' => 'convToSlug(this)']); ?>
			</div>    
			<div class="form-group">
			    <label for="title">SEO Page Title [de]:</label>
			    {{ Form::text('seo_page_title_de', $page->seo_page_title_de, ['placeholder' => 'SEO Page Title [de]', 'style' => 'width:500px;']) }}
		        <div class="inp-de" style="top:2px;">DE</div><br/>
				<div style="clear:both;"></div>
			    {{ Form::text('seo_page_title_en', $page->seo_page_title_en, ['placeholder' => 'SEO Page Title [en]', 'style' => 'width:500px;']) }}
		        <div class="inp-en" style="top:2px;">EN</div><br/>
			</div>    
			<div class="form-group">
			    <label for="title">SEO Page Description [de]:</label>
			    {{ Form::text('seo_page_desc_de', $page->seo_page_desc_de, ['placeholder' => 'SEO Page Description [de]', 'style' => 'width:500px;']) }}
		        <div class="inp-de" style="top:2px;">DE</div><br/>
				<div style="clear:both;"></div>
			    {{ Form::text('seo_page_desc_en', $page->seo_page_desc_en, ['placeholder' => 'SEO Page Description [en]', 'style' => 'width:500px;']) }}
		        <div class="inp-en" style="top:2px;">EN</div><br/>
			</div>
			<div class="form-group nl">
			    <div style="float:left;margin-top:6px;margin-right:8px;">Detail [de]:</div><div style="clear:both;"></div>
			    <?php echo Form::textarea('content_de', $page->page_contents[0]->content_de, ['id' => 'content_de', 'style' => 'width:300px;height:100px;', 'class' => 'tm_editor_h2intro', 'placeholder' => '']); ?>
			    <div style="float:left;margin-top:6px;margin-right:8px;">Detail [en]:</div><div style="clear:both;"></div>
			    <?php echo Form::textarea('content_en', $page->page_contents[0]->content_en, ['id' => 'content_en', 'style' => 'width:300px;height:100px;', 'class' => 'tm_editor_h2intro', 'placeholder' => '']); ?>
			</div>
			<div class="form-group nl">
			    <div style="float:left;margin-top:6px;margin-right:8px;">Sort:</div><div style="clear:both;"></div>
			    <select name="sort_order" style="width:70px;">
				    @for($c=1; $c<=$page_count; $c++) 
				        <option value="{{$c}}" @if($page->sort_order == $c) selected="selected" @endif >{{$c}} </option>
				    @endfor   
			    </select>
			</div>
			<div class="form-group nl" style="padding-top:10px;">
				<label for="kevents" style="float:left;">Active [DE]:</label>
				<div style="position:relative;left:20px;top:-2px;display:inline-block"><input type="checkbox" name="active_de" id="active_de" 
					@if($page->active_de == 1) checked="checked" @endif ></label></div>
				<div style="clear:both;"></div>
				<label for="kevents" style="float:left;">Active [EN]:</label>
				<div style="position:relative;left:20px;top:-2px;display:inline-block"><input type="checkbox" name="active_en" id="active_en" 
					@if($page->active_en == 1) checked="checked" @endif ></label></div>
			</div>

			<div class="form-group">
			    <label for="exampleInputEmail1"></label>
			     <?php echo Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')); ?>
			</div>            

			<input type="hidden" name="id" value="{{$page->id}}">

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
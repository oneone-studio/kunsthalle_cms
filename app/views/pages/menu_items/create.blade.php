@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Menu Item</h3>
      <p>
		{{ Form::open(array('route' => 'menu_items.store', 'method' => 'post')) }}
		    
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('title_de', 'Title'); ?></label>
			    <?php echo Form::text('title_de', null, ['style' => 'width:300px;', 'placeholder' => 'Title DE']); ?>
			    <?php echo Form::text('title_en', null, ['id' => 'title_en', 'style' => 'width:300px;', 'placeholder' => 'Title EN']); ?> <span style="color:#9e9e9e; display:none; vertical-align:bottom;">en</span>
			</div>
			<div class="form-group nl">
			    <?php echo Form::label('slug', 'Slug'); ?>
			    <?php echo Form::text('slug_de', null, ['style' => 'width:300px;', 'placeholder' => 'Slug DE', 'onclick' => 'setSlug(this)', 
			            'onkeyup' => 'setSlug(this)']); ?>
			    <?php echo Form::text('slug_en', null, ['style' => 'width:300px;', 'placeholder' => 'Slug EN', 'onclick' => 'setSlug(this)', 
			            'onkeyup' => 'setSlug(this)']); ?>
			</div>    

			<div class="form-group">
			    <label for="exampleInputEmail1"></label>
			     <?php echo Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')); ?>
			     {{ Form::button('Cancel', array('id' => 'cancel_content_btn', 'onclick' => 'javascript:document.location.href="/content/main-menu";', 'class' => 'button-error pure-button button-small', 'style' => 'height:30px; margin-top:1px; padding:3px 15px 5px 15px')) }}
			</div>            

			{{ Form::close() }}  

			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
      </p> 
    </div>

@stop
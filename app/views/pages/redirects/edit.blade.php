@extends('layouts.default')


@section('content')

    <div class="page_content">
      <h3>Redirect</h3>
      <p>
		{{ Form::model($redirect, array('route' => 'redirects.save', 'method' => 'post')) }}
		    
			<div class="form-group nl">
			    <label for="exampleInputEmail1"><?php echo Form::label('slug', 'Slug'); ?></label>
			    <?php echo Form::text('slug', null, ['style' => 'width:300px;', 'placeholder' => 'dash-separated-slug']); ?>
			    <br><span style="font-size:11px;color:#666;font-style:normal;font-weight:normal;">
			    	besuch-planen [OK] <span style="position:relative;left:10px;">/besuch-planen/shop-und-restaurant [X]</span>
			    </span>
			</div>
			<div class="form-group nl" style="position:relative;top:10px;">
			    <label for="exampleInputEmail1" style="float:left;width:90px;"><?php echo Form::label('redirect_url', 'Redirect URL'); ?></label><div style="font-size:12px;color:#666;font-style:normal;margin-top:2px;">(Enter full URL)</div><div style="clear:both;"></div>
			    <?php echo Form::text('redirect_url', null, ['style' => 'width:700px;', 'placeholder' => 'Complete URL']); ?>
			</div>

			<div class="form-group">
			    <label for="exampleInputEmail1"></label>
			     <?php echo Form::submit('Save', array('class' => 'btn btn-primary', 'style' => 'height:30px; padding:3px 15px 5px 15px')); ?>
			</div>            

			<input type="hidden" name="id" value="{{$redirect->id}}">

		{{ Form::close() }}  

		@if ($errors->any())
		    <ul>{{ implode('', $errors->all('<li class="error">:message</li>')) }}</ul>
		@endif
      </p> 
    </div>

@stop
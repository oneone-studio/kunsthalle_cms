{{ Form::model($page, array('id' => 'image_form', 'route' => array('exb-images.save'), 'files' => true)) }}

	@include('pages.partials._image_form')

    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
    {{ Form::hidden('image_id', 0, ['id' => 'image_id']) }}

{{ Form::close() }}		

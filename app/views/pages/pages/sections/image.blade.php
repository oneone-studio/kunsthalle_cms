{{ Form::model($page, array('id' => 'image_form', 'route' => array('images.save'), 'files' => true)) }}

	@include('pages.partials._image_form')

    {{ Form::hidden('id', $page->id, ['id' => 'id']) }}
    {{ Form::hidden('menu_item_id', $menu_item_id, ['id' => 'menu_item_id']) }}
    {{ Form::hidden('cs_id', $cs_id, ['id' => 'cs_id']) }}
    {{ Form::hidden('image_id', 0, ['id' => 'image_id']) }}

{{ Form::close() }}		

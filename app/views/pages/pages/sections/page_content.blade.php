{{ Form::open(array('route' => 'page_contents.save', 'method' => 'post')) }}

	@include('pages.partials._page_content_form')

    {{ Form::hidden('id', $page->id) }}
    {{ Form::hidden('cs_id', $cs_id) }}
    {{ Form::hidden('pc_id', 0, ['id' => 'pc_id']) }}
    {{ Form::hidden('menu_item_id', $menu_item_id) }}

{{ Form::close() }}

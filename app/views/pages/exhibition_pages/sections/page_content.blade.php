{{ Form::open(array('route' => 'exb_page_contents.save', 'method' => 'post')) }}

	@include('pages.partials._page_content_form')

    {{ Form::hidden('id', $page->id) }}
    {{ Form::hidden('pc_id', 0, ['id' => 'pc_id']) }}

{{ Form::close() }}

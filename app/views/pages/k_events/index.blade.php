@extends('layouts.default')
  <script>
  </script>

@section('content')

    <div class="page_content" style="position:relative">
      <h3>Events <a href="/content/events/create" class="link">new</a></h3>
      <form id="list_form" method="post" action="/content/events/delete-kevents">
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:90px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><button type="submit" class="icon-fixed-width icon-trash" style="border:none;"></button></th>
          <th style="width:50%;"><strong>Title</strong></th>
          <th style="width:50%;"><strong>Subtitle</strong></th>
          <th><strong>Clusters</strong></th>
         	<th><strong>Datum</strong></th>
         	<th><strong>Start</strong></th>
          <th><strong>Ende</strong></th>
          <th style="min-width:55px;"><strong></strong></th>
         </tr>
      @foreach($events as $e)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $e->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
          <td style="vertical-align:middle;">{{ $e->title_de }}</td>
          <td style="vertical-align:middle;">{{ $e->subtitle_de }}</td>
          <td style="vertical-align:middle;">{{ implode(', ', $e->cluster_arr) }}</td>
      		<td style="vertical-align:middle;">{{ date('d/m/Y', strtotime($e->start_date)) }}</td>
      		<td style="vertical-align:middle;">{{ date('H:i', strtotime($e->start_time)) }}</td>
      		<td style="vertical-align:middle;">{{ date('H:i', strtotime($e->end_time)) }}</td>
      		<td style="width:80px; vertical-align:middle;"><a href="/content/events/edit/{{ $e->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
          <a href="javascript:deleteItem('{{$e->title_de}}', '/content/events/delete/{{ $e->id }}')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
      	</tr>

      @endforeach

      </table>
    </div>

<script>
function deleteKEvents() {
  var ids = [];
  for(i=0; i<form.elements.length; i++) {
     e = form.elements[i];
     if(e.name == 'id[]') {
        if(e.type == 'checkbox' && e.checked) {
          ids[ids.length] = e.value;
        }
     }
  }

  if(confirm('Are you sure, you wish to delete item(s) (y/n)'))

  $.ajax({
      type: 'GET',
      url: '/content/events/delete-kevents',
      data: { 'ids' : ids },
      dataType: 'json',
      success:function(data) { 
            console.log('Success..'+ "\n\n");
            location.reload();
        },
      error:  function(jqXHR, textStatus, errorThrown) {
              console.log('Failed.. ');
            }
  });
}

</script>

@stop
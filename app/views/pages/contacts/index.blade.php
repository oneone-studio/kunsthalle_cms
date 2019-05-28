@extends('layouts.default')
  <script>
  </script>

@section('content')
  
    <div class="page_content" style="position:relative">
      <h3>Contacts <a href="/content/contacts/create" class="link">new</a></h3>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:90px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/contacts/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <!-- <span class="glyphicon glyphicon-trash"></span> --></a></th>
         	<th style="width:45%;"><strong>Name</strong></th>
         	<th style="width:20%;"><strong>Funktion</strong></th>
          <th style="width:20%;"><strong>Abteilung</strong></th>
          <th style="width:90px;"></th>
         </tr>
      @foreach($contacts as $c)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $c->id }}" style="display:block; margin: 0px auto"></td>
          <td>{{ $c->first_name .' '. $c->last_name }} 
          <!-- <span style="font-size:10;color:#8e8e8e;font-weight:normal;position:relative;left:10px;">[order: {{$c->sort_order}}]</span> --></td>
          <td>{{ $c->function }}</td>
          <td>{{ $c->department->title_de }}</td>
      		<td style="width:90px;"><a href="/content/contacts/edit/{{ $c->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="javascript:deleteItem('{{$c->first_name .' '. $c->last_name}}', '/content/contacts/delete/{{$c->id}}')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
      	</p>

      @endforeach
    </div>

@stop
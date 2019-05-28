@extends('layouts.default')
  <script>
  </script>

@section('content')
  
    <div class="page_content" style="position:relative">
      <h3>Sponsor Groups <a href="/content/sponsor_groups/create" class="link">new</a></h3>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:90px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/sponsor_groups/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <!-- <span class="glyphicon glyphicon-trash"></span> --></a></th>
         	<th style="width:45%;"><strong>Name</strong></th>
         	<th style="width:20%;"><strong>Logo</strong></th>
          <th style="width:90px;"></th>
         </tr>
      @foreach($sponsor_groups as $c)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $c->id }}" style="display:block; margin: 0px auto"></td>
          <td>{{ $c->first_name .' '. $c->title }}</td>
          <td><img src="/files/sponsor_groups/{{$c->logo}}" style="max-width:50px;max-height:50px;"></td>
      		<td style="width:90px;"><a href="/files/sponsor_groups/edit/{{ $c->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="/content/sponsor_groups/delete/{{ $c->id }}" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
      	</p>

      @endforeach
    </div>

@stop
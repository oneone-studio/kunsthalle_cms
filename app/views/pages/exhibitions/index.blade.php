@extends('layouts.default')
  <script>
  </script>

@section('content')

    <div class="page_content" style="position:relative">
      <h3>Exhibtions <a href="/content/exhibitions/create" class="link">new</a></h3>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:90px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="javascript:deleteKEvents()" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></th>
         	<th><strong>Title</strong></th>
         	<th><strong>Date</strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($exhibitions as $e)
      	<tr>
          <td style="vertical-align:middle;"><input type="checkbox" name="id[]" value="{{ $e->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
      		<td style="vertical-align:middle;">{{ $e->title_de }} </td>
      		<td style="vertical-align:middle;">{{ $e->start_date }}</td>
      		<td style="width:80px; vertical-align:middle;"><a href="/content/exhibitions/edit/{{ $e->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="/content/exhibitions/delete/{{ $e->id }}" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
              <a href="http://kunsthalle-test.byethost31.com/exhibition/<?php echo $e->id;?>" target="_blank"  type="button" class="icon-fixed-width icon-globe" style="margin-left:5px;"><span class="glyphicon glyphicon-globe"></span></a>
          </td>
      	</tr>

      @endforeach
    </div>

@stop
@extends('layouts.default')
  <script>
  </script>

@section('content')
  
    <div class="page_content" style="position:relative">
      <h3>Tags <a href="/content/tags/create" class="link">new</a></h3>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:90px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/tags/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <!-- <span class="glyphicon glyphicon-trash"></span> --></a></th>
         	<th><strong>Title</strong></th>
         	<!-- <th><strong>Events</strong></th> -->
          <th><strong></strong></th>
         </tr>
      @foreach($tags as $c)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $c->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
          <td>{{ $c->tag_de }}</td>
<!--       		<td><?php $cnt = 0;
                    foreach($c->k_events as $e) {
                        if($cnt > 0) {
                          echo ', ';
                        }
                        echo $e->title_en;
                        ++$cnt;
                    }
             ?>
          </td>
 -->      		<td style="width:90px;"><a href="/content/tags/edit/{{ $c->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="javascript:deleteItem('{{$e->tag_de}}', '/content/tags/delete/{{ $c->id }}')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
      	</p>

      @endforeach
    </div>

@stop
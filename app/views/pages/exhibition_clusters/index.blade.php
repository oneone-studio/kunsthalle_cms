@extends('layouts.default')
  <script>
  </script>

@section('content')
  
    <div class="page_content" style="position:relative">
      <h3>Clusters <a href="/content/exhibition_clusters/create" class="link">new</a></h3>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:90px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/clusters/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <!-- <span class="glyphicon glyphicon-trash"></span> --></a></th>
         	<th><strong>Title</strong></th>
         	<th><strong>Exhibitions</strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($clusters as $c)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $c->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
      		<td>{{ $c->title_en }}</td>
      		<td><?php $cnt = 0;
                    foreach($c->exhibitions as $e) {
                        if($cnt > 0) {
                          echo ', ';
                        }
                        echo $e->title;
                        ++$cnt;
                    }
             ?>
          </td>
      		<td style="width:90px;"><a href="/content/exhibition_clusters/edit/{{ $c->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="/content/exhibition_clusters/delete/{{ $c->id }}" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
      	</p>

      @endforeach
    </div>

@stop
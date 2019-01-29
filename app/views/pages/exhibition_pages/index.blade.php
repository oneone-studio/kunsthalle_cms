@extends('layouts.default')
  <script>
  </script>
<?php //echo '<pre>'; print_r($pages); 
?>
@section('content')
  
    <div class="page_content" style="position:relative">
      <p class="page-title">Exhibition Pages 
        <a href="/content/pages/create-exb-page" class="link">New</a>
      </p>

      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:45px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/exhibition-pages/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <!-- <span class="glyphicon glyphicon-trash"></span> --></a></th>
          <th><strong>Title</strong></th>
          <th style="width:100px;"><strong>Main Teaser</strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($pages as $p)
        <tr>
          <td><input type="checkbox" name="id[]" value="{{ $p->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
          <td>{{ $p->title_de }}</td>

          <td style="width:90px;">
          @if($p->is_main_teaser) 
          <span style="color:darkgreen;font-weight:bold;">Main <a href="/exb-pages/unset-main-exb/{{$p->id}}" style="font-weight:normal;margin-left:4px;">[unset]</a> </span> 
          @else <a href="/exb-pages/set-main-exb/{{$p->id}}" style="font-weight:normal;">Make it main</a> @endif
          </td>

          <td style="width:90px;"><a href="/content/exhibition-pages/edit/{{$p->id}}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="javascript:deleteItem('{{$p->title_de}}', '/content/exhibition-pages/delete/{{$p->id}}')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
        </tr>

      @endforeach
    </div>

@stop
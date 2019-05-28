@extends('layouts.default')
  <script>
  </script>
<?php //echo '<pre>'; print_r($pages); 
?>
@section('content')
  
    <div class="page_content" style="position:relative">
      <p class="page-title">Redirects
        <a href="/content/redirects/create" class="link">New</a>
      </p>

      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:45px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/redirects/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <!-- <span class="glyphicon glyphicon-trash"></span> --></a></th>
          <th><strong>Slug</strong></th>
          <th><strong>Redirect</strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($redirects as $r)
        <tr>
          <td><input type="checkbox" name="id[]" value="{{ $r->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
          <td>{{ $r->slug }}</td>
          <td>{{ $r->redirect_url }}</td>

          <td style="width:90px;"><a href="/content/redirects/edit/{{$r->id}}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="javascript:deleteItem('{{$r->slug}}', '/content/redirects/delete/{{ $r->id }}')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
        </tr>

      @endforeach
      </table>
      @if(count($redirects) == 0)
        <div style="clear:both;"></div>
        <div style="width:100%; position:relative;top:70px; font-weight:normal;color:#777; clear:both;">No items found</div>
      @endif
    </div>

@stop
@extends('layouts.default')
  <script>
  </script>
<?php //echo '<pre>'; print_r($pages); 
?>
@section('content')
  
    <div class="page_content" style="position:relative">
      <p class="page-title">{{$menu_item->title_de}} / {{$content_section->title_de}} / Pages 
        <a href="/content/pages/create-sp/{{$menu_item->id}}/{{$cs_id}}" class="link">New</a>
        <span style="color:#9f9f9f; padding-left:2px; padding-right:0px;">|</span>
        <a href="/content/content-sections/{{$menu_item_id}}" class="link" style="margin-left:2px;">back</a>
      </p>

      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:45px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/pages/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <!-- <span class="glyphicon glyphicon-trash"></span> --></a></th>
          <th><strong>Title</strong></th>
          <th style="width:100px;"><strong>Main Teaser</strong></th>
          <th style="width:100px;"><strong>Order</strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($pages as $p)
        <tr>
          <td><input type="checkbox" name="id[]" value="{{ $p->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
          <td>{{ $p->title_de }}</td>
          <td style="width:90px;">
          @if($p->is_main_teaser) 
          <span style="color:darkgreen;font-weight:bold;">Main <a href="/pages/unset-main-teaser/{{$p->id}}/{{$menu_item_id}}/{{$cs_id}}" style="font-weight:normal;margin-left:4px;">[unset]</a> </span> 
          @else <a href="/pages/set-main-teaser/{{$p->id}}/{{$menu_item_id}}/{{$cs_id}}" style="font-weight:normal;">Make it main</a> @endif

          </td>
          <td><select name="sort_order" style="width:70px;" onchange="setPageOrder(this, {{$p->id}})">
                @for($c=1; $c<=count($pages); $c++)
                  <option value="{{$c}}" @if($p->sort_order == $c) selected="selected" @endif >{{$c}} </option>
                @endfor
              </select>
          </td>
          <td style="width:90px;"><a href="/content/pages/edit/{{$menu_item_id}}/{{ $cs_id }}/{{$p->id}}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
          
          <a href="javascript:deleteItem('{{$p->title_de}}', '/content/pages/delete-page/{{$menu_item_id}}/{{$cs_id}}/{{ $p->id }}')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
        </tr>
      @endforeach
    </div>

<form id="order_form" action="/pages/set-order" method="post">
  <input name="page_id" id="page_id" type="hidden">
  <input name="sort_order" id="sort_order" type="hidden">
  <input name="menu_item_id" value="{{$menu_item_id}}" type="hidden">
  <input name="cs_id" value="{{$cs_id}}" type="hidden">
</form>

<script>
function setPageOrder(sel, page_id) {
  $('#page_id').val(page_id);
  $('#sort_order').val(sel.value);
  $('#order_form')[0].submit();
}
</script>

@stop
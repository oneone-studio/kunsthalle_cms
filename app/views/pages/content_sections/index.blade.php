@extends('layouts.default')
  <script>
  </script>

@section('content')

    <div class="page_content" style="position:relative">
      <p class="page-title">Menu: {{$menu_item}}  <a href="/content/content-sections/create/{{$menu_item_id}}" class="link" style="font-size:11px;">+ Page Section</a>
        <span style="color:#9f9f9f; font-weight:normal; padding-left:2px; padding-right:0px;">|</span>
        <a href="/content/content-sections/create-sp" class="link" style="margin-left:2px; font-size:11px;">+ Page</a>
        <span style="color:#9f9f9f; font-weight:normal; padding-left:2px; padding-right:0px;">|</span>
        <a href="/content/menu-items" class="link" style="margin-left:2px; font-size:11px;">back</a>
      </p>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:45px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/content_sections/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
         	<th><strong>Title</strong></th>
          <th style="width:15%;"><strong>Pages</strong></th>
          <th style="width:10%;"><strong>Order</strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($content_sections as $c)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $c->id }}" style="display:block; margin: 0px auto 0px auto;"></td>
          <td>{{ $c->title_de }}</td>
          <td><select name="sort_order" id="sort_order" onchange="updateOrder({{$c->id}}, this)" style="width:50px;">
                @for($i=1; $i<=count($content_sections); $i++)
                  <option value="{{$i}}" @if($i == $c->sort_order) selected="selected" @endif >{{$i}} </option>
                @endfor
              </select>
           </td>
          <td>@if($c->type == 'page_section')
                <a href="/content/pages/{{$menu_item_id}}/{{$c->id}}">Pages </a>
              @else
                -
              @endif
              </td>
      		<td style="width:90px;">
      <?php 
            $edit_link = "/content/content-sections/edit/".$menu_item_id.'/'.$c->id;
            $del_link = "javascript:deleteItem('{{$c->title_de}}', '/content-sections/delete/".$menu_item_id.'/'.$c->id."')";
            if($c->type == 'page') {
                if(isset($c->pages[0])) {
                   $edit_link = "/content/pages/edit/".$menu_item_id.'/'.$c->id.'/'.$c->pages[0]->id;
                   $del_link = "javascript:deleteItem('{{$c->title_de}}', '/content/pages/delete/".$menu_item_id.'/'.$c->id.'/'.$c->pages[0]->id."')";
                }
            }
      ?>

          <a href="<?php echo $edit_link;?>" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="<?php echo $del_link;?>" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
      	</p>

      @endforeach
    </div>

<script>
function deleteMenuItem(del_url) {
  if(confirm('Wollen Sie die Seite wirklich löschen?')) {
    document.location.href = del_url;
  }
}

function updateOrder(id, sel) {
   document.location.href = "/content-sections/update-sort/"+id+'/'+sel.value;
}
</script>
@stop
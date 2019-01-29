@extends('layouts.default')
  <script>
  </script>

@section('content')
  
    <div class="page_content" style="position:relative">
      <p class="page-title">Menu Items <a href="/content/menu-items/create" class="link" style="font-size:11px;">+ Menu Item</a>
      </p>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:45px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/content_sections/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
          <th style="width:65%;"><strong>Menu Item</strong></th>
          <th style="width:10%;"><strong>Order</strong></th>
          <th style="width:100px;"><strong></strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($menu_items as $m)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $m->id }}" style="display:block; margin: 0px auto 0px auto;"></td>
          <td>{{ $m->title_de }}</td>
          <td><select name="sort_order" id="sort_order" onchange="updateOrder({{$m->id}}, this)" style="width:50px;">
                @for($i=1; $i<=count($menu_items); $i++)
                  <option value="{{$i}}" @if($i == $m->sort_order) selected="selected" @endif >{{$i}} </option>
                @endfor
              </select>
           </td>
          <td><a href="/content/content-sections/{{$m->id}}">Content</a></td>
          <td style="width:100px;"><a href="/content/content</td>
      		<td style="width:90px;">
      <?php 
            $edit_link = "/content/menu-items/edit/".$m->id;
            $del_link = "/content/menu-items/delete/".$m->id;
      ?>

          <a href="<?php echo $edit_link;?>" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="javascript:deleteMenuItem('<?php echo $del_link;?>')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
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
   document.location.href = "/menu-items/update-sort/"+id+'/'+sel.value;
}
</script>    

@stop
@extends('layouts.default')
  <script>
  </script>

@section('content')
  
    <div class="page_content" style="position:relative">
      <h3>Departments <a href="/content/departments/create" class="link">new</a></h3>
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:90px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; text-align:center;"><a href="/content/departments/delete-all" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></span>
         	<th><strong>Title</strong></th>
          <th style="width:10%;"><strong>Order</strong></th>
          <th><strong></strong></th>
         </tr>
      @foreach($departments as $d)
      	<tr>
          <td><input type="checkbox" name="id[]" value="{{ $d->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
          <td>{{ $d->title_de }}</td>
          <td><select name="sort_order" id="sort_order" onchange="updateOrder({{$d->id}}, this)" style="width:50px;">
                @for($i=1; $i<=count($departments); $i++)
                  <option value="{{$i}}" @if($i == $d->sort_order) selected="selected" @endif >{{$i}} </option>
                @endfor
              </select>
           </td>
      		<td style="width:90px;"><a href="/content/departments/edit/{{ $d->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"><span class="glyphicon glyphicon-edit"></span></a>
              <a href="javascript:deleteItem('{{$d->title_de}}', '/content/departments/delete/{{$d->id}}')" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"><span class="glyphicon glyphicon-trash"></span></a>
          </td>
      	</p>

      @endforeach
    </div>

<script>
function updateOrder(id, sel) {
   document.location.href = "/departments/update-order/"+id+'/'+sel.value;
}
</script>
@stop
@extends('layouts.default')
@section('content')

    <div class="page-content" style="position:relative;">
      <p class="page-title">Members <a href="/members/create" class="link">new</a></p>

      <form method="post" action="">
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:40px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:40px; max-width:40px; text-align:center;"><a href="javascript:deleteKProfiles()" title="Delete" type="button" class="icon-fixed-width icon-trash"></a></th>
          <th style="width:30%;"><strong>Second_Name</strong></th>
	  <th style="width:30%;"><strong>First_Name</strong></th>
          <th style="width:30%;"><strong>Company</strong></th>
          
          <th><strong></strong></th>
         </tr>
      
      @foreach($members as $m)
      
        <tr>
          <td style="width:40px;"><input type="checkbox" name="id[]" value="{{ $m->id }}" style="display:block; margin: 4px auto 2px auto;"></td>
          <td style="width:30%; vertical-align:middle;">{{ $m->second_name }}</td>
	  <td style="width:30%; vertical-align:middle;">{{ $m->first_name }}</td>
          <td style="width:30%; vertical-align:middle;">{{ $m->company }}</td>
          
          <td style="text-align:center; vertical-align:middle;"><a href="/members/edit/{{ $m->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"></a>
             <a href="javascript:deleteMember({{ $m->id }})" title="Delete" type="button" class="icon-fixed-width icon-trash" style="margin-left:5px;"></a>
          </td>
        </tr>
      
      @endforeach


      </table>
      </form>
    </div>

<script>
function deleteMember(id) {
  if(!isNaN(id)) {
    if(confirm('Are you sure you want to delete (y/n)?')) {
      document.location.href = '/members/delete/'+id;
    }
  }
}


function deleteMembers() {
  var ids = [];
  for(i=0; i<form.elements.length; i++) {
     e = form.elements[i];
     if(e.name == 'id[]') {
        if(e.type == 'checkbox' && e.checked) {
          ids[ids.length] = e.value;
        }
     }
  }

  if(confirm('Are you sure, you wish to delete item(s) (y/n)'))

  $.ajax({
      type: 'GET',
      url: '/content/members/delete-kmembers',
      data: { 'ids' : ids },
      dataType: 'json',
      success:function(data) { 
            console.log('Success..'+ "\n\n");
            location.reload();
        },
      error:  function(jqXHR, textStatus, errorThrown) {
              console.log('Failed.. ');
            }
  });
}

</script>

@stop
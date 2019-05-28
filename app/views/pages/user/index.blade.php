@extends('layouts.default')
@section('content')

    <div class="page-content" style="position:relative;">
      <p class="page-title">Accounts <a href="/user/create" class="link">new</a></p>

      <form method="post" action="">
      <table class="table table-striped table-bordered" style="width:100%; height:auto; position:absolute; top:40px; font-size:12px; font-weight:normal;">
         <tr>
          <th style="width:50px; max-width:40px; text-align:center;"><div id="toggle_all_chk" 
           onclick="toggleAllAccounts()" style="display:block; margin: 4px auto 2px auto;cursor:pointer;">Select All</div></th>
          <th style="width:80%;"><strong>User</strong></th>
          <th style="width:60px;"><strong><img src="/images/envelope.jpg" style="max-width:18px;max-height:20px;float:right;margin-right:24px;cursor:pointer;" 
            onclick="sendMassEmail()"></strong></th>
         </tr>
      
      @foreach($accounts as $a)
      
        <tr>
          <td style="width:40px;"><input type="checkbox" name="id[]" value="{{ $a->id }}" onclick="updateChk(this)" class="account-chk" style="display:block; margin: 4px auto 2px auto;"></td>
          <td style="width:80%; vertical-align:middle;">{{ $a->name }}</td>          
          <td style="text-align:center; vertical-align:middle;"><a href="/user/edit/{{ $a->id }}" title="Edit" type="button" class="icon-fixed-width icon-pencil" style="margin-left:5px;"></a>
             <a href="javascript:sendPW()"><img src="/images/envelope.jpg" style="max-width:18px;max-height:20px;margin-left:7px;"></a>
          </td>
        </tr>
      
      @endforeach

      </table>
      </form>
    </div>

<script>
function updateChk(chk) {
  if(!chk.checked) {
    $('#toggle_all_chk').prop('checked', false);
  }
  chk.blur();
}

var checkedAll = false;
function toggleAllAccounts() {
  if(!checkedAll) {
    $('.account-chk').prop('checked', true);
    $('#toggle_all_chk').html('Uncheck All');
    checkedAll = true;
  } else {
    $('.account-chk').prop('checked', false);
    $('#toggle_all_chk').html('Select All');
    checkedAll = false;
  }
}

// function toggleAllAccounts(chk) {
//   if(chk.checked) {
//     $('.account-chk').prop('checked', true);
//   } else {
//     $('.account-chk').prop('checked', false);
//   }
// }

function deleteProfile(id) {
  if(!isNaN(id)) {
    if(confirm('Are you sure you want to delete (y/n)?')) {
      document.location.href = '/profiles/delete/'+id;
    }
  }
}

function sendMassEmail() {
  var arr = $('input.account-chk');
  var ids = [];
  for(var i in arr) {
    if(arr[i] != undefined && arr[i].value != undefined) {
      if(arr[i].checked) {
        ids[ids.length] = arr[i].value;
      }
    }
  }
  console.log(ids);
  if(ids.length > 0) {
    $.ajax({
        type: 'POST',
        url: '/send-mass-email',
        data: { 'ids' : ids, 'mail_type': 'password' },
        dataType: 'json',
        success:function(data) { 
           console.log('sendMassEmail success..');
        },
        error:  function(jqXHR, textStatus, errorThrown) {
           console.log('sendMassEmail failed..');
        }
    });
  }
}

function deleteProfiles() {
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
      url: '/content/profiles/delete-kprofiles',
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
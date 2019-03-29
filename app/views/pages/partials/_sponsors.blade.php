<div id="sponsor_blk_{{$sp->id}}" style="width:50px;float:left;margin-right:20px;">
    <a href="javascript:deleteSponsor({{$sp->id}})" style="color:orangered;font-size:14px;">x </a><br>
	<div style="width:50px;float:left;padding:5px; border:1px solid #e9e9e9; cursor:pointer;" onclick="editSponsor({{$grp->id}}, {{$sp->id}})">
		<img src="/files/sponsors/{{$sp->logo}}" style="max-width:50px;border:none;"><br>
	</div>
</div>
<div id="grid_image_li_{{$grd_image->id}}" class="grid-image-li">
	<a href="javascript:deleteGridImage({{$grd_image->id}})" title="Delete" type="button" 
		class="icon-fixed-width icon-trash trash"><span class="glyphicon glyphicon-trash"></span></a>
	<a href="javascript:editGridImage({{$image_grid->id}}, {{$grd_image->id}})"><img src="{{$DOMAIN}}/files/grid_image/{{$grd_image->filename}}" 
		class="grid-img"></a>
</div>
<div style="clear:both;height:10px;"></div>
<div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Headline</div>
<div style="width:70%;display:inline-block;">
    <input placeholder="" style="width:500px;float:left;" name="sponsor_group_de" type="text" id="sponsor_group_de">
    <div class="inp-de">DE</div><br/>
    <div style="clear:both;"></div>
    <input placeholder="" style="width:500px;float:left;" name="sponsor_group_en" type="text" id="sponsor_group_en">
    <div class="inp-en">EN</div><br/>
</div>
<div style="clear:both;"></div>
<div style="width:120px;float:left;margin-top:6px;margin-right:8px;">Order</div>
<select style="width:60px;float:left;" name="sort_order" id="sg_sort_order">
   @for($i=1; $i<=10; $i++)
	  <option value="{{$i}}">{{$i}} </option>
   @endfor
</select>	
<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
    <input class="btn btn-primary" style="position:relative;top:10px;left:128px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save Group">
</div>
<label for="group" style="float:left;width:130px;">Group</label>
<span id="sponsor_group_val"></span>
<div style="clear:both;"></div>
<label for="logo" style="float:left;width:130px;">Logo</label>
<?php echo Form::file('logo', ['id' => 'sponsor_logo', 'onchange' => 'uploadSponsorLogo('.$grp->id.')']); ?>			
<div style="clear:both;"></div>
<label for="" style="float:left;width:130px;">Preview</label>
<div style="width:10%; float:left; display:inline;">
  <?php $display = 'display:none;'; ?>
      <div style="width:100px !important; height:100px; cursor:pointer; display:inline-block; margin-top:5px; margin-left:0px; 
      background-size:cover; border:1px dashed #e3e3e3;"><img id="sponsor_preview_{{$grp->id}}" src="#" style="max-width:100px; max-height:100px; float:left; <?php echo $display;?>">
      </div>
</div>      
<div style="clear:both;"></div>
<div style="width:120px;float:left;margin-top:6px;margin-right:8px;">URL</div>
<input placeholder="" style="width:500px;float:left;" name="url" type="text" id="sponsor_url_{{$grp->id}}">
<div style="clear:both;"></div>
<div class="form-group" style="margin-left:0px; padding-bottom:20px;">
    <input class="btn btn-primary" style="position:relative;top:10px;left:128px;height:30px; padding:3px 15px 5px 15px" type="submit" value="Save Sponsor">
</div>
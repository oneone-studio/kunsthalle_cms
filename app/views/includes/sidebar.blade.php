
<?php
$lastSBSectionId = 0;
?>

<div class="sidebar" style="margin-right:10px;">

	   <ul class="side_nav sidebar-l1">
	  @if(is_array($sidebar))
	  	@foreach($sidebar['general'] as $link_title => $link)
	   		<li><a href="{{$link}}">{{$link_title}}</a></li>
	  	@endforeach
	  @endif   	

   	    <li><ul class="sidebar-l2">
   	   		  <li class="sb-section-title sb-title-l2"><a href="/content/menu-items/" style="margin-left:0px;font-size:14px;color:#0071C3;">Main Menu </a><br>
            <a href="/content/menu-items/create" style="margin-left:0px;font-size:11px;font-weight:normal;color:#333;">+ Menu Item</a></li>
   	   
       @if($sidebar && count($sidebar))		  
         @foreach($sidebar['menu_items'] as $mi)
         
             <li ><a href="/content/menu-items/edit/{{$mi['menu_item']['id']}}" style="margin-left:0px;">{{$mi['menu_item']['title_de']}}</a>
              <?php 
                $mi_display = (isset($menu_item_id) && $mi['menu_item']['id'] == $menu_item_id) ? 'inline' : 'none';

                if($mi_display == 'none') { 
                    echo '<a id="toggle_cs_'.$mi['menu_item']['id'].'" href="javascript:expandSBSection('.$mi['menu_item']['id'].
                      ')" style="font-size:16px;text-decoration:none;">+</a>'; 
                } else { 
                    echo '<a id="toggle_cs_'.$mi['menu_item']['id'].'"  href="javascript:collapseSBSection('.$mi['menu_item']['id'].')"
                      style="font-size:16px;text-decoration:none;">-</a>'; 
                    $lastSBSectionId = $mi['menu_item']['id'];
                }
              ?>
                <br>
                <div id="page_opt_<?php echo $mi['menu_item']['id'];?>" style="width:100px;display:inline; margin-left:0px;">
                <a href="/content/content-sections/create/{{$mi['menu_item']['id']}}" 
                    style="margin-left:0px;font-size:11px;font-weight:normal;color:#333;">+ Section</a>
                <div style="width:10px; text-align:center; display:inline-block; color:blue; font-size:14px;">|</div>
                <a href="/content/content-sections/create-sp/{{$mi['menu_item']['id']}}" 
                   style="margin-left:0px;font-size:11px;font-weight:normal;color:#333;text-decoration:none;">+ Page</a>
                </div>
             <ul id="cs_list_{{$mi['menu_item']['id']}}" style="display:<?php echo $mi_display;?>;margin-left:0;position:relative;">

      			 @foreach($mi['content_sections'] as $cs)
               @if($cs->type == 'page_section')

            <?php 
                $cs_display = (isset($cs_id) && ($cs['id'] == $cs_id)) ? 'color:red;' : '';
            ?>
         	   		<li style="display:<?php echo $cs_display;?>;"><a href="/content/content-sections/edit/{{$mi['menu_item']['id']}}/{{$cs->id}}" 
                    style="margin-left:0;display:inline-block;margin-bottom:10px;">{{$cs['title_de']}}</a>
         	   			<a href="/content/pages/create-sp/{{$mi['menu_item']['id']}}/{{$cs->id}}" class="form-link" 
                    style="font-size:11px; font-weight:normal;">[+Page]</a>
         	   			@if(count($cs->pages) > 0)
         	   				<ul class="sidebar-l3" style="margin-left:0;">
         	   				  @foreach($cs->pages as $p) 
                        <?php $style = ' style="text-decoration:none;"';
                              $li_style = ' style="padding:1px 2px 0px 0px;display:table;text-decoration:none;"';
                              if(isset($page) && $page->id == $p->id) { 
                                  $style = ' style="color:orangered;"'; 
                                  $li_style = ' style="padding:1px 2px 1px 0px;display:table; color:orangered;"'; 
                              }
                        ?>
         	   				  	<li <?php echo $li_style;?> ><a href="/content/pages/edit/{{$mi['menu_item']['id']}}/{{$cs->id}}/{{$p->id}}"
                         <?php echo $style;?> >{{$p->title_de}}</a></li>
         	   				  @endforeach	
         	   				</ul>
         	   			@endif
         	   		</li>
               @endif
               @if($cs->type == 'page')
                  @if(count($cs->pages))
                    <?php $style = 'margin-left:0;';
                          $li_style = ' style="padding:1px 2px 0px 0px;display:block;margin-top:5px;"';
                          if(isset($page) && $page->id == $cs->pages[0]->id) { 
                              $style = ' style="color:orangered;"'; 
                              $li_style = ' style="padding:1px 2px 1px 0px; color:orangered;"'; 
                          }
                    ?>
                    <li <?php echo $li_style;?> ><a href="/content/pages/edit/{{$mi['menu_item']['id']}}/{{$cs->id}}/{{$cs->pages[0]->id}}"
                        <?php echo $style;?> >{{$cs->pages[0]->title_de}} </a></li>
                  @endif
               @endif

       	   	 @endforeach	

           </ul></li>

         @endforeach    
   	   @endif	 
   	  	  </ul>
   	    </li>

	   </ul>
</div>

<script>
var lastSBSectionId = <?php echo $lastSBSectionId;?>;

function expandSBSection(id) {
  if(lastSBSectionId > 0) {
    collapseSBSection(lastSBSectionId);
  }
  lastSBSectionId = id;
  if($('#toggle_cs_'+id).length) {
    $('#toggle_cs_'+id).attr('href', 'javascript:collapseSBSection('+id+')').html('-');
  }
  if($('#cs_list_'+id).length) {
    $('#cs_list_'+id).show();
  }
}

function collapseSBSection(id) {
  if($('#toggle_cs_'+id).length) {
    $('#toggle_cs_'+id).attr('href', 'javascript:expandSBSection('+id+')').html('+');
  }
  if($('#cs_list_'+id).length) {
    $('#cs_list_'+id).hide();
  }
}

function showOpt(id) {
  if($('#page_opt_'+id).length) {
    $('#page_opt_'+id).show();
  }
}

function hideOpt(id) {
  if($('#page_opt_'+id).length) {
    $('#page_opt_'+id).hide();
  }
}

</script>

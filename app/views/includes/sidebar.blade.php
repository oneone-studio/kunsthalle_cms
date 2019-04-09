
<?php
$lastSBSectionId = 0;
?>
<style>
a { text-decoration: none; }
a:hover { text-decoration: none; }
.plus .minus {
  font-size:20px !important;text-decoration:none; font-weight:bold;
}
</style>
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
              
            <?php 
              $mi_display = (isset($menu_item_id) && $mi['menu_item']['id'] == $menu_item_id) ? 'inline' : 'none';
              $mi_id = $mi['menu_item']['id'];
              $toggle_href = '';
              $toggle_el = '';
              if($mi_display == 'none') {
                  $toggle_href = 'javascript:expandSBSection('.$mi['menu_item']['id'].')';
                  $toggle_el = '<a id="toggle_cs_'.$mi['menu_item']['id'].'" href="'.$toggle_href.'" class="plus" style="font-size:18px;text-decoration:none;font-weight:bold;position:relative;top:2px;">+</a>'; 
              } else { 
                  $toggle_href = 'javascript:collapseSBSection('.$mi['menu_item']['id'].')';
                  $toggle_el = '<a id="toggle_cs_'.$mi['menu_item']['id'].'"  href="'.$toggle_href.'"
                    class="minus" style="font-size:18px;text-decoration:none;font-weight:bold;position:relative;top:2px;">-</a>'; 
                  $lastSBSectionId = $mi['menu_item']['id'];
              }
            ?>

             <li><div class="menu-item-title"><a href="{{$toggle_href}}" class="toggle-el-{{$mi_id}}" 
                  style="margin-left:0px;">{{$mi['menu_item']['title_de']}}</a>
                  <div style="width:60px;float:right;"><a href="/content/menu-items/edit/{{$mi['menu_item']['id']}}">[Edit]</a></div>
                  {{ $toggle_el }}
                </div>
                <div style="clear:both;"></div>
                <div id="page_opt_<?php echo $mi['menu_item']['id'];?>" style="width:100px;display:inline; margin-left:0px;">
                <a href="/content/content-sections/create/{{$mi['menu_item']['id']}}" 
                    class="menu-item-line-2"><div class="toggle-icon">+</div> Section</a>
                <div style="width:10px; text-align:center; display:inline-block; color:blue; font-size:14px;">|</div>
                <a href="/content/content-sections/create-sp/{{$mi['menu_item']['id']}}" 
                   class="menu-item-line-2"><div class="toggle-icon">+</div> Page</a>
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
                        <?php $class = (isset($page) && $page->id == $p->id) ? ' class="cur"' : ''; ?>
         	   				  	<li {{$class}} ><a href="/content/pages/edit/{{$mi['menu_item']['id']}}/{{$cs->id}}/{{$p->id}}"
                         >{{$p->title_de}}</a></li>
         	   				  @endforeach	
         	   				</ul>
         	   			@endif
         	   		</li>
               @endif
               @if($cs->type == 'page')
                  @if(count($cs->pages))
                    <?php $class = (isset($page) && $page->id == $cs->pages[0]->id) ? ' class="cur"' : ''; ?>
                    <li {{$class}}><a href="/content/pages/edit/{{$mi['menu_item']['id']}}/{{$cs->id}}/{{$cs->pages[0]->id}}"
                        >{{$cs->pages[0]->title_de}} </a></li>
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
    $('.toggle-el-'+id).attr('href', 'javascript:collapseSBSection('+id+')');
  }
  if($('#cs_list_'+id).length) {
    $('#cs_list_'+id).fadeIn(200).show();
  }
}

function collapseSBSection(id) {
  if($('#toggle_cs_'+id).length) {
    $('#toggle_cs_'+id).attr('href', 'javascript:expandSBSection('+id+')').html('+');
    $('.toggle-el-'+id).attr('href', 'javascript:expandSBSection('+id+')');
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

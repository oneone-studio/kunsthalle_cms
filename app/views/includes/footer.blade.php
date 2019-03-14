<div class="footer-content" id="copyright text-right">
	<!--© Copyright 2016 Kunshalle -->

<script>
// Shared vars, funcs

var AUDIO_BID = 'audio_block';
var BANNER_BID = 'banner_block';
var DOWNLOAD_BID = 'downloads_block';
var H2_BID = 'h2_block';
var H2TEXT_BID = 'h2text_block';
var IMAGE_BID = 'image_block';
var IMAGE_GRID_BID = 'image_grid_block';
var PAGE_CONTENT_BID = 'page_content_block';
var SLIDER_BID = 'page_image_slider_block';
var IMAGE_SLIDER_BID = SLIDER_BID;
var TEASER_BID = 'teasers_block';
var YOUTUBE_BID = 'youtube_block';
var SPONSOR_BID = 'sponsors_block';
var url = document.URL;

<?php if(isset($cur_block_id)) { ?>
  cur_block_id = '<?php echo $cur_block_id; ?>';
<?php } ?>
<?php if(isset($cur_input)) { ?>
  cur_input = '<?php echo $cur_input; ?>';
<?php } ?>

var edit_block_ids = ['audio_block', 'banner_blk', 'downloads_block', 'h2_block', 'h2text_block', 'image_pane', 'image_grid_pane', 'page_image_slider', 'sponsors_block', 'teasers_block', 'youtube_block', 'page_content_blk'];

function hideAllEditSections() {
  var blk_id = '';
  for(var i in edit_block_ids) {
    blk_id = edit_block_ids[i];
    if($('#'+blk_id).length) { 
      $('#'+blk_id).hide(); 
    }
  }
}

function resetCurBlockId() {
  cur_block_id = '';
  cur_input = '';
}

function resetEdit() {
  $('div[class*="_icon"]').removeClass('collapse').addClass('expand');
  $('.menu-icon-active').removeClass('menu-icon-active');
  $('.lbl-1').css('color', '#000000');
  $('.edit-section').hide();
  cur_block_id = '';
}

function resetH2Intro() {
  $('#h2text_h2de').val('');
  $('#h2text_h2en').val('');
  tinyMCE.get('intro_de').setContent('');
  tinyMCE.get('intro_en').setContent('');
  $('#h2text_id').val('');
}

function resetAudio() {
  $('#audio_url').val('');
  $('#audio_id').val('');
  $('#audio_preview').hide();
}

function resetYoutube() {
  $('#youtube_url').val('');
  $('#youtube_id').val('');
  $('#youtube_preview').hide();
}

var menuBarScrollPos = 0;

if($("#cp_block").length) {
  menuBarScrollPos = $("#cp_block").offset().top;
  var minus_val = 70;
  if(url.indexOf('/pages') > -1) { minus_val = 125; }
  menuBarScrollPos -= minus_val;
  menuBarScrollPos = parseInt(menuBarScrollPos);
}

function scrollToMenu() {
    $('html, body').animate({ scrollTop: menuBarScrollPos }, 500);
}

function scrollToTop() {
    $('html, body').animate({ scrollTop: 0 }, 500);
}

function scrollTo(selector) {
  var scrollPos = 100;
  if($('#'+selector).length) { scrollPos = $("#"+selector).offset().top; }
  if($('.'+selector).length) { scrollPos = $("."+selector).offset().top; }
  if(scrollPos > 0) { scrollPos -= 40; }

  $('html, body').animate({ scrollTop: scrollPos }, 500);
}

function doToggleBlock(BID) {
  if($('#'+BID).length) {
    scrollTo(BID);
    toggleBlock(BID);
    return;
  }
  setTimeout('doToggleBlock('+BID+')', 100);
}

function doToggleInput(type) {
    toggleInput(type);
}

$(function() {
  var do_toggle_block = false;
  var do_toggle_input = false;
  var BID = '';
  // if(url.indexOf('/sponsor') > -1) { BID = SPONSOR_BID; do_toggle_block = true; }
  // if(url.indexOf('/downloads') > -1) { BID = DOWNLOAD_BID; do_toggle_block = true; }
  if(url.indexOf('image_grid') > -1) { BID = IMAGE_GRID_BID; type = 'image_grid'; do_toggle_input = true; }

  // if(do_toggle_block && BID.length > 0) {
  //   resetEdit();
  //   doToggleBlock(BID);
  // }
  if(do_toggle_input) {
    doToggleInput(type);
  }
});


</script>

</div>
	{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'); }}
	{{ HTML::script('js/chosen/chosen.jquery.js'); }}
	{{ HTML::script('js/chosen/docsupport/prism.js'); }}
<script type="text/javascript">
var config = {
  '.chosen-select'           : {},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}

tinymce.init({
  selector: '.tm_editor',
  menubar: false,
  toolbar: [
  'undo redo | bold italic | link fontselect preview | alignleft aligncenter alignright | code',
  // 'undo redo | bold italic | fontselect fontsizeselect | link image preview | alignleft aligncenter alignright',
  ],
  font_formats: 'Georgia=georgia;Circular=verdana',
  plugins: "link image preview code",
  file_browser_callback_types: 'file image media',  
  //file_browser_callback: 'RoxyFileBrowser'
  images_upload_url: 'postAcceptor.php',
  setup : function(ed)
      {
        ed.on('init', function(ed) { 
          // this.getDoc().body.style.fontFamily = 'UniversNextPro-Cond';   
          this.getDoc().body.style.fontSize = '14px';   
          this.getDoc().body.style.lineHeight = '17px';   
      });
  }
  //});
  // content_css : "/js/tinymce/custom-styles.css",
});

// H2 + Intro

tinymce.init({
  selector: '.tm_editor_h2intro',
  menubar: false,
  toolbar: [
  'undo redo | bold italic | link fontselect preview | alignleft aligncenter alignright | code',
  // 'undo redo | bold italic | fontselect fontsizeselect | link image preview | alignleft aligncenter alignright',
  ],
  font_formats: 'Georgia=georgia;Circular=verdana',
  plugins: "link image preview code",
  file_browser_callback_types: 'file image media',  
  //file_browser_callback: 'RoxyFileBrowser'
  images_upload_url: 'postAcceptor.php',
  setup : function(ed)
      {
        ed.on('init', function(ed) { 
          // this.getDoc().body.style.fontFamily = 'UniversNextPro-Cond';   
          this.getDoc().body.style.fontSize = '18px';   
          this.getDoc().body.style.lineHeight = '22px';   
      });
  }
  //});
  // content_css : "/js/tinymce/custom-styles.css",
});

// Delete function for list items
function deleteItem(title, delUrl) {
  if(confirm('Wollen Sie die Seite wirklich löschen?')) {
    document.location.href = delUrl;
  }
}

function deleteListItem(del_url) {
  if(confirm('Wollen Sie die Seite wirklich löschen?')) {
    document.location.href = del_url;
  }
}

</script>
<style>
input {
  height:26px; border:1px solid lightgray; border-radius:0px; padding:2px 5px; color:#333; margin-top:2px;
}
input[type='text'] {
  border-radius:0px;
}

@font-face {
  font-family: "UniversNextPro-Cond";
    src: url('https://kunsthalle-cms.net/fonts/circular/2D4707_1_0.eot'); /* IE9 Compat Modes */
    src: url('https://kunsthalle-cms.net/fonts/circular/2D4707_1_0.eot?#iefix') format('embedded-opentype'), 
         url('https://kunsthalle-cms.net/fonts/circular/2D4707_1_0.woff') format('woff');
         /*,
         url('woollaa../fonts/PFDekkaProWeb_Bold/PFDekkaPro-Bold.svg#PFDekkaPro-Bold') format('svg'); /* Legacy iOS */
}

</style>

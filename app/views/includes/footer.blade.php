<div class="footer-content" id="copyright text-right">
	<!--© Copyright 2016 Kunshalle -->
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

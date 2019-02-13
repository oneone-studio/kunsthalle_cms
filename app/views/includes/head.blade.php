<meta charset="UTF-8">
<title>Kunsthalle CMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- {{ HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); }} -->
{{ HTML::script('js/common.js'); }}

{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js'); }}
<!-- {{ HTML::script('https://code.jquery.com/qunit/qunit-1.19.0.js'); }} -->
{{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'); }}

{{ HTML::style('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css'); }}
{{ HTML::script("js/angular-1.1.5.min.js"); }}
{{ HTML::script('js/k_events.js'); }}


<!-- Summernote WYSIWYG -->

  <!-- include jquery -->
  <!--
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
  -->
  <!-- include libraries BS3 - ->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" />
  <script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
  <!-- include summernote - ->
  {{ HTML::style('js/summernote/dist/summernote.css'); }}
  {{ HTML::script('js/summernote/dist/summernote.js'); }}

<!-- Summernote WYSIWYG END -->

{{ HTML::style('js/chosen/docsupport/prism.css'); }}
{{ HTML::style('js/chosen/chosen.css'); }}
  <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
  </style>

{{ HTML::script('js/tinymce/tinymce.min.js') }}
{{ HTML::style('css/styles.css'); }}
{{ HTML::style('css/button-styles.css'); }}

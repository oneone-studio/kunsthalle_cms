<!doctype html>
 <html lang='en'>
 <head>
 	<meta charset='utf-8'>
 	<title>my first pdfmake example</title>
 	<script src='pdfmake.min.js'></script>
 	<script src='vfs_fonts.js'></script>
 </head>

 <script>
	var docDefinition = { content: 'This is an sample PDF printed with pdfMake' };
	pdfMake.createPdf(docDefinition).open();
 </script>
 <body>
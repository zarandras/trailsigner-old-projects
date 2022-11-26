<?php

require_once('db_conn.php');
require_once('db_utils.php');
require_once('gui_utils.php');
require_once('signpost.php');

//header('Content-type: text/html; charset=iso-8859-2');

?>
<html>
<head>
<title>Jelzett útvonal - tábla</title>
<style type="text/css">
a:link {text-decoration:none; color:#0000DD;}    /* unvisited link */
a:visited {text-decoration:none; color:#8800FF;} /* visited link */
a:hover {text-decoration:none; color:#0088FF;}   /* mouse over link */
a:active {text-decoration:none; color:#0088FF;}  /* selected link */
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
td
{
background-color:#EAF2D3;
color:#000000;
}
td.branch
{
background-color: #FFFFFF;
color: #666666;
font-style: italic;
}
td.branch_from
{
background-color: #FFFFFF;
color: #666666;
font-style: italic;
font-weight: bold;
}
th
{
background-color:#A7C942;
color:#ffffff;
}
</style>
</head>
<body>
<h1>Útjelző tábla - GyalogútKataszter v0.1</h1>
<span style="display: block; text-align: right;">
  <a href="../gyk_doc/doc_viewer_hu.html#view_signpost" target="_blank"><img src="gui_img/question.png" border="0">&nbsp;Súgó</a>
</span>
<?

// main - print signpost:
if (@$_REQUEST['id'] == null) {
	printerr("Nincs megadva tábla!");
} else {
	$signpost = Signpost::query_signpost ($_REQUEST['id']);
	if (@$signpost == null) {
            printerr("A kért tábla nem létezik vagy nem elérhető!");
	} else {
            print($signpost->renderHtml());
	}
}

?>
</body>
</html>
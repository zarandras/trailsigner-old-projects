<?php

require_once('db_conn.php');
require_once('db_utils.php');
require_once('gui_utils.php');
require_once('trail.php');

//header('Content-type: text/html; charset=utf-8');

?>
<html>
<head>
<title>Jelzett útvonalak listája</title>
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
th
{
background-color:#A7C942;
color:#ffffff;
}
</style>
</head>
<body>
<h1>Jelzett útvonalak listája - GyalogútKataszter v0.1</h1>

<span style="display: block; text-align: right;">
  <a href="../gyk_doc/doc_viewer_hu.html#list_trails" target="_blank"><img src="gui_img/question.png" border="0">&nbsp;Súgó</a>
</span>
<?

$trails = Trail::query_trails ();
// print trails:
print_trail_table ($trails);

function print_header_row () {
	print("<tr>" .
		"<th>ID</th>" .
		"<th>Útkód</th>" .
		"<th>Jel</th>" .
		"<th>Leírás</th>" .
		//"<th>Megjegyzés</th>" .
		"<th>Hossz</th>" .
		"<th>Turistautak.hu útvonal</th>" .
		"<th>Napi szakaszok</th>" .
		"<th>Szervezet(ek)</th>" .
	"</tr>\n");
}

function print_trail_row (Trail $trail) {
		$trail_record = $trail->getRecord();
		print("<tr>" .
                        "<td nowrap>" . $trail_record['trail_id'] . "</td>" . //debug
			//utkod+mod:
			"<td nowrap>" . sprint_linkto_trailpage_plain((empty($trail_record['trail_code']) ? "" :  $trail_record['trail_code'] . " ") .
								sprint_modality($trail_record['modality']), $trail_record['trail_id']) .
                                                                (($trail_record['trail_id'] < 0)? " (vissza)" : "") . "</td>" .
			//jel:
			"<td nowrap>" . sprint_linkto_trailpage_plain(sprint_trailmark($trail_record['trailmark']), $trail_record['trail_id']) . "</td>" .
			//utnev es leiras:
			"<td width=\"25%\">" . sprint_linkto_trailpage(
				( (empty($trail_record['trail_name'])) ? "" : "<b>" . $trail_record['trail_name'] . ": </b> " ) .
				$trail_record['description'], $trail_record['trail_id']) . "</td>" .
			////megjegyzes:
			//hossz:
			"<td nowrap>" . sprint_notnull($trail->getTrailLength(), round($trail->getTrailLength()/1000.0, 2) . " km") . "</td>" .
			//tuhu utv.:
			"<td nowrap><b>" . sprint_linkto_routepage($trail_record['params']['tuhu_route'], $trail_record['params']['tuhu_route']) . "</b></td>" .
			//etapok:
			"<td>" . sprint_linksto_etaps($trail_record['trail_id'], $trail_record['params']['etap']) . "</td>" .
			//szervezet:
			"<td nowrap>" . str_replace(";", "<br>", $trail_record['params']['organization']) . "</td>" .
		"\n</tr>\n");
}

function print_summary_row ($nr_trails, $sum_length) {
	print("<tr>" .
		"<th></th>" .
		"<th>Össz.:</th>" .
		"<th></th>" .
		"<th nowrap>" . $nr_trails . " db útvonal</th>" .
		//"<th></th>" .
		"<th nowrap>" . $sum_length . " km</th>" .
		"<th></th>" .
		"<th></th>" .
		"<th></th>" .
	"</tr>\n");
}

function print_trail_table (array $trails) {
	print("<table border=1 width=\"100%\">\n");
	print_header_row ();
	$nr_trails = 0;
	$sum_length = 0;
	foreach ($trails as $trail) {
		print_trail_row ($trail);
		$nr_trails++;
		$sum_length += round($trail->getTrailLength()/1000.0, 2);
	}
	print_summary_row ($nr_trails, $sum_length);
	print("</table>\n");
}

?>
</body>
</html>
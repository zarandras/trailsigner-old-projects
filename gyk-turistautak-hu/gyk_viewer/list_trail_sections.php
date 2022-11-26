<?php

require_once('db_conn.php');
require_once('db_utils.php');
require_once('gui_utils.php');
require_once('trail_section.php');

//header('Content-type: text/html; charset=utf-8');

?>
<html>
<head>
<title>Jelzett útvonalak szakaszai</title>
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
<h1>Jelzett útvonalak szakaszai - GyalogútKataszter v0.1</h1>
<span style="display: block; text-align: right;">
  <a href="../gyk_doc/doc_viewer_hu.html#list_trail_sections" target="_blank"><img src="gui_img/question.png" border="0">&nbsp;Súgó</a>
</span>
<?

$trail_sections = TrailSection::query_trail_sections ();
// print trail sections:
print_trail_section_table ($trail_sections);

function print_trail_section_header_row () {
	print("<tr>" .
                "<th>Szakasz ID</th>" .
                //"<th>Út ID</th>" .
                "<th>Útvonal</th>" .
		"<th>-Tól</th>" .
		"<th>-Ig</th>" .
                "<th>Szakasz paraméter</th>" .
		"<th>Hossz</th>" .
	"</tr>\n");
}

function print_summary_row ($nr_trail_sections, $sum_length) {
	print("<tr>" .
		"<th>Össz.:</th>" .
		//"<th></th>" .
		"<th></th>" .
		"<th></th>" .
		"<th></th>" .
		"<th nowrap>" . $nr_trail_sections . " db útszakasz</th>" .
		"<th nowrap>" . $sum_length . " km</th>" .
	"</tr>\n");
}

function print_trail_section_row (TrailSection $trail_section) {

        // !!! trail_section_stat view-ből is adatokat kinyerni !!!

		$trail_record = $trail_section->getRecord();
                $from_node_record = $trail_section->getFromNodeRecord();
                $to_node_record = $trail_section->getToNodeRecord();
		print("<tr>" .
                        "<td nowrap>" . sprint_linkto_trailsectionpage_plain($trail_record['trail_section_id'], $trail_record['trail_section_id']) . "</td>" . //debug
                        //"<td nowrap>" . $trail_record['trail_id'] . "</td>" . //debug
			//utkod+mod+jel:
			"<td nowrap>" . sprint_linkto_trailpage_plain(sprint_trailmark($trail_record['trailmark']) . "&nbsp;" . (empty($trail_record['trail_code']) ? "" :  $trail_record['trail_code'] . " ") .
								sprint_modality($trail_record['modality']), $trail_record['trail_id']) .
                                                                (($trail_record['trail_id'] < 0)? " (vissza)" : "") . "</td>" .
                        //tol-ig:
                        "<td>" . sprint_linkto_trailsectionpage_plain((@$from_node_record['name'] ? $from_node_record['name'] : "[út legeleje]"), $trail_record['trail_section_id']) . "</td>" .
                        "<td>" . sprint_linkto_trailsectionpage_plain((@$to_node_record['name'] ? $to_node_record['name'] : "[út legvége]"), $trail_record['trail_section_id']) . "</td>" .
                        //param:
                        "<td nowrap>" . sprint_linkto_trailsectionpage_plain($trail_record['param_name'] . " = " . $trail_record['value'], $trail_record['trail_section_id']) . "</td>" .
                        // hossz:
			"<td nowrap>" . sprint_notnull($trail_record['length_slope'], round($trail_record['length_slope']/1000.0, 2) . " km") . "<br>" .
                             sprint_notnull($trail_record['minutes_to'], sprint_minutes($trail_record['minutes_to'])) . "</td>" .
		"\n</tr>\n");
}

function print_trail_section_table (array $trail_sections) {
	print("<table border=1 width=\"100%\">\n");
	print_trail_section_header_row ();
	$nr_trail_sections = 0;
	$sum_length = 0;
	foreach ($trail_sections as $trail_section) {
		print_trail_section_row ($trail_section);
		$nr_trail_sections++;
                $rec = $trail_section->getRecord();
		$sum_length += round($rec['length_slope']/1000.0, 2);
	}
	print_summary_row ($nr_trail_sections, $sum_length);
	print("</table>\n");
}


?>
</body>
</html>
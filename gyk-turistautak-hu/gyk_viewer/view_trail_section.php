<?php

require_once('db_conn.php');
require_once('db_utils.php');
require_once('gui_utils.php');
require_once('trail_section.php');

//header('Content-type: text/html; charset=iso-8859-2');

?>
<html>
<head>
<title>Jelzett útvonal szakasz</title>
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
<h1>Jelzett útvonal szakasza - GyalogútKataszter v0.1</h1>
<span style="display: block; text-align: right;">
  <a href="../gyk_doc/doc_viewer_hu.html#view_trail_section" target="_blank"><img src="gui_img/question.png" border="0">&nbsp;Súgó</a>
</span>
<?

// main - print trail:
if (@$_REQUEST['trail_section_id'] == null) {
	printerr("Nincs megadva útvonal!");
} else {
	$trail_section = TrailSection::query_trail_section ($_REQUEST['trail_section_id']);
	if (@$trail_section == null) {
		printerr("A kért útvonal-szakasz nem létezik vagy nem elérhető!");
	} else {
		print_trail_section_header ($trail_section);
                if (!$trail_section->isOneWay()) {
                    print_trail_section_reverselink ($_REQUEST['trail_section_id']);
                }
		$nodes = get_trail_section_nodes($_REQUEST['trail_section_id']);
		print_trail_nodetable ($nodes);
	}
}


function print_trail_section_header ($trail_section) {
	print("<table border=1 width=\"100%\">\n");
	print_trail_section_header_row ();
	print_trail_section_row ($trail_section);
	print("</table>\n<br>\n");
}

function print_trail_section_reverselink ($trail_section_id) {
    print("<span style=\"display: block; text-align: right;\"><a href=\"view_trail_section.php?trail_section_id=" . -$trail_section_id . "\">[Visszafelé irány]</a></span><hr>\n");
}

function get_trail_section_nodes ($trail_section_id) {
	$query = sprintf("SELECT * FROM trail_section_expanded JOIN noi ON trail_section_expanded.noi_id = noi.noi_id LEFT JOIN trail_branch ON trail_section_expanded.branch_id = trail_branch.branch_id WHERE trail_section_id = %s ORDER BY node_idx",
		mysql_real_escape_string($trail_section_id));
	//~print($query);
	$trail_nodes_result = mysql_query($query);
	return $trail_nodes_result;
}

// EZ MEGEGYEZIK A TRAIL-BEN LÉVŐKKEL - REFAKTORÁLANDÓ !!!

function print_trail_nodetable($trail_nodes_result) {
	print("<table border=1 width=\"100%\">\n");
	print_trail_node_header_row ();
        $first = true;
	while ($trail_node = mysql_fetch_assoc($trail_nodes_result)) {
                if (!$first) {
                    print_trail_node_sect_row ($trail_node);
                }
		print_trail_node_wpt_row ($trail_node, $first);
                $first = false;
	}
	print("</table>\n");
}

function print_trail_node_header_row() {
		print("<tr>" .
			"<th nowrap>ID</th>" . //debug
			"<th nowrap>Idx</th>" .
			"<th nowrap>Pri</th>" .
			"<th nowrap>Útpont</th>" .
                        // szakasz:
                        "<th nowrap>Mod+Jel</th>" .
                        "<th nowrap>Táv</th>" .
                        "<th nowrap>Szint</th>" .
                        "<th nowrap>Idő</th>" .
                        "<th nowrap>Turistautak.hu</th>" .
                        //"<th nowrap>Megjegyzés</th>" .
		"\n</tr>\n");
}

function print_trail_node_sect_row($trail_node) {
        if (!@$trail_node['sect_length_slope'] == 0) {
		print("<tr><td colspan=4></td>" .
			"<td nowrap>" . sprint_modality($trail_node["sect_modality"]) . " ". sprint_trailmark($trail_node["sect_trailmark"]) . "</td>" .
			"<td nowrap>" . sprint_notnull($trail_node['sect_length_slope'], round($trail_node['sect_length_slope']/1000.0, 2) . " km") . "</td>" .
			"<td nowrap>" . sprint_notnull($trail_node['sect_ascent_to'], "+" . round($trail_node['sect_ascent_to'], 0) . "m") . " / " . sprint_notnull($trail_node['sect_ascent_from'], "-" . round($trail_node['sect_ascent_from'], 0) . "m") . "</td>" .
			"<td nowrap>" . sprint_notnull($trail_node['sect_minutes_to'], round($trail_node['sect_minutes_to'], 0) . " p") . "</td>" .
			"<td nowrap>" . sprint_linkto_itinerpage("[itiner]", $trail_node['sect_segments']) . "</td>" .
			//"<td nowrap>" . $trail_node["sect_remark"] . "</td>" .
                      "</tr>\n");
        } else {
            print("<tr><td colspan=4></td></tr>");
        }
}

function print_trail_node_wpt_row($trail_node, $first) {
                $isbranch = ($trail_node["branch_id"] != 0);
		print("<tr>" .
			"<td nowrap>" . $trail_node["trail_node_id"] . "</td>" .
			"<td nowrap>#" . $trail_node["node_idx"] . "</td>" .
			"<td nowrap>" . $trail_node["priority"] . "</td>" .
			"<td nowrap>" . ($isbranch ? sprint_branch_indent(@$trail_node["branch_id"], @$trail_node["sect_length_slope"]) . "<i>" : "") .
			sprint_linkto_noipage($trail_node["name"], @$trail_node["noi_id"]) . " " .
			sprint_linkto_poipage(/*@$trail_node["tuhu_id"]*/ "", @$trail_node["tuhu_id"]) .
			sprint_linkto_map("", $trail_node["lat"], $trail_node["lon"], 1) .
                        sprint_linkto_signpostpages(@$trail_node["noi_id"]) .
                        ($isbranch ? "</i>" : "") .
			"</td>");
                if ($isbranch) {
                    if ($first) {
                      print(
			"<td nowrap class=\"branch_from\">" . sprint_modality($trail_node["branch_modality"]) . " ". sprint_trailmark($trail_node["branch_trailmark"]) . "</td>" .
			"<td nowrap class=\"branch_from\">" . sprint_notnull($trail_node['branch_length_slope'], round($trail_node['branch_length_slope']/1000.0, 2) . " km") . "</td>" .
			"<td nowrap class=\"branch_from\">" . sprint_notnull($trail_node['branch_ascent_from'], "+" . round($trail_node['branch_ascent_from'], 0) . "m") . " / " . sprint_notnull($trail_node['branch_ascent_to'], "-" . round($trail_node['branch_ascent_to'], 0) . "m") . "</td>" .
			"<td nowrap class=\"branch_from\">" . sprint_notnull($trail_node['branch_minutes_from'], round($trail_node['branch_minutes_from'], 0) . " p") . "</td>" .
			"<td nowrap class=\"branch_from\">" . sprint_linkto_itinerpage("[itiner]", $trail_node['branch_segments_rev']) . "</td>" //.
			//"<td nowrap class=\"branch_from\">" . $trail_node["branch_remark"] . "</td>"
                      );
                    } else {
                      print(
			"<td nowrap class=\"branch\">" . sprint_modality($trail_node["branch_modality"]) . " ". sprint_trailmark($trail_node["branch_trailmark"]) . "</td>" .
			"<td nowrap class=\"branch\">" . sprint_notnull($trail_node['branch_length_slope'], round($trail_node['branch_length_slope']/1000.0, 2) . " km") . "</td>" .
			"<td nowrap class=\"branch\">" . sprint_notnull($trail_node['branch_ascent_to'], "+" . round($trail_node['branch_ascent_to'], 0) . "m") . " / " . sprint_notnull($trail_node['branch_ascent_from'], "-" . round($trail_node['branch_ascent_from'], 0) . "m") . "</td>" .
			"<td nowrap class=\"branch\">" . sprint_notnull($trail_node['branch_minutes_to'], round($trail_node['branch_minutes_to'], 0) . " p") . "</td>" .
			"<td nowrap class=\"branch\">" . sprint_linkto_itinerpage("[itiner]", $trail_node['branch_segments']) . "</td>" //.
			//"<td nowrap class=\"branch\">" . $trail_node["branch_remark"] . "</td>"
                      );
                    }
                }
               print("</tr>\n");
}

// DATABASE AND DATA STRUCTURE RELATED FUNCTIONS:

function parse_node_record($nodestr) {

	$node_arr = explode (";", $nodestr);

	// insert a dummy node id if not given
	if (!is_numeric($node_arr[0])) {
		array_unshift($node_arr, "");
	}

	// node_record: [0]: node_id (if present!); [1]: name; [2]: topology_index; [3]: lat; [4]: lon; [5] len
		// TODO: �tpont fontoss�ga - fastrukt�r�hoz; addigi szintemelk., s�lly., menetid� ide-oda, - a t�blarendszerhez
	// (All fields are optional. Noi id can be omitted from front; all others can be omitted from end.)
	$node_record = array(
		'node_id' => @$node_arr[0],
		'name' => @$node_arr[1],
		'topology_index' => @$node_arr[2],
		'lat' => @$node_arr[3],
		'lon' => @$node_arr[4],
		'len' => @$node_arr[5],
		'');
	return $node_record;
}

// DISPLAY RELATED FUNCTIONS:


/*function sprint_trail_nodes ($nodes_str) {
	$nodes_arr = explode ("]", trim($nodes_str));
	$result = "<ul>\n";
	for ($i = 0; $i < count($nodes_arr); $i++) {
		if ($nodes_arr[$i] === "") continue;
		// get rid of leading '[':
		$nodestr = substr_replace(trim($nodes_arr[$i]), "", 0, 1);
		$node_record = parse_node_record($nodestr);

		$result .= "<li>";
		$result .= sprint_linkto_poipage("", @$node_record["node_id"]);
		$result .= sprint_linkto_map($node_record["name"], $node_record["lat"], $node_record["lon"], 1);
		$result .= "</li>\n";
	}
	$result .= "</ul>\n";
	return $result;
}
*/

// !!! ezek vannak a trail section listázásnál is !!! : REFAKTORÁLANDÓ

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
                        "<td>" . (@$from_node_record['name'] ? $from_node_record['name'] : "[eleje]") . "</td>" .
                        "<td>" . (@$to_node_record['name'] ? $to_node_record['name'] : "[vége]") . "</td>" .
                        //param:
                        "<td nowrap>" . $trail_record['param_name'] . " = " . $trail_record['value'] . "</td>" .
                        // hossz:
			"<td nowrap>" . sprint_notnull($trail_record['length_slope'], round($trail_record['length_slope']/1000.0, 2) . " km") . "<br>" .
                             sprint_notnull($trail_record['minutes_to'], sprint_minutes($trail_record['minutes_to'])) . "</td>" .
		"\n</tr>\n");
}

function print_trail_section_table ($trail_section_recordset) {
	print("<table border=1 width=\"100%\">\n");
	print_trail_section_header_row ();
	while ($trail_section_record = mysql_fetch_assoc($trail_section_recordset)) {
		print_trail_section_row ($trail_section_record);
	}
	print("</table>\n");
}

?>
</body>
</html>
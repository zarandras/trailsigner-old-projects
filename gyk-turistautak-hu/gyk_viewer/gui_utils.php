<?php

// DISPLAY RELATED FUNCTIONS:

define('GUI_IMG_DIR', 'gui_img/');
define('TRAILMARK_DIR', 'jelkepek/');

function sprint_trailmark ($trailmark) {
	return ( ($trailmark == null) ? "" : "<img src=\"" . TRAILMARK_DIR . trailmark2filename($trailmark) . ".gif\" alt=\"" . $trailmark . "\" border=0 />");
}

function trailmark2filename ($trailmark) {
    return str_replace('<', 'lt', $trailmark);
}

function sprint_minutes ($minutes) {
    if ($minutes == null) {
        return "";
    }
    $result = "";
    if ($minutes >= 60) {
        $result .= round($minutes / 60) . " ó";
    }
    if ($minutes % 60 != 0) {
        $result .= " " . ($minutes % 60) . " p";
    } else { // ...optional...
        $result .= "ra"; // pl."6 óra"
    }
    return $result;
}

function sprint_length ($length_m) {
    if ($length_m == null) {
        return "";
    }
    $result = "";
    if ($length_m >= 500) {
        $result .= round($length_m / 1000, 1) . " km";
    } else if ($length_m >= 50) {
        $result .= round($length_m / 50) * 50 . " m";
    } else {
        $result .= round($length_m / 5) * 5 . " m";
    }
    return $result;
}

function sprint_modality ($modality) {
	return ( ($modality == null) ? "" : "<img src=\"" . GUI_IMG_DIR . "mod_" . $modality . ".png\" width=15 height=15 alt=\"" . $modality . "\" border=0 />");
}

function sprint_branch_indent ($branch_id, $sect_length_slope) {
	return ( "&nbsp;&nbsp;&nbsp;<img src=\"" . GUI_IMG_DIR . "branch_" . (($sect_length_slope == 0) ? "down" : "up") . ".png\" width=18 height=18 alt=\"[#" . $branch_id . " leágazáson]\" border=0 />&nbsp;" );
}

function sprint_linkto ($text, $dest) {
	return ( ($dest == null) ? $text : "<a href=\"" . $dest . "\">" . $text . "</a>" );
}

function sprint_linkto_itinerpage ($text, $id) {
	return ( ($id == null) ?
		"<img src=\"" . GUI_IMG_DIR . "world_delete.png\" border=0 />" . $text :
		sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "world_go.png\" border=0 />" . $text, "http://turistautak.hu/itiner.php?route=" . $id)
	);
}

function sprint_linkto_routepage ($text, $id) {
	return ( ($id == null) ? 
		"<img src=\"" . GUI_IMG_DIR . "page_delete.png\" border=0 />" . $text : 
		sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "page_go.png\" border=0 />" . $text, "http://turistautak.hu/routes.php?id=" . $id) 
	);
}

function sprint_linkto_routepage_plain ($text, $id) {
	return ( ($id == null) ? 
		$text : 
		sprint_linkto ($text, "http://turistautak.hu/routes.php?id=" . $id) 
	);
}

function sprint_linkto_trailpage ($text, $id) {
	return ( ($id == null) ? 
		"<img src=\"" . GUI_IMG_DIR . "page_delete.png\" border=0 />" . $text : 
		sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "page_go.png\" border=0 />" . $text, "view_trail.php?trail_id=" . $id) 
	);
}

function sprint_linksto_etaps ($trail_id, $etap_values) {
	if ($etap_values == null || $trail_id == 0) {
            return "<img src=\"" . GUI_IMG_DIR . "page_delete.png\" border=0 />";
        }
	return sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "page_go.png\" border=0 />&nbsp;" .
                str_replace(";", "; ", $etap_values),
                "list_trail_sections.php?param_name=etap&trail_id=" . $trail_id);
}

function sprint_linkto_trailpage_plain ($text, $id) {
	return ( ($id == null) ? 
		$text : 
		sprint_linkto ($text, "view_trail.php?trail_id=" . $id) 
	);
}

function sprint_linkto_trailsectionpage_plain ($text, $id) {
	return ( ($id == null) ?
		$text :
		sprint_linkto ($text, "view_trail_section.php?trail_section_id=" . $id)
	);
}

function sprint_linkto_noipage ($text, $id) { // temporary, as soon as view/edit_noi.php is complete it should be linked from here
	return ( ($id == null || $id == 0) ?
		"<img src=\"" . GUI_IMG_DIR . "flag_red.png\" border=0 />" . $text : 
		sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "flag_green.png\" border=0 />" . $text, "list_trails.php?noi=" . $id) 
	);
}

function sprint_linkto_signpostpages ($noi_id) {

        $signpost_results = mysql_query("SELECT * FROM signpost WHERE parent_id IS NULL AND noi_id = " . $noi_id);

        // fetch results:
        $result = "";
        while ($signpost_record = mysql_fetch_assoc($signpost_results)) {
            $result .= sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "signpost.png\" width=20 border=0 />", "view_signpost.php?id=" . $signpost_record['signpost_id']);
        }
	return $result;
}

function sprint_linkto_poipage ($text, $id) {
	return ( ($id == null || $id == 0) ?
		(($text == null) ? "" : "<img src=\"" . GUI_IMG_DIR . "page_delete.png\" border=0 />" . $text ) :
		sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "page_go.png\" border=0 />" . $text, "http://turistautak.hu/poi.php?id=" . $id) 
	);
}

function sprint_linkto_map ($text, $lat, $lon, $arrow) {
	return ( ($lat == null || $lon == null || $lat == 0 || $lon == 0) ?
		(($text == null) ? "" : "<img src=\"" . GUI_IMG_DIR . "world_delete.png\" border=0 />" . $text ) :
		sprint_linkto ("<img src=\"" . GUI_IMG_DIR . "world_go.png\" border=0 />" . $text, 
					   "http://turistautak.hu/maps.php?id=magyarorszag&image=raster&lat=" . $lat. "&lon=" . $lon . "&zoom=256&arrow=" . $arrow) 
	);
}

function sprint_notnull ($testnull, $text) {
	return ( ($testnull == null) ? 
		"<img src=\"" . GUI_IMG_DIR . "cross.png\" border=0 />" : 
		$text 
	);
}

// GUI RELATED UTILITY FUNCTIONS:
function printerr($errtxt) {
	print "<img src=\"" . GUI_IMG_DIR . "cancel.png\" border=0 /> " . $errtxt;
}

?>

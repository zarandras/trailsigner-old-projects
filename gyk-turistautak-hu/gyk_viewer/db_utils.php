<?php

//$result = mysql_query('SELECT COUNT(*) AS db FROM trail');
//$myrow = mysql_fetch_assoc($result);
//echo sprintf('%d db jelzett �t van jelenleg az adatb�zisban:', $myrow['db']);


// DATABASE AND DATA STRUCTURE RELATED FUNCTIONS:

function add_where_clause($where_clause, $condition) {
	if (strcmp($where_clause, "") == 0) {
		return "WHERE " . $condition;
	} else {
		return " AND " . $condition;
	}
}

?>

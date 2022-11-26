<?php

require_once('db_utils.php');

class Trail {

	private $record;

	function __construct($irecord) {
		//$this->record = $irecord;
		$this->setRecord($irecord);
	}
	
	public function getRecord() {
		return $this->record;
	}
	
	public function setRecord($irecord) {
		$this->record = $irecord;
	}

	public function getParams() {
		return $this->record['params'];
	}

	public function setParams($params) {
		$this->record['params'] = $params;
	}
	
	public function getTrailLength () {
		return $this->record['params']['length_slope'];
	}

	public static function query_trails () {
		$query = 'SELECT * FROM trail_bidir';

		// assemble where clause:
		$where_clause = '';
		if (@$_REQUEST['param_name']) {
			if (@$_REQUEST['value']) {
				$where_clause .= add_where_clause($where_clause, 'EXISTS (SELECT * ' .
																	'FROM trail_section ts ' .
																	'WHERE abs(ts.trail_id) = abs(trail_bidir.trail_id) ' .
																		'AND ts.param_name = \'' . mysql_real_escape_string(@$_REQUEST['param_name']) . '\'' .
																		'AND ts.value = \'' . mysql_real_escape_string(@$_REQUEST['value']) . '\'' .
																')');
			} else {
				$where_clause .= add_where_clause($where_clause, 'EXISTS (SELECT * ' .
																	'FROM trail_section ts ' .
																	'WHERE abs(ts.trail_id) = abs(trail_bidir.trail_id) ' .
																		'AND ts.param_name = \'' . mysql_real_escape_string(@$_REQUEST['param_name']) . '\'' .
																')');
			}
		}
		
		// noi relation:
		if (@$_REQUEST['noi']) {
			$where_clause .= add_where_clause($where_clause, 'EXISTS (SELECT * ' .
																'FROM trail_node_bidir '.
																'WHERE trail_bidir.trail_id = trail_node_bidir.trail_id '.
                                                                                                                                '   AND branch_id IS NULL ' .
																'   AND noi_id = ' . mysql_real_escape_string(@$_REQUEST['noi']) .
															')');
		}	
		
		// do not include reverse dirs:
		if (isset($_REQUEST['noreverse'])) {
			$where_clause .= add_where_clause($where_clause, 'trail_id > 0');
		}

                $query .= ' ' . $where_clause;

		if (@$_REQUEST['orderby']) {
		    $query .= ' ORDER BY ' . mysql_real_escape_string($_REQUEST['orderby']);
		} else {
                    $query .= ' ORDER BY trailmark';
                }

		//~print($query);

		$trail_records = mysql_query($query);
		
		// fetch results:
		$trails = array();
		while ($trail_record = mysql_fetch_assoc($trail_records)) {
			$trail_id = $trail_record['trail_id'];
			$trails[$trail_id] = new Trail($trail_record);
			$trails[$trail_id]->setParams(self::query_trail_params($trail_id));			
		}
		//~	print(count($trails));
		
		return $trails;

	}
	
	public static function query_trail ($trail_id) {
		$query = sprintf("SELECT * FROM trail_bidir WHERE trail_id = %s",
			mysql_real_escape_string($trail_id));
		//print($query);
		$trail_recordset = mysql_query($query);
		$trail = new Trail (mysql_fetch_assoc($trail_recordset));
		$trail->setParams(self::query_trail_params($trail_id));
		return $trail;
	}


	public static function query_trail_params ($trail_id) {
		$query = 'SELECT * FROM trail_section_bidir';

		// assemble where clause:
		$where_clause = '';
		$where_clause .= add_where_clause($where_clause, 'trail_id = ' . $trail_id);
		$query .= ' ' . $where_clause;
		//$query .= ' ORDER BY ...';

		//print($query);
		$resultset = mysql_query($query);

		// fetch params
		$trail_params = array();
		while ($trail_param_record = mysql_fetch_assoc($resultset)) {
			if (empty($trail_params[$trail_param_record['from_node_idx']]) && empty($trail_params[$trail_param_record['to_node_idx']])) {
				if (empty($trail_params [$trail_param_record['param_name']])) {
					$trail_params [$trail_param_record['param_name']] = $trail_param_record['value'];
				} else { // concatenate all values into a single string
					$trail_params [$trail_param_record['param_name']] .= ';' . $trail_param_record['value'];
				}
			} else { // partial (section) parameters ignored and notified
				$trail_params['_HAS_PARTIAL'] = true;
			}
		}
		return $trail_params;
	}

}

?>

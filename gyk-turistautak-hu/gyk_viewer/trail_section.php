<?php

require_once('db_utils.php');

class TrailSection {

	private $record;
        private $fromNodeRecord;
        private $toNodeRecord;

	function __construct($irecord) {
		//$this->record = $irecord;
		$this->setRecord($irecord);
	}
	
	public function getRecord() {
		return $this->record;
	}
	
	protected function setRecord($irecord) {
		$this->record = $irecord;
	}

	public function getFromNodeRecord() {
		return $this->fromNodeRecord;
	}

	public function getToNodeRecord() {
		return $this->toNodeRecord;
	}

	public static function query_trail_sections () {
		$query = "SELECT * FROM trail_section_bidir " .
                                    "JOIN trail_bidir USING (trail_id) " .
                                    "JOIN trail_section_stat USING (trail_section_id) ";

		// assemble where clause:
		$where_clause = '';
		if (@$_REQUEST['param_name']) {
                        $where_clause .= add_where_clause($where_clause, 'param_name = \'' . mysql_real_escape_string(@$_REQUEST['param_name']) . '\'');
			if (@$_REQUEST['value']) {
                            $where_clause .= add_where_clause($where_clause, 'value = \'' . mysql_real_escape_string(@$_REQUEST['value']) . '\'');
			}
		}
		if (@$_REQUEST['trail_id']) {
                    $where_clause .= add_where_clause($where_clause, 'trail_section_bidir.trail_id = '. mysql_real_escape_string(@$_REQUEST['trail_id']));
                }
		
                $query .= ' ' . $where_clause;

		if (@$_REQUEST['orderby']) {
		    $query .= ' ORDER BY ' . mysql_real_escape_string($_REQUEST['orderby']);
		} else {
                    $query .= ' ORDER BY param_name, value';
                }

		//~print($query);

		$trail_section_records = mysql_query($query);
		
		// fetch results:
		$trail_sections = array();
		while ($trail_section_record = @mysql_fetch_assoc($trail_section_records)) {
			$trail_section_id = $trail_section_record['trail_section_id'];
			$trail_sections[$trail_section_id] = new TrailSection($trail_section_record);
                        $trail_sections[$trail_section_id]->query_extra_data();
		}
		//~	print(count($trails));
		
		return $trail_sections;

	}

	public static function query_trail_section ($trail_section_id) {
		$query = sprintf("SELECT * FROM trail_section_bidir " .
                                    "JOIN trail_bidir USING (trail_id) " .
                                    "JOIN trail_section_stat USING (trail_section_id) " . 
                                 "WHERE trail_section_id = %s",
			mysql_real_escape_string($trail_section_id));
		//print($query);
		$trail_section_recordset = mysql_query($query);
		$trail_section = new TrailSection (mysql_fetch_assoc($trail_section_recordset));
		$trail_section->query_extra_data();
		return $trail_section;
	}

        public function isOneWay() {
            return (@$this->record['is_oneway'] > 0) ? true : false;
        }

        public function query_extra_data() {
                // from node:
		$query = sprintf("SELECT * FROM trail_node_bidir " .
                                    "LEFT JOIN noi USING (noi_id) " .
                                 "WHERE trail_node_id = %s",
			mysql_real_escape_string($this->record['from_node_id']));
		//print($query);
		$recordset = mysql_query($query);
		$this->fromNodeRecord = @mysql_fetch_assoc($recordset);

                // to node:
                $query = sprintf("SELECT * FROM trail_node_bidir " .
                                    "LEFT JOIN noi USING (noi_id) " .
                                 "WHERE trail_node_id = %s",
			mysql_real_escape_string($this->record['to_node_id']));
		//print($query);
		$recordset = mysql_query($query);
		$this->toNodeRecord = @mysql_fetch_assoc($recordset);
        }

}

?>

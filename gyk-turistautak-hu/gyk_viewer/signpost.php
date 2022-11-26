<?php

require_once('db_utils.php');

class Signpost {

	private $record;
        private $signpost_rows;
        private $child_signposts;

	function __construct($record, $signpost_rows, $child_signposts) {
		$this->setRecord($record);
                $this->setRows($signpost_rows);
                $this->setChildren($child_signposts);
	}
	
        public function getRecord() {
		return $this->record;
	}
	
	public function setRecord($irecord) {
		$this->record = $irecord;
	}

	public function getChildren() {
		return $this->child_signposts;
	}

	public function setChildren($params) {
		$this->child_signposts = $params;
	}
	
	public function getRows() {
		return $this->signpost_rows;
	}

	public function setRows($params) {
		$this->signpost_rows = $params;
	}

        public function getSignpostType() {
            return $this->record['signpost_type'];
        }

        public function getDirectionForDisplay() { // 'J' / 'B'
            if ($this->getSignpostType() != 'utiranyjelzo')
                throw new Exception ("Unsupported signpost type for getDirection!");

            if (!empty($this->record['direction'])) {
                return ($this->record['direction']);
            }
            // no direction given, try to guess by hints:
            $code = $this->record['signpost_code']; // look-for .../u+... .../u-... code format
            if (strpos($code,'/u+') !== FALSE) {
                    return "J";
            }
            if (strpos($code,'/u-') !== FALSE) {
                    return "B";
            }
            return "B"; // default
        }

        public function renderHtml() {
            $result = "<table width='100%'>";
            $result .= "<tr><th>" . $this->record['signpost_type'] . "</th><th>" . $this->record['signpost_code'] . "</th></tr>";
            $result .= "<tr>";

            // display aux.data:
            $result .= "<td width='150'>";
            $result .= "mai: " . $this->record['maintainer'] . "<br>";
            $result .= "spo: " . $this->record['sponsor'] . "<br>";
            $result .= "sta: " . $this->record['status'] . "<br>";
            $result .= "con: " . $this->record['condition'] . "<br>";
            $result .= "mat: " . $this->record['material'] . "<br>";
            $result .= "dir: " . $this->record['direction'] . "<br>";
            $result .= "ang: " . $this->record['angle'] . "<br>";
            $result .= "</td>";

            // display content
            $result .= "<td>";
            switch ($this->getSignpostType()) {
                case 'utiranyjelzo':
                            $dir = $this->getDirectionForDisplay();
                            $count_rows = count($this->signpost_rows);
                            $result .= "<table>";
                            $first_row = true;
                            foreach ($this->signpost_rows as $row_rec) {
                                if ($first_row) {
                                    $global_trailmark = ($row_rec['trailmark']); // valojaban csak a 'head' tipusu sor eseten, de az adatok nem jok...
                                    $result .= "<tr><td width='10%' rowspan=" . $count_rows . ">";
                                    // render left side (if needed, trailmark):
                                    if ($dir == "B") {
                                        $result .= "&lt;&lt;" . sprint_trailmark($global_trailmark);
                                    }
                                    $result .= "</td>";
                                }
                                $result .= "<td" . (empty($row_rec['picto']) ? " colspan=2" : "") . ">";
                                if ($row_rec['has_branchline'] == '1') {
                                    $result .= "<hr>";
                                }
                                // render middle (main content):
                                if ($row_rec['trailmark'] != $global_trailmark) {
                                    $result .= sprint_trailmark($row_rec['trailmark']) . " ";
                                }
                                $result .= $row_rec['content_text'];
                                $result .= (!empty($row_rec['picto']) ? "</td><td width='20%'>" : "");
                                //$result .= "<div style='text-align: right;'>";
                                $result .= $row_rec['picto']; // !!! ->icons !!!
                                //$result .= "</div>";
                                $result .= "</td><td nowrap width='10%' align='right'>";
                                $result .= sprint_length($row_rec['length_slope']);
                                $result .= "<br>";
                                $result .= sprint_minutes($row_rec['minutes_rounded']);
                                $result .= "</td><td width='5%'>";
                                $result .= sprint_modality($row_rec['modality']);
                                $result .= "</td>";
                                // render right side (if needed, trailmark):
                                if ($first_row) {
                                    $result .= "<td width='10%' rowspan=" . $count_rows. ">";
                                    if ($dir != "B") {
                                        $result .= sprint_trailmark($global_trailmark) . "&gt;&gt;";
                                    }
                                    $result .= "</td>";
                                    $first_row = false;
                                }
                                $result .= "</tr>";
                            }
                            $result .= "</table>";
                            break;
                case 'tablaoszlop':
                            foreach ($this->child_signposts as $child) {
                                $result .= $child->renderHtml();
                            }
                            break;

                case 'helymegjelolo':
                            $result .= '<div style="text-align: center;">' . $this->record['content'] . "</div>";
                            break;

                default:
                            $result .= $this->record['content'];
                            break;
            }
            $result .= "</td>";

            $result .= "</tr>";
            $result .= "</table>\n";
            return $result;
        }

        public static function query_signpost ($id) {
		$query = sprintf("SELECT * FROM signpost WHERE signpost_id = %s",
			mysql_real_escape_string($id));
		//print($query);
		$sp_recordset = mysql_query($query);
                $sp_record = mysql_fetch_assoc($sp_recordset);
		return self::make_signpost_fromrec($sp_record);
	}

        public static function make_signpost_fromrec ($sp_record) {
                switch ($sp_record['signpost_type']) {
                    case 'utiranyjelzo':
                                $sp = new Signpost ($sp_record, null, null);
                                $sp->setRows(self::query_signpost_rows($sp_record['signpost_id']));
                                break;
                    case 'tablaoszlop':
                                $sp = new Signpost ($sp_record, null, null);
                                $sp->setChildren(self::query_child_signposts($sp_record['signpost_id']));
                                break;
                    //case 'helymegjelolo':
                    default:
                                $sp = new Signpost ($sp_record, null, null);
                                break;
                }
		return $sp;
	}

	public static function query_signpost_rows ($id) {
		$query = sprintf("SELECT * FROM signpost_row WHERE signpost_id = %s ORDER BY row_idx",
			mysql_real_escape_string($id));

		//print($query);
		$resultset = mysql_query($query);

		// fetch params
		$signpost_rows = array();
		while ($row_record = mysql_fetch_assoc($resultset)) {
                    $signpost_rows[] = $row_record;
		}
		return $signpost_rows;
	}

        public static function query_child_signposts ($id) {
		$query = sprintf("SELECT * FROM signpost WHERE parent_id = %s ORDER BY signpost_id",
			mysql_real_escape_string($id));

		//print($query);
		$resultset = mysql_query($query);

		// fetch children
		$child_signposts = array();
		while ($sp_record = mysql_fetch_assoc($resultset)) {
                    $child_signposts[] = self::make_signpost_fromrec($sp_record);
		}
		return $child_signposts;
        }

}

?>

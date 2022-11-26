<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailSectionStat class.  It uses the code-generated
	 * TrailSectionStatDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailSectionStat columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_stat_list.php AND
	 * trail_section_stat_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionStatListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailSectionStats
		protected $dtgTrailSectionStats;

		// Create QForm Event Handlers as Needed

//		protected function Form_Exit() {}
//		protected function Form_Load() {}
//		protected function Form_PreRender() {}
//		protected function Form_Validate() {}

		protected function Form_Run() {
			// Security check for ALLOW_REMOTE_ADMIN
			// To allow access REGARDLESS of ALLOW_REMOTE_ADMIN, simply remove the line below
			QApplication::CheckRemoteAdmin();
		}

		protected function Form_Create() {
			// Instantiate the Meta DataGrid
			$this->dtgTrailSectionStats = new TrailSectionStatDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailSectionStats->CssClass = 'datagrid';
			$this->dtgTrailSectionStats->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailSectionStats->Paginator = new QPaginator($this->dtgTrailSectionStats);
			$this->dtgTrailSectionStats->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_section_stat_edit.php';
			$this->dtgTrailSectionStats->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_section_stat's properties, or you
			// can traverse down QQN::trail_section_stat() to display fields that are down the hierarchy)
			$this->dtgTrailSectionStats->MetaAddColumn(QQN::TrailSectionStat()->TrailSection);
			$this->dtgTrailSectionStats->MetaAddColumn(QQN::TrailSectionStat()->Trail);
			$this->dtgTrailSectionStats->MetaAddColumn('NodeCount');
			$this->dtgTrailSectionStats->MetaAddColumn('Trailmark');
			$this->dtgTrailSectionStats->MetaAddColumn('Modality');
			$this->dtgTrailSectionStats->MetaAddColumn('LengthProjection');
			$this->dtgTrailSectionStats->MetaAddColumn('LengthSlope');
			$this->dtgTrailSectionStats->MetaAddColumn('AscentTo');
			$this->dtgTrailSectionStats->MetaAddColumn('AscentFrom');
			$this->dtgTrailSectionStats->MetaAddColumn('MinutesTo');
			$this->dtgTrailSectionStats->MetaAddColumn('MinutesFrom');
			$this->dtgTrailSectionStats->MetaAddColumn('Segments');
			$this->dtgTrailSectionStats->MetaAddColumn('Points');
			$this->dtgTrailSectionStats->MetaAddColumn('Remark');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_section_stat_list.tpl.php as the included HTML template file
	TrailSectionStatListForm::Run('TrailSectionStatListForm');
?>
<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailSectionBidir class.  It uses the code-generated
	 * TrailSectionBidirDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailSectionBidir columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_bidir_list.php AND
	 * trail_section_bidir_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionBidirListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailSectionBidirs
		protected $dtgTrailSectionBidirs;

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
			$this->dtgTrailSectionBidirs = new TrailSectionBidirDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailSectionBidirs->CssClass = 'datagrid';
			$this->dtgTrailSectionBidirs->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailSectionBidirs->Paginator = new QPaginator($this->dtgTrailSectionBidirs);
			$this->dtgTrailSectionBidirs->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_section_bidir_edit.php';
			$this->dtgTrailSectionBidirs->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_section_bidir's properties, or you
			// can traverse down QQN::trail_section_bidir() to display fields that are down the hierarchy)
			$this->dtgTrailSectionBidirs->MetaAddColumn('TrailSectionId');
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->Trail);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->FromNode);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->ToNode);
			$this->dtgTrailSectionBidirs->MetaAddColumn('ParamName');
			$this->dtgTrailSectionBidirs->MetaAddColumn('Value');
			$this->dtgTrailSectionBidirs->MetaAddColumn('IsOneway');
			$this->dtgTrailSectionBidirs->MetaAddColumn('WithBranch');
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->RevTrailSection);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->AbsTrailSection);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->TrailSectionStat);
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_section_bidir_list.tpl.php as the included HTML template file
	TrailSectionBidirListForm::Run('TrailSectionBidirListForm');
?>
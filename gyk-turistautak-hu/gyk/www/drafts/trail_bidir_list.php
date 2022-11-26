<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailBidir class.  It uses the code-generated
	 * TrailBidirDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailBidir columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_bidir_list.php AND
	 * trail_bidir_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailBidirListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailBidirs
		protected $dtgTrailBidirs;

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
			$this->dtgTrailBidirs = new TrailBidirDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailBidirs->CssClass = 'datagrid';
			$this->dtgTrailBidirs->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailBidirs->Paginator = new QPaginator($this->dtgTrailBidirs);
			$this->dtgTrailBidirs->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_bidir_edit.php';
			$this->dtgTrailBidirs->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_bidir's properties, or you
			// can traverse down QQN::trail_bidir() to display fields that are down the hierarchy)
			$this->dtgTrailBidirs->MetaAddColumn('TrailId');
			$this->dtgTrailBidirs->MetaAddColumn('TrailCode');
			$this->dtgTrailBidirs->MetaAddColumn('Trailmark');
			$this->dtgTrailBidirs->MetaAddColumn('Modality');
			$this->dtgTrailBidirs->MetaAddColumn('Name');
			$this->dtgTrailBidirs->MetaAddColumn('NameExt');
			$this->dtgTrailBidirs->MetaAddColumn('NameExtRev');
			$this->dtgTrailBidirs->MetaAddColumn('Description');
			$this->dtgTrailBidirs->MetaAddColumn('DescriptionRev');
			$this->dtgTrailBidirs->MetaAddColumn('Remark');
			$this->dtgTrailBidirs->MetaAddColumn('GeodbService');
			$this->dtgTrailBidirs->MetaAddColumn(QQN::TrailBidir()->RevTrail);
			$this->dtgTrailBidirs->MetaAddColumn(QQN::TrailBidir()->AbsTrail);
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_bidir_list.tpl.php as the included HTML template file
	TrailBidirListForm::Run('TrailBidirListForm');
?>
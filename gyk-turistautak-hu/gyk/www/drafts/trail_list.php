<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the Trail class.  It uses the code-generated
	 * TrailDataGrid control which has meta-methods to help with
	 * easily creating/defining Trail columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_list.php AND
	 * trail_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailListForm extends QForm {
		// Local instance of the Meta DataGrid to list Trails
		protected $dtgTrails;

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
			$this->dtgTrails = new TrailDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrails->CssClass = 'datagrid';
			$this->dtgTrails->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrails->Paginator = new QPaginator($this->dtgTrails);
			$this->dtgTrails->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_edit.php';
			$this->dtgTrails->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail's properties, or you
			// can traverse down QQN::trail() to display fields that are down the hierarchy)
			$this->dtgTrails->MetaAddColumn('TrailId');
			$this->dtgTrails->MetaAddColumn('TrailCode');
			$this->dtgTrails->MetaAddColumn('Trailmark');
			$this->dtgTrails->MetaAddColumn('Modality');
			$this->dtgTrails->MetaAddColumn('Name');
			$this->dtgTrails->MetaAddColumn('NameExt');
			$this->dtgTrails->MetaAddColumn('NameExtRev');
			$this->dtgTrails->MetaAddColumn('Description');
			$this->dtgTrails->MetaAddColumn('DescriptionRev');
			$this->dtgTrails->MetaAddColumn('Remark');
			$this->dtgTrails->MetaAddColumn('GeodbService');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_list.tpl.php as the included HTML template file
	TrailListForm::Run('TrailListForm');
?>
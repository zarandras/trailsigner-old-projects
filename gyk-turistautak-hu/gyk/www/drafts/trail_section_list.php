<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailSection class.  It uses the code-generated
	 * TrailSectionDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailSection columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_list.php AND
	 * trail_section_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailSections
		protected $dtgTrailSections;

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
			$this->dtgTrailSections = new TrailSectionDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailSections->CssClass = 'datagrid';
			$this->dtgTrailSections->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailSections->Paginator = new QPaginator($this->dtgTrailSections);
			$this->dtgTrailSections->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_section_edit.php';
			$this->dtgTrailSections->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_section's properties, or you
			// can traverse down QQN::trail_section() to display fields that are down the hierarchy)
			$this->dtgTrailSections->MetaAddColumn('TrailSectionId');
			$this->dtgTrailSections->MetaAddColumn(QQN::TrailSection()->Trail);
			$this->dtgTrailSections->MetaAddColumn(QQN::TrailSection()->FromNode);
			$this->dtgTrailSections->MetaAddColumn(QQN::TrailSection()->ToNode);
			$this->dtgTrailSections->MetaAddColumn('ParamName');
			$this->dtgTrailSections->MetaAddColumn('Value');
			$this->dtgTrailSections->MetaAddColumn('IsOneway');
			$this->dtgTrailSections->MetaAddColumn('WithBranch');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_section_list.tpl.php as the included HTML template file
	TrailSectionListForm::Run('TrailSectionListForm');
?>
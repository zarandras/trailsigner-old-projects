<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the MinutesComputation class.  It uses the code-generated
	 * MinutesComputationDataGrid control which has meta-methods to help with
	 * easily creating/defining MinutesComputation columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both minutes_computation_list.php AND
	 * minutes_computation_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class MinutesComputationListForm extends QForm {
		// Local instance of the Meta DataGrid to list MinutesComputations
		protected $dtgMinutesComputations;

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
			$this->dtgMinutesComputations = new MinutesComputationDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgMinutesComputations->CssClass = 'datagrid';
			$this->dtgMinutesComputations->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgMinutesComputations->Paginator = new QPaginator($this->dtgMinutesComputations);
			$this->dtgMinutesComputations->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/minutes_computation_edit.php';
			$this->dtgMinutesComputations->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for minutes_computation's properties, or you
			// can traverse down QQN::minutes_computation() to display fields that are down the hierarchy)
			$this->dtgMinutesComputations->MetaAddColumn('Modality');
			$this->dtgMinutesComputations->MetaAddColumn('MulLengthSlope');
			$this->dtgMinutesComputations->MetaAddColumn('MulAscent');
			$this->dtgMinutesComputations->MetaAddColumn('MulDescent');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// minutes_computation_list.tpl.php as the included HTML template file
	MinutesComputationListForm::Run('MinutesComputationListForm');
?>
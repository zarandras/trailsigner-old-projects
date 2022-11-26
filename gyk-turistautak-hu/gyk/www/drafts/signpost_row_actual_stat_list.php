<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the SignpostRowActualStat class.  It uses the code-generated
	 * SignpostRowActualStatDataGrid control which has meta-methods to help with
	 * easily creating/defining SignpostRowActualStat columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both signpost_row_actual_stat_list.php AND
	 * signpost_row_actual_stat_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class SignpostRowActualStatListForm extends QForm {
		// Local instance of the Meta DataGrid to list SignpostRowActualStats
		protected $dtgSignpostRowActualStats;

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
			$this->dtgSignpostRowActualStats = new SignpostRowActualStatDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgSignpostRowActualStats->CssClass = 'datagrid';
			$this->dtgSignpostRowActualStats->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgSignpostRowActualStats->Paginator = new QPaginator($this->dtgSignpostRowActualStats);
			$this->dtgSignpostRowActualStats->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/signpost_row_actual_stat_edit.php';
			$this->dtgSignpostRowActualStats->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for signpost_row_actual_stat's properties, or you
			// can traverse down QQN::signpost_row_actual_stat() to display fields that are down the hierarchy)
			$this->dtgSignpostRowActualStats->MetaAddColumn(QQN::SignpostRowActualStat()->SignpostRow);
			$this->dtgSignpostRowActualStats->MetaAddColumn('ContentTextDef');
			$this->dtgSignpostRowActualStats->MetaAddColumn('PictoDef');
			$this->dtgSignpostRowActualStats->MetaAddColumn('LengthSlope');
			$this->dtgSignpostRowActualStats->MetaAddColumn('MinutesTo');
			$this->dtgSignpostRowActualStats->MetaAddColumn('MinutesRounded');
			$this->dtgSignpostRowActualStats->MetaAddColumn('AllTrailmarks');
			$this->dtgSignpostRowActualStats->MetaAddColumn('AllModalities');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// signpost_row_actual_stat_list.tpl.php as the included HTML template file
	SignpostRowActualStatListForm::Run('SignpostRowActualStatListForm');
?>
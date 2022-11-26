<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the SignpostRow class.  It uses the code-generated
	 * SignpostRowDataGrid control which has meta-methods to help with
	 * easily creating/defining SignpostRow columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both signpost_row_list.php AND
	 * signpost_row_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class SignpostRowListForm extends QForm {
		// Local instance of the Meta DataGrid to list SignpostRows
		protected $dtgSignpostRows;

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
			$this->dtgSignpostRows = new SignpostRowDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgSignpostRows->CssClass = 'datagrid';
			$this->dtgSignpostRows->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgSignpostRows->Paginator = new QPaginator($this->dtgSignpostRows);
			$this->dtgSignpostRows->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/signpost_row_edit.php';
			$this->dtgSignpostRows->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for signpost_row's properties, or you
			// can traverse down QQN::signpost_row() to display fields that are down the hierarchy)
			$this->dtgSignpostRows->MetaAddColumn('SignpostRowId');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->Signpost);
			$this->dtgSignpostRows->MetaAddColumn('RowIdx');
			$this->dtgSignpostRows->MetaAddColumn('RowType');
			$this->dtgSignpostRows->MetaAddColumn('HasBranchline');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->Trail);
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->FromNode);
			$this->dtgSignpostRows->MetaAddColumn('OffsetLength');
			$this->dtgSignpostRows->MetaAddColumn('OffsetMinutes');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->ToNode);
			$this->dtgSignpostRows->MetaAddColumn('ContentText');
			$this->dtgSignpostRows->MetaAddColumn('ContentText2');
			$this->dtgSignpostRows->MetaAddColumn('Picto');
			$this->dtgSignpostRows->MetaAddColumn('LengthSlope');
			$this->dtgSignpostRows->MetaAddColumn('MinutesTo');
			$this->dtgSignpostRows->MetaAddColumn('MinutesRounded');
			$this->dtgSignpostRows->MetaAddColumn('Trailmark');
			$this->dtgSignpostRows->MetaAddColumn('Modality');
			$this->dtgSignpostRows->MetaAddColumn('IsHidden');
			$this->dtgSignpostRows->MetaAddColumn('TechRemark');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->SignpostRowActualStat);
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// signpost_row_list.tpl.php as the included HTML template file
	SignpostRowListForm::Run('SignpostRowListForm');
?>